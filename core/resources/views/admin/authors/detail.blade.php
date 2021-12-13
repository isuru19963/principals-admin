@extends('admin.layouts.app')
@php

    $states = json_decode($sectors);
@endphp
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="">
                            <img src="{{ getImage(imagePath()['author']['path'].'/'. $author->profile_image,imagePath()['author']['size'])}}"
                                 alt="@lang('profile-image')"
                                 class="b-radius--10 w-100">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{$author->name}}</h4>
                            <span class="text--small">@lang('Joined At')
                                <strong>{{date('d M, Y h:i A',strtotime($author->created_at))}}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Author information')</h5>
                    <ul class="list-group">

                        {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="font-weight-bold">{{$author->username}}</span>
                        </li> --}}


                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @switch($author->status)
                                @case(1)
                                <span class="badge badge-pill bg--success">@lang('Active')</span>
                                @break
                                @case(0)
                                <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                                @break
                            @endswitch
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Contact No')
                            <span class="font-weight-bold">{{$author->mobile_no}}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Doctor action')</h5>
                    <a href="{{ route('admin.doctors.login.history.single', $author->id) }}"
                       class="btn btn--primary btn--shadow btn-block btn-lg">
                       @lang('Login Logs')
                    </a>
                    <a href="{{route('admin.doctors.email.single',$author->id)}}"
                       class="btn btn--danger btn--shadow btn-block btn-lg">
                        @lang('Send Email')
                    </a>
                </div>
            </div> --}}
        </div>


        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">


            <div class="card ">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{$author->name}} @lang('Information')</h5>

                    <form action="{{ route('admin.author.update',$author->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('First Name') <span
                                                class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="first_name"
                                           value="{{$author->first_name}}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Last Name') <span
                                                class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="last_name"
                                           value="{{$author->last_name}}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Email') <span
                                                class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{$author->email}}"
                                           required>
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Mobile Number') <span
                                                class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile"
                                           value="{{$author->mobile_no }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('state') </label>
                                    <select name="state" class="form-control">
                                        @foreach ($states as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('District') </label>
                                    <input class="form-control" type="text" name="qualification"
                                           value="{{$author->district}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold"
                                           class="form-control-label font-weight-bold">@lang('About Author')</label>
                                    <textarea name="about" rows="5" required>{{$author->bio}}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold">@lang('Location') <span
                                        class="text-danger">*</span></label>
                                    <select name="location_id" class="form-control" required>
                                        @foreach ($locations as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Fees') ({{$general->cur_text}}) <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="fees" value="{{$author->fees}}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Rating') <span
                                        class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="rating" placeholder="@lang('Minimun: 1, Maximum : 5')" value="{{$author->rating}}" required>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Banned')"
                                       data-width="100%"
                                       name="status"
                                       @if($author->status) checked @endif>
                            </div>

                            {{-- <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('Email Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev"
                                       @if($author->ev) checked @endif>

                            </div>

                            <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('SMS Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"
                                       @if($author->sv) checked @endif>

                            </div> --}}

                            {{-- <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold"> @lang('Make Doctor Featured')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="featured" @if($author->featured) checked @endif>
                            </div> --}}

                            {{-- <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('2FA Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactive')" name="ts"
                                       @if($author->ts) checked @endif>
                            </div>

                            <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('2FA Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="tv"
                                       @if($author->tv) checked @endif>
                            </div> --}}
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')


@endpush

@push('breadcrumb-plugins')
    <a href="{{ route('admin.author.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i
                class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush