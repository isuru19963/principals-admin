@extends('patient.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-6 col-md-6 mb-30">
            <div class="row">
                <div class="col-lg-12 col-md-12 mb-30">
                    <div class="card b-radius--5 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="d-flex p-3 bg--primary align-items-center">
                                <div class="avatar avatar--lg">
                                    <img src="{{ getImage(imagePath()['staff']['path'].'/'. $staff->image,imagePath()['staff']['size'])}}" alt="@lang('profile-image')">
                                </div>
                                <div class="pl-3">
                                    <h4 class="text--white">{{$staff->name}}</h4>
                                </div>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="list-left"> @lang('Name')</span>
                                    <span class="font-weight-bold list-right">{{$staff->name}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="list-left"> @lang('Username')</span>
                                    <span class="font-weight-bold list-right">{{$staff->username}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="list-left"> @lang('Email')</span>
                                    <span class="font-weight-bold list-right">{{$staff->email}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="list-left"> @lang('Mobile')</span>
                                    <span class="font-weight-bold list-right">{{$staff->mobile}}</span>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('Change Password')</h5>

                    <form action="{{ route('patient.password.update') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">@lang('Password')</label>
                            <div class="col-lg-9">

                                <input class="form-control" type="password" name="old_password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">@lang('New password')</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="password" name="password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">@lang('Confirm password')</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="password" name="password_confirmation">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('patient.profile')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-user"></i>@lang('Profile Setting')</a>
@endpush

@push('style')
    <style>
        .list-left{
            width: 40%;
        }
        .list-right{
            width: calc(100% - 40%);
        }
    </style>
@endpush

