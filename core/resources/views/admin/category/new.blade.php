@extends('admin.layouts.app')
@php

@endphp
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.sector.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">

                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Category Name')</label>
                                            <input type="text" class="form-control" placeholder="@lang('Category Name')" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Details')</label>
                                            <textarea type="text" class="form-control" placeholder="@lang('Details')" name="details" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" >
                                <div class="form-group">
                                    <b>@lang('Category Image')</b>
                                    <div class="image-upload mt-2">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" id="profilePicPreview" hidden style="background-image: url({{ getImage('/',imagePath()['coach']['size']) }})">
                                                    <button type="button" class="remove-image"  onclick=" $('#profilePicPreview').prop('hidden',true)"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg"  onchange="$('#profilePicPreview').prop('hidden',false)" required>
                                                <label for="profilePicUpload1" class="bg--success"> @lang('image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>. @lang('Image Will be resized to'): <b>{{imagePath()['coach']['size']}}</b> @lang('px').</small>
                                            </div>
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
    <a href="{{ route('admin.sector') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush


