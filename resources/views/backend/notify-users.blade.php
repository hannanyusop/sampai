@extends('backend.layouts.app')

@section('title', __('Notify Users'))

@section('content')

    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-between-md g-4">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title fw-normal">Notify Users</h3>
                        <div class="nk-block-des">
                            <p>Send a push notification to all registered users via FCM.</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                            <em class="icon ni ni-arrow-left"></em><span>Back</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <form action="{{ route('admin.notify-users.send') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label class="form-label" for="message">Message</label>
                                <textarea class="form-control form-control-lg @error('message') is-invalid @enderror"
                                          id="message"
                                          name="message"
                                          rows="5"
                                          placeholder="Enter your notification message..."
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <em class="icon ni ni-send"></em><span>Send Notification</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
