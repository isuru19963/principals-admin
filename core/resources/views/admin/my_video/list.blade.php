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
                               <th scope="col">@lang('Preview')</th>
                                <th scope="col">@lang('Video')</th>
                                <th scope="col">@lang('Created At')</th>
                                {{-- <th scope="col">@lang('Featured')</th> --}}
                                {{--<th scope="col">@lang('Action')</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($videos as $video)
                                <tr>
                                    <td data-label="@lang('article')">
                                        <div class="user">
                                            <div><img src="{{$video['pictures']['base_link']}}" height="100px" width="100px" alt="tag"></div>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Name')"><a target="_blank" href="{{ $video['link'] }}">{{ $video['name'] }}</a></td>
                                    {{-- <td data-label="@lang('Total Earn')">{{ round($author->balance) }} {{ $general->cur_sym }}</td> --}}
                                    <td data-label="@lang('Joined At')">{{ showDateTime($video['created_time']) }}</td>

                                    {{--<td data-label="@lang('Action')">--}}
                                        {{--<a href="{{ route('admin.author.detail', $video['name']) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">--}}
                                            {{--<i class="las la-desktop text--shadow"></i>--}}
                                        {{--</a>--}}
                                    {{--</td>--}}
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
{{--                    {{ $videos->links('admin.partials.paginate') }}--}}
                </div>
            </div><!-- card end -->
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    <a href="{{route('admin.my_video.new')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush
