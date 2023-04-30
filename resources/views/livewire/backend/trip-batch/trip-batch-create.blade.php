<div>

    <div class="nk-content-wrap">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="text-center">

                    Please select the trip type and fill the form below to create a new trip.
                    This will create a new trip batch for d {{ date('Y-m-d') }}

                    <div class="row m-4">
                        <div class="col-md-12">
                            <a href="#" wire:click="store()" class="btn btn-lg btn-primary">Add New Trip</a>
                            <a href="{{ route('admin.tripBatch.index') }}" class="btn btn-lg btn-warning">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
