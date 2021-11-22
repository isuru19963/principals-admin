@extends('admin.layouts.app')
@php

@endphp
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Post Title') <span class="text-danger">*</span></label>
                                    <textarea name="title" id="title" class="form-control"  rows="2"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Description') <span class="text-danger">*</span></label>
                                    <textarea name="description" rows="10" class="form-control nicEdit" placeholder="@lang('Your message')"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Author Name')</label>
                                    <textarea name="author_name" id="author_name" class="form-control"  rows="2"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Author Description')</label>
                                    <textarea name="author_description" id="uithor_description" class="form-control"  rows="2"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="text-muted">@lang('Category')</label>
                                    <br>
                                    <select name="category"  required>
                                        <option selected disabled>@lang('Select Category')</option>
                                        @foreach ($sector as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold"> @lang('Make This Article Live')</label>
                                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="status" @if($general->sv) checked @endif>
                                        </div>
                                    </div>
                                <div class="form-group col-md-6">
                                    <label class="text-muted">@lang('Vimeo Video')</label>
                                    <br>
                                    <select name="vimeo_url"  required>
                                        <option selected disabled>@lang('Select Vimeo Video')</option>
                                        @foreach ($vimeoData as $item)
                                            <option value="{{ $item['uri']}}" style="background-image:url({{ $item['pictures']['base_link']}});">{{ $item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                              
                                <div class="form-group">
                        <b>@lang('Article Image')</b>
                        <div class="image-upload mt-2">
                            <div class="thumb">
                                <div class="profilePicPreview" >
                                    <div  style="background-image: url({{ getImage('',imagePath()['posts']['size']) }})">
                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload1" class="bg--success"> @lang('Upload Image')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                    @lang('Image Will be resized to'): <b>{{imagePath()['posts']['size']}}</b> @lang('px').

                                    </small>
                                </div>
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
    <a href="{{ route('admin.posts.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush


