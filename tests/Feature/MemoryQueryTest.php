<?php

namespace Tests\Feature;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\User;
use App\Exports\Trip\BiaccExport;
use App\Exports\Trip\MasterListExport;
use App\Exports\Trip\WhatsappBotExport;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UnregisteredParcelController;
use App\Http\Livewire\Backend\Trip\TripChecklist;
use App\Http\Livewire\Backend\Trip\TripChecklistAll;
use App\Http\Livewire\Backend\TripBatch\TripBatchBulkImport;
use App\Imports\Parcel\BulkPreviewImport;
use App\Imports\Parcel\BulkPreviewSheet;
use App\Models\TripBatch;
use App\Models\Pickup;
use App\Services\BaseService;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Trip\TripHelperService;
use App\Services\TripBatch\TripBatchHelperService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\CreatesApplication;

class MemoryQueryTest extends TestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        Schema::create('offices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->boolean('is_drop_point')->default(true);
            $table->string('whatsapp_template')->nullable();
        });
        Schema::create('trip_batches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id')->default(1);
            $table->boolean('is_closed')->default(false);
            $table->date('date')->nullable();
        });
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trip_batch_id');
            $table->integer('destination_id')->default(1);
            $table->integer('status')->default(0);
            $table->integer('runner_id')->nullable();
            $table->timestamps();
        });
        Schema::create('pickups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trip_id');
            $table->integer('office_id')->default(1);
            $table->integer('user_id')->nullable();
            $table->string('code')->nullable();
            $table->integer('status')->default(0);
            $table->softDeletes();
        });
        Schema::create('parcels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pickup_id');
            $table->integer('office_id')->default(1);
            $table->integer('user_id')->nullable();
            $table->integer('status')->default(0);
            $table->string('tracking_no')->nullable();
            foreach (['code', 'guni', 'receiver_name', 'phone_number', 'description', 'categories'] as $column) {
                $table->string($column)->nullable();
            }
            $table->decimal('price')->default(0);
            $table->decimal('percent')->default(0);
            $table->boolean('checked')->nullable()->default(false);
            $table->decimal('tax')->default(0);
            $table->decimal('cod_fee')->default(0);
            $table->decimal('service_charge')->default(0);
            $table->decimal('permit')->default(0);
            $table->decimal('declare_charge')->default(0);
            $table->timestamps();
        });
        Schema::create('unregistered_parcels', function (Blueprint $table) {
            $table->increments('id');
        });
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->string('type');
            $table->softDeletes();
        });
        Schema::create('memory_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id');
            $table->boolean('active');
            $table->softDeletes();
        });
        DB::table('offices')->insert(['id' => 1, 'code' => 'HQ', 'name' => 'HQ']);
    }

    public function test_service_count_preserves_filters_scopes_limit_and_reset_without_hydrating()
    {
        DB::table('memory_records')->insert([
            ['office_id' => 1, 'active' => 1, 'deleted_at' => null],
            ['office_id' => 1, 'active' => 1, 'deleted_at' => null],
            ['office_id' => 1, 'active' => 0, 'deleted_at' => null],
            ['office_id' => 2, 'active' => 1, 'deleted_at' => null],
            ['office_id' => 1, 'active' => 1, 'deleted_at' => '2026-01-01'],
        ]);
        MemoryRecord::addGlobalScope('office', fn ($query) => $query->where('office_id', 1));
        $hydrated = 0;
        MemoryRecord::retrieved(function () use (&$hydrated) { $hydrated++; });
        $service = new MemoryRecordService;
        $this->assertSame(1, $service->whereIn('id', [1, 2, 3, 4, 5])->onlyActive()->limit(1)->count());
        $this->assertSame(2, $service->where('active', 1)->count());
        $this->assertSame(3, $service->count(), 'Per-call clauses and scopes must reset.');
        $this->assertSame(0, $hydrated);
    }

    public function test_trip_code_count_keeps_destination_filter_without_loading_trips()
    {
        DB::table('trips')->insert([
            ['trip_batch_id' => 1, 'destination_id' => 1],
            ['trip_batch_id' => 2, 'destination_id' => 1],
            ['trip_batch_id' => 3, 'destination_id' => 2],
        ]);
        $hydrated = 0;
        Trip::retrieved(function () use (&$hydrated) { $hydrated++; });
        $this->assertStringEndsWith('/3', generateTripCode(1, '2026-10-22'));
        $this->assertSame(0, $hydrated);
    }

    private function seedBatchParcels(): TripBatch
    {
        DB::table('trip_batches')->insert([['id' => 1], ['id' => 2]]);
        DB::table('trips')->insert([
            ['id' => 1, 'trip_batch_id' => 1],
            ['id' => 2, 'trip_batch_id' => 1],
            ['id' => 3, 'trip_batch_id' => 2],
        ]);
        DB::table('pickups')->insert([
            ['id' => 1, 'trip_id' => 1, 'deleted_at' => null],
            ['id' => 2, 'trip_id' => 2, 'deleted_at' => null],
            ['id' => 3, 'trip_id' => 3, 'deleted_at' => null],
            ['id' => 4, 'trip_id' => 1, 'deleted_at' => '2026-01-01'],
        ]);
        for ($i = 1; $i <= 120; $i++) {
            DB::table('parcels')->insert(['pickup_id' => $i <= 60 ? 1 : 2, 'checked' => $i <= 30, 'tracking_no' => 'IN'.$i]);
        }
        DB::table('parcels')->insert([
            ['pickup_id' => 3, 'checked' => 1, 'tracking_no' => 'OUTSIDE'],
            ['pickup_id' => 4, 'checked' => 1, 'tracking_no' => 'DELETED-PICKUP'],
        ]);
        return TripBatch::findOrFail(1);
    }

    public function test_checklist_pagination_totals_search_and_reset_stay_inside_batch()
    {
        $batch = $this->seedBatchParcels();
        $component = new TripChecklistAll;
        $component->tripBatch = $batch;
        $page = $component->render()->getData()['parcels'];
        $this->assertSame(120, $component->total);
        $this->assertSame(30, $component->checked);
        $this->assertSame(90, $component->unchecked);
        $this->assertCount(50, $page);
        $this->assertSame(120, $page->total());
        $component->tracking_no = 'IN120';
        $component->search();
        $this->assertSame(1, (int) DB::table('parcels')->where('tracking_no', 'IN120')->value('checked'));
        $component->tracking_no = 'OUTSIDE';
        $component->search();
        $component->resetList();
        $this->assertSame(0, DB::table('parcels')->whereIn('pickup_id', [1, 2])->where('checked', true)->count());
        $this->assertSame(2, DB::table('parcels')->whereIn('pickup_id', [3, 4])->where('checked', true)->count());

        $single = new TripChecklist;
        $single->trip = Trip::findOrFail(1);
        $this->assertSame(60, $single->render()->getData()['parcels']->total());
        $single->resetList();
    }

    public function test_export_queries_keep_batch_optional_trip_and_soft_delete_filters()
    {
        $batch = $this->seedBatchParcels();
        foreach ([new MasterListExport($batch), new BiaccExport($batch)] as $export) {
            $this->assertSame(120, $export->query()->count());
            $this->assertSame(range(1, 120), $export->query()->pluck('parcels.id')->all());
            $this->assertSame($export instanceof MasterListExport ? 1000 : 200, $export->chunkSize());
        }
        $this->assertSame([1, 2], (new WhatsappBotExport($batch))->query()->pluck('id')->all());
        $this->assertSame([2], (new WhatsappBotExport($batch, 2))->query()->pluck('id')->all());
        $this->assertSame([], (new WhatsappBotExport($batch, 3))->query()->pluck('id')->all());
    }

    public function test_unregistered_list_is_paginated()
    {
        for ($i = 1; $i <= 75; $i++) { DB::table('unregistered_parcels')->insert(['id' => $i]); }
        $page = (new UnregisteredParcelController)->index()->getData()['unregisteredParcels'];
        $this->assertSame(75, $page->total());
        $this->assertCount(50, $page);
        $this->assertSame(75, $page->first()->id);
    }

    public function test_bulk_customer_search_is_bounded_and_preserves_type_and_deleted_scopes()
    {
        for ($i = 1; $i <= 35; $i++) {
            DB::table('users')->insert(['id' => $i, 'type' => 'user', 'name' => 'Customer '.$i, 'phone_number' => 'P'.$i]);
        }
        DB::table('users')->insert([
            ['id' => 36, 'type' => 'admin', 'name' => 'Admin', 'phone_number' => 'MATCH', 'deleted_at' => null],
            ['id' => 37, 'type' => 'user', 'name' => 'Deleted', 'phone_number' => 'MATCH', 'deleted_at' => '2026-01-01'],
        ]);
        $component = new TripBatchBulkImport;
        $component->parcels = [['customer_id' => 35], ['customer_id' => 36], ['customer_id' => 37]];
        $customers = $component->render()->getData()['customers'];
        $this->assertCount(26, $customers);
        $this->assertContains(35, $customers->pluck('id')->all());
        $this->assertNotContains(36, $customers->pluck('id')->all());
        $this->assertNotContains(37, $customers->pluck('id')->all());
        $component->customerSearch = 'P30';
        $this->assertSame([30, 35], $component->render()->getData()['customers']->pluck('id')->values()->all());
        $component->setErrorBag(['file' => ['Existing upload error']]);
        $component->customerSearch = 'MATCH';
        $this->assertSame([35], $component->render()->getData()['customers']->pluck('id')->values()->all());
        $this->assertTrue($component->getErrorBag()->has('file'));
    }

    private function loginForDashboard(string $ability): void
    {
        $user = \Mockery::mock(User::class)->makePartial();
        $user->setRawAttributes(['id' => 1, 'type' => 'admin', 'office_id' => 1]);
        $user->shouldReceive('can')->andReturnUsing(fn ($name) => $name === $ability);
        $user->shouldReceive('hasRole')->with('Administrator')->andReturn(false);
        auth()->setUser($user);
    }

    public function test_distributor_dashboard_keeps_office_status_filters_and_counts_without_parcel_hydration()
    {
        $this->loginForDashboard('staff.distributor');
        for ($i = 1; $i <= 32; $i++) {
            DB::table('trip_batches')->insert(['id' => $i, 'office_id' => $i === 31 ? 2 : 1]);
            DB::table('trips')->insert(['id' => $i, 'trip_batch_id' => $i,
                'status' => $i === 32 ? TripHelperService::STATUS_CLOSED : TripBatchHelperService::STATUS_PENDING]);
            DB::table('pickups')->insert(['id' => $i, 'trip_id' => $i]);
            DB::table('parcels')->insert(['pickup_id' => $i]);
        }
        $hydrated = 0;
        Parcels::retrieved(function () use (&$hydrated) { $hydrated++; });
        $data = (new DashboardController)->index()->getData();
        $page = $data['trip_batches'];
        $this->assertSame(30, $page->total());
        $this->assertCount(25, $page);
        $this->assertSame(1, $page->first()->parcels_count);
        $this->assertFalse($page->first()->relationLoaded('parcels'));
        $this->assertSame(0, $hydrated);
    }

    public function test_runner_dashboard_keeps_status_filters_and_full_summary_totals()
    {
        $this->loginForDashboard('staff.runner');
        for ($i = 1; $i <= 55; $i++) {
            DB::table('trip_batches')->insert(['id' => $i]);
            DB::table('trips')->insert(['id' => $i, 'trip_batch_id' => $i,
                'status' => $i <= 28 ? TripHelperService::STATUS_CLOSED : TripBatchHelperService::STATUS_IN_TRANSIT]);
            DB::table('pickups')->insert(['id' => $i, 'trip_id' => $i]);
            DB::table('parcels')->insert(['pickup_id' => $i]);
        }
        $data = (new DashboardController)->index()->getData();
        $this->assertSame(28, $data['closed_trips']->total());
        $this->assertSame(27, $data['picked_trips']->total());
        $this->assertCount(25, $data['closed_trips']);
        $this->assertCount(25, $data['picked_trips']);
        $this->assertSame(1, $data['closed_trips']->first()->trips_count);
        $this->assertSame(1, $data['picked_trips']->first()->parcels_count);
        $this->assertSame(1, $data['picked_trips']->first()->trips->first()->parcels_count);
        $this->assertNotSame($data['closed_trips']->getPageName(), $data['picked_trips']->getPageName());
    }

    public function test_biacc_dashboard_keeps_office_and_closed_filters()
    {
        $this->loginForDashboard('staff.biacc');
        DB::table('offices')->insert(['id' => 2, 'code' => 'MYY', 'name' => 'Miri']);
        DB::table('trip_batches')->insert([
            ['id' => 1, 'office_id' => 2, 'is_closed' => 1],
            ['id' => 2, 'office_id' => 2, 'is_closed' => 0],
            ['id' => 3, 'office_id' => 1, 'is_closed' => 1],
        ]);
        $batches = (new DashboardController)->index()->getData()['trip_batches'];
        $this->assertSame([1], $batches->pluck('id')->all());
    }

    public function test_master_export_writes_all_chunks_headers_numbering_and_tax_footer()
    {
        $batch = $this->seedBatchParcels();
        for ($i = 1; $i <= 885; $i++) {
            DB::table('parcels')->insert(['pickup_id' => 1, 'tracking_no' => 'EXTRA'.$i]);
        }
        DB::table('parcels')->whereIn('pickup_id', [1, 2])->update(['tax' => 1]);
        DB::table('users')->insert(['id' => 1, 'name' => 'Customer', 'phone_number' => '60123456789', 'type' => 'user']);
        DB::table('pickups')->where('id', 1)->update(['code' => 'PICKUP-1']);
        DB::table('parcels')->where('id', 1)->update([
            'user_id' => 1, 'code' => '001', 'guni' => 'BAG-1',
            'receiver_name' => 'Receiver', 'phone_number' => '60111222333',
            'description' => 'Fragile items', 'categories' => '["Clothes","Books"]',
            'price' => 12.5, 'percent' => 5, 'service_charge' => 2.5,
        ]);
        auth()->setUser(new User(['type' => 'admin']));
        DB::enableQueryLog();
        $contents = Excel::raw(new MasterListExport($batch), \Maatwebsite\Excel\Excel::XLSX);
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        $file = tempnam(sys_get_temp_dir(), 'sampai-export-');
        try {
            file_put_contents($file, $contents);
            $workbook = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $sheet = $workbook->getActiveSheet();
            $this->assertSame('Trip ID', $sheet->getCell('A1')->getValue());
            $this->assertSame('No.', $sheet->getCell('A5')->getValue());
            $this->assertSame(1, $sheet->getCell('A6')->getValue());
            $this->assertSame(1005, $sheet->getCell('A1010')->getValue());
            $this->assertSame('EXTRA885', $sheet->getCell('C1010')->getValue());
            $this->assertSame('Total Tax:'.displayPriceFormat(1005, '$'), $sheet->getCell('H1011')->getValue());
            $this->assertSame([
                1, 1, 'IN1', 'PICKUP-1/001', 'BAG-1', 'Receiver', 60111222333,
                'Fragile items', "Clothes,\nBooks,\n", 'HQ', 12.5, 5.0, 1.0, 2.5,
                (new Parcels(['status' => 0]))->status_label, null, 60123456789, null,
            ], $sheet->rangeToArray('A6:R6', null, false, false)[0]);
            $this->assertNull($sheet->getCell('B7')->getValue(), 'A missing user must remain blank.');
            $this->assertSame('R', $sheet->getHighestDataColumn());
            $this->assertSame(1011, $sheet->getHighestDataRow());
            foreach (range('A', 'R') as $column) {
                $this->assertFalse($sheet->getColumnDimension($column)->getAutoSize());
                $this->assertGreaterThan(0, $sheet->getColumnDimension($column)->getWidth());
            }
            $this->assertSame(40.0, $sheet->getColumnDimension('M')->getWidth());
            $this->assertTrue($sheet->getStyle('M6')->getAlignment()->getWrapText());
            $parcelQueries = collect($queries)->filter(fn ($entry) => str_contains($entry['query'], 'from "parcels"'));
            $this->assertCount(2, $parcelQueries);
            foreach ($parcelQueries as $entry) {
                $this->assertStringContainsString('limit 1000', $entry['query']);
                $this->assertStringStartsWith('select "id", "pickup_id",', $entry['query']);
            }
            $workbook->disconnectWorksheets();
        } finally {
            unlink($file);
        }
    }

    public function test_master_export_mapping_uses_loaded_relations_without_extra_queries()
    {
        $batch = $this->seedBatchParcels();
        DB::table('users')->insert(['id' => 1, 'name' => 'Customer', 'phone_number' => '60123456789', 'type' => 'user']);
        DB::table('parcels')->where('id', 1)->update(['user_id' => 1]);
        DB::table('parcels')->where('id', 2)->update(['office_id' => 999]);
        auth()->setUser(new User(['type' => 'admin']));
        $export = new MasterListExport($batch);
        $parcels = $export->query()->get();
        DB::enableQueryLog();
        DB::flushQueryLog();
        foreach ($parcels as $parcel) {
            $row = $export->map($parcel);
            $this->assertFalse($parcel->pickup->relationLoaded('dropPoint'));
            if ($parcel->id === 1) {
                $this->assertFalse($parcel->user->relationLoaded('roles'));
                $this->assertFalse($parcel->user->relationLoaded('permissions'));
                $this->assertSame('60123456789', $row[16]);
            }
            if ($parcel->id === 2) {
                $this->assertNull($row[9]);
            }
        }
        $this->assertSame([], DB::getQueryLog(), 'Mapping must not issue per-parcel queries.');
        DB::disableQueryLog();

        // The coding accessor needs pickup status as well as its code for customers.
        auth()->setUser(new User(['type' => User::TYPE_USER]));
        $parcel = $parcels->first();
        $parcel->code = '001';
        $parcel->pickup->code = 'PICKUP-1';
        $this->assertSame('- NOT READY -', $export->map($parcel)[3]);
        $parcel->pickup->status = \App\Services\Pickup\PickupHelperService::STATUS_READY_TO_DELIVER;
        $this->assertSame('PICKUP-1/001', $export->map($parcel)[3]);
    }

    public function test_bulk_preview_matches_customers_with_type_and_soft_delete_scopes()
    {
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Admin', 'phone_number' => '0123', 'type' => 'admin', 'deleted_at' => null],
            ['id' => 2, 'name' => 'Deleted', 'phone_number' => '0123', 'type' => 'user', 'deleted_at' => '2026-01-01'],
            ['id' => 3, 'name' => 'Customer', 'phone_number' => '0123', 'type' => 'user', 'deleted_at' => null],
        ]);
        $spreadsheet = new Spreadsheet;
        $spreadsheet->getActiveSheet()->fromArray([
            ['tracking', 'name', 'phone', 'destination'],
            ['TRACK1', 'Example', '0123', 'HQ'],
        ]);
        $file = tempnam(sys_get_temp_dir(), 'sampai-preview-');
        try {
            (new Xlsx($spreadsheet))->save($file);
            $component = new TripBatchBulkImport;
            $component->file = new \Illuminate\Http\UploadedFile($file, 'preview.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);
            $component->viewData();
            $this->assertSame(3, $component->parcels[0]['customer_id']);
            $this->assertSame('Customer', $component->parcels[0]['actual_name']);
            $this->assertSame('HQ', $component->parcels[0]['destination']);
            $this->assertSame('TRACK1', $component->parcels[0]['tracking']);
        } finally {
            unlink($file);
            $spreadsheet->disconnectWorksheets();
        }
    }

    public function test_bulk_preview_reads_multiple_chunks_and_only_first_sheet()
    {
        $spreadsheet = new Spreadsheet;
        $rows = [['tracking', 'name', 'phone', 'destination']];
        for ($i = 1; $i <= 205; $i++) { $rows[] = ['TRACK'.$i, 'Customer', '0123', 'HQ']; }
        $spreadsheet->getActiveSheet()->fromArray($rows);
        $spreadsheet->createSheet()->fromArray([['ignored'], ['invalid header']]);
        $file = tempnam(sys_get_temp_dir(), 'sampai-import-');
        try {
            (new Xlsx($spreadsheet))->save($file);
            $import = new BulkPreviewImport;
            Excel::import($import, $file, null, \Maatwebsite\Excel\Excel::XLSX);
            $this->assertCount(205, $import->sheet->rows);
            $this->assertSame('TRACK205', $import->sheet->rows[204][0]);
        } finally {
            unlink($file);
            $spreadsheet->disconnectWorksheets();
        }
    }

    public function test_bulk_preview_accepts_exactly_500_rows_and_rejects_501_from_workbook()
    {
        foreach ([500, 501] as $count) {
            $spreadsheet = new Spreadsheet;
            $rows = array_merge([['tracking', 'name', 'phone', 'destination']], array_fill(0, $count, ['A', 'B', 'C', 'D']));
            $spreadsheet->getActiveSheet()->fromArray($rows);
            $file = tempnam(sys_get_temp_dir(), 'sampai-boundary-');
            try {
                (new Xlsx($spreadsheet))->save($file);
                $import = new BulkPreviewImport;
                try {
                    Excel::import($import, $file, null, \Maatwebsite\Excel\Excel::XLSX);
                    $this->assertSame(500, $count, 'An oversized workbook must raise a validation error.');
                    $this->assertCount(500, $import->sheet->rows);
                } catch (ValidationException $exception) {
                    $this->assertSame(501, $count);
                    $this->assertArrayHasKey('file', $exception->errors());
                }
            } finally {
                unlink($file);
                $spreadsheet->disconnectWorksheets();
            }
        }
    }

    public function test_other_exports_keep_their_headers_and_rows()
    {
        $batch = $this->seedBatchParcels();
        auth()->setUser(new User(['type' => 'admin']));
        foreach ([new BiaccExport($batch), new WhatsappBotExport($batch, 2)] as $export) {
            $contents = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);
            $file = tempnam(sys_get_temp_dir(), 'sampai-other-export-');
            try {
                file_put_contents($file, $contents);
                $workbook = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
                $sheet = $workbook->getActiveSheet();
                $this->assertSame('Trip ID', $sheet->getCell('A1')->getValue());
                $this->assertSame('No.', $sheet->getCell('A5')->getValue());
                $this->assertSame(1, $sheet->getCell('A6')->getValue());
                $this->assertSame($export instanceof BiaccExport ? 125 : 6, $sheet->getHighestRow());
                $workbook->disconnectWorksheets();
            } finally { unlink($file); }
        }
    }

    public function test_whatsapp_export_reuses_billing_totals_and_preserves_message_templates()
    {
        $batch = $this->seedBatchParcels();
        $template = 'Hello :name; :pickup_code; Total :total_billing; Price :price; Point :pickup_point; Tax :tax; Permit :permit; Count :total_parcel';
        DB::table('offices')->where('id', 1)->update(['whatsapp_template' => $template]);
        DB::table('users')->insert(['id' => 1, 'name' => 'Customer', 'phone_number' => '60123456789', 'type' => 'user']);
        DB::table('pickups')->whereIn('id', [1, 2])->update(['user_id' => 1, 'code' => 'PICKUP-1', 'status' => 2]);
        DB::table('parcels')->whereIn('pickup_id', [1, 2])->update([
            'cod_fee' => 1, 'service_charge' => 4, 'tax' => 2, 'permit' => 3, 'declare_charge' => 5,
        ]);
        // An empty pickup with missing relations must still export zero totals.
        DB::table('pickups')->insert(['id' => 5, 'trip_id' => 1, 'office_id' => 999, 'user_id' => 999, 'code' => 'EMPTY']);
        $expected = [];
        foreach (Pickup::with(['user' => fn ($query) => $query->without(['roles', 'permissions'])])->whereIn('id', [1, 2, 5])->get() as $pickup) {
            $expected[$pickup->id] = [
                displayPriceFormat($pickup->total, '$'),
                ParcelHelperService::GeneralWhatsappText($pickup, [1 => $template]),
            ];
        }

        $export = new WhatsappBotExport($batch);
        $pickups = $export->query()->get();
        $this->assertSame([1, 2, 5], $pickups->pluck('id')->all());
        $this->assertSame(60, $pickups->first()->parcels_count);
        $this->assertEquals(900, $pickups->first()->export_total);
        DB::enableQueryLog();
        DB::flushQueryLog();
        foreach ($pickups as $pickup) {
            $row = $export->map($pickup);
            $this->assertSame($expected[$pickup->id], [$row[5], $row[9]]);
            $this->assertFalse($pickup->relationLoaded('parcels'));
            if ($pickup->user) {
                $this->assertSame('Customer', $row[2]);
                $this->assertSame('60123456789', $row[8]);
                $this->assertFalse($pickup->user->relationLoaded('roles'));
            }
        }
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        $this->assertCount(1, $queries, 'Mapping should only load office templates once, without per-pickup queries.');
        $this->assertStringContainsString('from "offices"', $queries[0]['query']);
    }

    public function test_whatsapp_workbook_keeps_all_chunks_and_limits_database_queries()
    {
        $batch = $this->seedBatchParcels();
        DB::table('users')->insert(['id' => 1, 'name' => 'Customer', 'phone_number' => '60123456789', 'type' => 'user']);
        DB::table('pickups')->whereIn('id', [1, 2])->update(['user_id' => 1, 'code' => 'ORIGINAL']);
        for ($i = 1; $i <= 999; $i++) {
            DB::table('pickups')->insert(['trip_id' => 1, 'user_id' => 1, 'code' => 'EXTRA'.$i]);
        }
        DB::enableQueryLog();
        DB::flushQueryLog();
        $contents = Excel::raw(new WhatsappBotExport($batch), \Maatwebsite\Excel\Excel::XLSX);
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        $this->assertLessThanOrEqual(7, count($queries), 'Queries must scale with chunks, not pickup rows.');
        $pickupQueries = collect($queries)->filter(fn ($entry) => str_contains($entry['query'], 'from "pickups"'));
        $this->assertCount(2, $pickupQueries);
        foreach ($pickupQueries as $entry) {
            $this->assertStringContainsString('limit 1000', $entry['query']);
        }
        $file = tempnam(sys_get_temp_dir(), 'sampai-whatsapp-export-');
        try {
            file_put_contents($file, $contents);
            $workbook = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $sheet = $workbook->getActiveSheet();
            $this->assertSame('Message', $sheet->getCell('J5')->getValue());
            $this->assertSame(1, $sheet->getCell('A6')->getValue());
            $this->assertSame(1001, $sheet->getCell('A1006')->getValue());
            $this->assertSame('EXTRA999', $sheet->getCell('D1006')->getValue());
            $this->assertSame('Customer', $sheet->getCell('C1006')->getValue());
            $this->assertSame(displayPriceFormat(0, '$'), $sheet->getCell('F1006')->getValue());
            $this->assertSame('Pickup code:  EXTRA999', $sheet->getCell('J1006')->getValue());
            $this->assertSame('J', $sheet->getHighestDataColumn());
            $this->assertSame(1006, $sheet->getHighestDataRow());
            foreach (range('A', 'J') as $column) {
                $this->assertFalse($sheet->getColumnDimension($column)->getAutoSize());
            }
            $this->assertTrue($sheet->getStyle('J6')->getAlignment()->getWrapText());
            $workbook->disconnectWorksheets();
        } finally {
            unlink($file);
        }
    }

    public function test_modified_blade_templates_compile_to_valid_php()
    {
        $views = [
            'backend/dashboard-runner', 'backend/dashboard-distributor', 'backend/dashboard-biacc',
            'backend/unregistered_parcel/index', 'livewire/backend/trip/trip-checklist',
            'livewire/backend/trip/trip-checklist-all', 'livewire/backend/trip-batch/trip-batch-bulk-import',
        ];
        foreach ($views as $view) {
            $compiled = app('blade.compiler')->compileString(file_get_contents(resource_path('views/'.$view.'.blade.php')));
            token_get_all($compiled, TOKEN_PARSE);
            $this->addToAssertionCount(1);
        }
    }

    public function test_bulk_preview_rejects_oversized_input_instead_of_truncating()
    {
        $sheet = new BulkPreviewSheet;
        $sheet->collection(collect([['tracking', 'name', 'phone', 'destination']]));
        $sheet->collection(collect(array_fill(0, 500, ['A', 'B', 'C', 'D'])));
        $this->expectException(ValidationException::class);
        $sheet->collection(collect([['EXTRA', 'B', 'C', 'D']]));
    }
}

class MemoryRecord extends Model
{
    use SoftDeletes;
    protected $table = 'memory_records';
    public function scopeOnlyActive($query) { return $query->where('active', true); }
}

class MemoryRecordService extends BaseService
{
    public function __construct() { $this->model = new MemoryRecord; }
    public function onlyActive() { $this->scopes['onlyActive'] = []; return $this; }
}
