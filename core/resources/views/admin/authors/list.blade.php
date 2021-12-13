@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Author Profile Image')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Mobile No')</th>
                                <th scope="col">@lang('Joined At')</th>
                                {{-- <th scope="col">@lang('Featured')</th> --}}
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($authors as $author)
                                <tr>
                                    <td data-label="@lang('Author')">
                                        <div class="user">
                                            <div class="thumb"><img src="{{ getImage(imagePath()['author']['path'].'/'. $author->profile_image,imagePath()['author']['size'])}}" alt="@lang('image')"></div>
                                            <span class="name">{{$author->name}}</span>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Username')"><a href="{{ route('admin.author.detail', $author->id) }}">{{ $author->first_name }} {{ $author->last_name }}</a></td>
                                    <td data-label="@lang('Email')">{{ $author->email }}</td>
                                    <td data-label="@lang('Email')">{{ $author->mobile_no }}</td>
                                    {{-- <td data-label="@lang('Total Earn')">{{ round($author->balance) }} {{ $general->cur_sym }}</td> --}}
                                    <td data-label="@lang('Joined At')">{{ showDateTime($author->created_at) }}</td>
                                    {{-- <td data-label="@lang('Featured')">
                                        @if ($author->featured == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Yes')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('No')</span>
                                        @endif
                                    </td> --}}
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.author.detail', $author->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                            <i class="las la-desktop text--shadow"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($empty_message)}}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $authors->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    <a href="{{route('admin.author.new')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush
