<div>
    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="card-head">
                    <h5 class="card-title">Manage Storage</h5>
                </div>

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

                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Path</th>
                                    <th>Exist</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data)
                                    @foreach($data as $key => $value)
                                        <tr>
                                            <td>{{ $value['month'] }}</td>
                                            <td>{{ $value['path'] }}</td>
                                            <td>{{ $value['exists'] ? "Exist" : "Not Exist" }}</td>
                                            <td>
                                                @if($value['exists'])
                                                    <button wire:click="deletePath('{{ $value['key'] }}','{{ $value['path'] }}')" class="btn btn-danger">Delete</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
