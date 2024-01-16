<div>
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-md-12">

                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Trip List</h5>
                            </div>
                            <form action="#" id="trip">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="trip_no">Trip No</label>
                                            <div class="form-control-wrap">
                                                <input id="code" name="code" type="text" class="form-control" wire:model="tripBatchId" placeholder="Ex: LES-11111-1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                @foreach(\App\Services\TripBatch\TripBatchHelperService::getStatuses() as $key => $status)
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="status[]" value="{{ $key }}" wire:model="statuses" id="status_{{ $key }}">
                                                            <label class="custom-control-label" for="status_{{ $key }}">{{ $status }}</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-bordered">
                        <div class="card-inner p-0 border-top">

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Trip No.</th>
                                        <th>Receiver Office</th>
                                        <th>Date</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($batches as $key => $batch)
                                        <tr>
                                            <td>{{ $batch->number }}</td>
                                            <td>{{ __(":code - :name", ["code" => $batch?->office?->code, "name" => $batch?->office?->name]) }}</td>
                                            <td>{{ $batch->date }}</td>
                                            <td>{{ $batch?->creator->name }}</td>
                                            <td>{{ $batch->status_name }}</td>
                                            <td>
                                                <a href="{{ route('admin.tripBatch.show', $batch) }}">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div><!-- .card -->
                </div>
            </div>
        </div>

    </div>
</div>
