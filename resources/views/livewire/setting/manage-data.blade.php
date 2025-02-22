<div class="nk-content-wrap">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-head">
                <h5 class="card-title">Data Management</h5>
            </div>
            <div class="form-validate gy-3">

                <div class="row mb-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="year">Year</label>
                            <select wire:model="year" class="form-select form-control" id="year">
                                <option value="">Select Year</option>
                                @foreach($years as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                       <button wire:click="getData()" class="btn btn-primary mt-4">Get Data</button>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <i class="fa fa-info-circle"></i> System will only delete Delivered parcel.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Total Delivered</th>
                                <th>Total Not Delivered</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pickups as $data)
                                <tr>
                                    <td>{{ $data['month'] }}</td>
                                    <td>{{ $data['delivered'] }}</td>
                                    <td>{{ $data['not_delivered'] }}</td>
                                    <td>
                                        <button wire:click="deleteData({{ $data['key'] }})" class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
