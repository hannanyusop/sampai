<div>
    <div class="nk-block">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <div class="card-title">
                                <h6 class="title"><span class="mr-2">Bulk Upload</span></h6>
                            </div>
                            <div class="card-tools">
                                <button wire:click="downloadTemplate" class="btn btn-success">Download Template</button>
                            </div>
                        </div>
                        <div class="form-validate">

                            Available Destination (Use Code): <br>
                            @foreach($offices as $office)
                                <span class="badge badge-primary"><b>{{ $office->code }}</b> - {{ $office->name }}</span>
                            @endforeach
                            <div class="row mt-2">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="invoice">Invoice</label>
                                        <div class="form-control-wrap">
                                            <input type="file" id="invoice" name="file" wire:model="file">
                                            @error('file')
                                                <br><small id="fv-invoice-error" class="invalid text-danger font-weight-bold"><span class="ni ni-alert-circle"></span>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button wire:click="viewData()" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card card-bordered p-5">
                    @if($file)
                        <div class="overflow-auto">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="w-1/12">No</th>
                                    @foreach($header as $title)
                                        <th class="w-2/12">{{ ucfirst($title) }}</th>
                                    @endforeach
                                    <th>User</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($parcels as $id => $parcel)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @foreach($header as $key)
                                            <td>
                                                @if($key == 'destination')
                                                    <select wire:model="parcels.{{ $id }}.destination" class="form-control">
                                                        <option> -- Select Customer -- </option>
                                                        @foreach($offices as  $office)
                                                            <option value="{{ $office->code }}">{{ $office->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('parcels.'.$id.'.destination')
                                                    <small id="fv-invoice-error" class="invalid text-danger font-weight-bold"><span class="ni ni-alert-circle"></span>{{ $message }}</small>
                                                    @enderror
                                                @else
                                                    {{ strtoupper($parcel[$key] ?? "") }}

                                                    @if($key == 'tracking')
                                                        @error('parcels.'.$id.'.tracking')
                                                            <br><small id="fv-invoice-error" class="invalid text-danger font-weight-bold"><span class="ni ni-alert-circle"></span>{{ $message }}</small>
                                                        @enderror
                                                    @endif
                                                @endif
                                            </td>
                                        @endforeach
                                        <td>
                                            <select wire:model="parcels.{{ $id }}.customer_id" class="form-control">
                                                <option> -- Select Customer -- </option>
                                                @foreach($customers as  $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>

                                            @error('parcels.'.$id.'.customer_id')
                                                <small id="fv-invoice-error" class="invalid text-danger font-weight-bold"><span class="ni ni-alert-circle"></span>{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5 text-right">
                            <button
                                wire:click="clearAction"
                                class="mr-1 btn btn-warning"

                            >
                                Clear
                            </button>
                            <button
                                type="button"
                                wire:click="storeAction"
                                class="btn btn-success"
                            >
                                Insert Data
                            </button>
                        </div>
                    @endif
                </div>
            </div><!-- .col -->
        </div>
    </div>
</div>
