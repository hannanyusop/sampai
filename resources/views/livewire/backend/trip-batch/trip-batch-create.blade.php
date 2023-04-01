<div>
    <div class="nk-block-head nk-block-head-lg wide-sm">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="{{ route('admin.trip.index') }}"><em class="icon ni ni-arrow-left"></em><span>Trip List</span></a></div>
            <h2 class="nk-block-title fw-normal">Create Trip</h2>
        </div>
    </div>

    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="remark">Remark</label>
                                <span class="form-note"></span>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <textarea id="remark" name="remark" placeholder="Insert your remark here . . ." class="form-control" rows="5" wire:model="remark"></textarea>
                                    @error('remark')
                                    <span id="fv-destination_id-error" class="invalid">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="date">Date</label>
                                <span class="form-note">Required</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="custom-control-wrap">
                                    <input type="text" name="date" id="date" class="form-control date-picker-alt" value="{{ old('date')? old('date'): date('Y-m-d') }}" data-date-format="yyyy-mm-dd" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-7 offset-lg-5">
                            <div class="form-group mt-2">
                                <button wire:click="store()"  class="btn btn-lg btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
