@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="nk-content-wrap">

        <div class="nk-block">
            <div class="col-xxl-8">
                <div class="card card-bordered card-full">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title"><span class="mr-2">Office Management</span></h6>
                            </div>
                            <div class="card-tools">
                                <a href="{{ route('admin.office.create') }}" class="btn btn-primary">Create New Office</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span>No.</span></div>
                                <div class="nk-tb-col tb-col-sm"><span>code</span></div>
                                <div class="nk-tb-col tb-col-md"><span>name</span></div>
                                <div class="nk-tb-col tb-col-lg"><span>Drop Point</span></div>
                                <div class="nk-tb-col"><span>Manager</span></div>
                                <div class="nk-tb-col"><span>&nbsp;</span></div>
                            </div>
                            @foreach($offices as $key => $office)
                                <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="tb-lead"><a href="#"># {{ $key+1 }}</a></span>
                                </div>
                                <div class="nk-tb-col tb-col-sm">
                                    <div class="user-card">
                                        <div class="user-name">
                                            <span class="tb-lead">{{ $office->code }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">{{ $office->name }}</span>
                                </div>
                                <div class="nk-tb-col tb-col-lg">
                                    @if($office->is_drop_point == 1)
                                        <span class="badge badge-dot badge-dot-xs badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-dot badge-dot-xs badge-danger">No</span>
                                    @endif
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-sub tb-amount">XXX</span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                            <ul class="link-list-plain">
                                                <li><a href="{{ route('admin.office.edit', $office->id) }}">Edit</a></li>
{{--                                                <li><a href="{{ route('admin.office.delete', $office->id) }}" onclick="">Delete</a></li>--}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-inner-sm border-top text-center d-sm-none">
                        <a href="#" class="btn btn-link btn-block">See History</a>
                    </div>
                </div><!-- .card -->
            </div><!-- .col -->
        </div>

    </div>
@endsection
@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#code').on('keyup',function() {
                var query = $(this).val();
                $.ajax({

                    url:"{{ route('admin.trip.search') }}",

                    type:"GET",

                    data:{'code':query},

                    success:function (data) {

                        $('#data').html(data);
                    }
                })
                // end of ajax call
            });


            $(document).on('click', 'li', function(){

                var value = $(this).text();
                $('#country').val(value);
                $('#data').html("");
            });
        });
    </script>
@endpush
