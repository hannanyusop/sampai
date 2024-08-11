<div class="row">
    <div class="col-md-12">
        <button  class="btn btn-xl btn-success btn-block mb-2" wire:click="save()">Save</button>
    </div>

    <div class="col-md-12">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="row g-3">
                    <div class="col-md-6">
                        <h5><b>Receiving Remark</b></h5>
                        <div class="form-control-wrap">
                            <textarea id="pickup_remark" name="pickup_remark" wire:model="pickup_remark" placeholder="Insert your receiving remark here . . ." class="form-control" rows="30">{{ old('pickup_remark') ?? $office->pickup_remark }}</textarea>
                            @error('pickup_remark')
                            <span id="fv-pickup_remark-error" class="invalid">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5><b>Preview</b></h5>
                        <div class="alert alert-fill alert-secondary alert-icon">
                            <small> {!! $pickup_remark !!}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
