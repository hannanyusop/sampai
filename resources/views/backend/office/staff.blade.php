@extends('backend.layouts.app')

@section('title', __('User Management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')

    <div class="nk-block nk-block-lg">
        <div class="nk-block-head nk-block-head-lg wide-sm">
            <div class="nk-block-head-content">
                <h2 class="nk-block-title fw-normal">Staff List</h2>
                <div class="nk-block-des">
                    <p class="lead"></p>
                </div>
            </div>
        </div>
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                    <tr class="nk-tb-item nk-tb-head">
                        <th class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid">
                                <label class="custom-control-label" for="uid"></label>
                            </div>
                        </th>
                        <th class="nk-tb-col"><span class="sub-text">User</span></th>
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Type</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Permissions</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Last Login</span></th>
                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Last IP</span></th>
                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-right">
                            <div class="dropdown">
                                <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-toggle="dropdown" data-offset="0,5"><em class="icon ni ni-plus"></em></a>
                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                    <ul class="link-tidy sm no-bdr">
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked="" id="bl">
                                                <label class="custom-control-label" for="bl">Type</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked="" id="ph">
                                                <label class="custom-control-label" for="ph">Permission</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="vri">
                                                <label class="custom-control-label" for="vri">Last Login</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="st">
                                                <label class="custom-control-label" for="st">Last IP</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" class="custom-control-input" id="{{ $user->id }}">
                                    <label class="custom-control-label" for="{{ $user->id }}"></label>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                        <img src="{{ $user->avatar }}" class="user-profile-image" />
                                    </div>
                                    <div class="user-info">
                                        <span class="tb-lead">{{ $user->name }} <span class="dot dot-success d-md-none ml-1"></span></span>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-mb">
                                <span class="tb-amount">{{ $user->type }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span>{!! $user->permissions_label !!}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span>{{ (!is_null($user->last_login_at))? $user->last_login_at->diffForHumans() : "No Login Information" }}</span>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <ul class="list-status">
                                    <li><em class="icon text-success ni ni-check-circle"></em> <span>{{ $user->last_login_ip }}</span></li>
                                </ul>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                @if($user->active == 1)
                                    <span class="tb-status text-success">Active</span>
                                @else
                                    <span class="tb-status text-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="nk-tb-col nk-tb-col-tools">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->

@endsection
