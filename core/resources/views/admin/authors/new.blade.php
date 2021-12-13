@extends('admin.layouts.app')
@php

$states = json_decode($sectors);
@endphp
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.author.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <b>@lang('Author Image')</b>
                                    <div class="image-upload mt-2">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" id="profilePicPreview" hidden style="background-image: url({{ getImage('/',imagePath()['author']['size']) }})">
                                                    <button type="button" class="remove-image" onclick=" $('#profilePicPreview').prop('hidden',true)"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" onchange="$('#profilePicPreview').prop('hidden',false)" accept=".png, .jpg, .jpeg" required>
                                                <label for="profilePicUpload1" class="bg--success"> @lang('image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>. @lang('Image Will be resized to'): <b>{{imagePath()['author']['size']}}</b> @lang('px').</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('First Name')</label>
                                            <input type="text" class="form-control" placeholder="@lang('Example : John')" name="first_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Last Name')</label>
                                            <input type="text" class="form-control" placeholder="@lang('Example : Smith')" name="last_name" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('E-mail')</label>
                                            <input type="email" class="form-control" placeholder="@lang('Example : demo@demo.com')" name="email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Mobile No')</label>
                                            <input type="tel" class="form-control" name="mobile" placeholder="@lang('Example : 00000000')" value="{{ old('mobile') }}" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Password')</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Confirm Password')</label>
                                            <input type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>

                                </div>
                                {{-- <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Working Sector')</label>
                                            <select name="sector_id" class="form-control" required>
                                                @foreach ($sectors as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Qualification')</label>
                                            <input type="text" class="form-control" name="qualification" placeholder="@lang('Example : BDS, MDS - Oral & Maxillofacial Surgery')" value="{{ old('qualification') }}" required>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('State')</label>
                                            <select name="state" class="form-control" required>
                                                @foreach ($states as $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('District')</label>
                                            <input type="text" class="form-control" name="district" placeholder="@lang('')" value="{{ old('address') }}" required>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Fees') ({{$general->cur_text}})</label>
                                            <input type="number" class="form-control" name="fees" placeholder="@lang('Example : 12')" value="{{ old('fees') }}" required>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold" class="form-control-label font-weight-bold">@lang('About Author')</label>
                                            <textarea name="about" rows="5" placeholder="@lang('')" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.author.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush


