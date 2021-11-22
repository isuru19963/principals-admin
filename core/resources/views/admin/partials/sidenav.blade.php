<div class="sidebar capsule--rounded bg_img overlay--dark" style="background-color:#000983 "
     {{-- data-background="{{getImage('assets/admin/images/sidebar/2.jpg','400x800')}}" --}}

     >
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('admin.dashboard')}}" class="sidebar__main-logo"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('image')"></a>
            <a href="{{route('admin.dashboard')}}" class="sidebar__logo-shape"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{menuActive('admin.dashboard')}}">
                    <a href="{{route('admin.dashboard')}}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.sector*')}}">
                    <a href="{{route('admin.sector')}}" class="nav-link ">
                        <i class=" menu-icon fas fa-list"></i>
                        <span class="menu-title">@lang('Manage Categories')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.doctors*',3)}}">
                        <i class="menu-icon fas fa-book-open"></i>
                        <span class="menu-title">@lang('Manage Library')</span>
                        @if($banned_doctors_count > 0 || $email_unverified_doctors_count > 0 || $sms_unverified_doctors_count > 0)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.coaches*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.posts.new')}}">
                                <a href="{{route('admin.posts.new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Add New Article')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.posts.all')}}">
                                <a href="{{route('admin.posts.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Articles')</span>
                                </a>
                            </li>

                            {{-- <li class="sidebar-menu-item {{menuActive('admin.posts.active')}} ">
                                <a href="{{route('admin.posts.active')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Active posts')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.coaches.banned')}} ">
                                <a href="{{route('admin.coaches.banned')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Banned Coaches')</span>
                                    @if($banned_doctors_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$banned_doctors_count}}</span>
                                    @endif
                                </a>
                            </li> --}}

                            {{-- <li class="sidebar-menu-item  {{menuActive('admin.coaches.emailUnverified')}}">
                                <a href="{{route('admin.coaches.emailUnverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Unverified')</span>

                                    @if($email_unverified_doctors_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$email_unverified_doctors_count}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.coaches.smsUnverified')}}">
                                <a href="{{route('admin.coaches.smsUnverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Unverified')</span>
                                    @if($sms_unverified_doctors_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$sms_unverified_doctors_count}}</span>
                                    @endif
                                </a>
                            </li> --}}

                            {{-- <li class="sidebar-menu-item {{menuActive('admin.coaches.login.history')}}">
                                <a href="{{route('admin.coaches.login.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Login History')</span>
                                </a>
                            </li> --}}

                            {{-- <li class="sidebar-menu-item {{menuActive('admin.doctors.email.all')}}">
                                <a href="{{route('admin.doctors.email.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Send Email')</span>
                                </a>
                            </li> --}}

                        </ul>
                    </div>
                </li>

                {{-- <li class="sidebar-menu-item {{menuActive('admin.gallery*')}}">
                    <a href="{{route('admin.gallery')}}" class="nav-link ">
                        <i class=" menu-icon fas fa-book"></i>
                        <span class="menu-title">@lang('Manage Gallery')</span>
                    </a>
                </li> --}}

                {{-- <li class="sidebar-menu-item {{menuActive('admin.youtube*')}}">
                    <a href="{{route('admin.youtube')}}" class="nav-link ">
                        <i class="menu-icon fab fa-youtube"></i>
                        <span class="menu-title">@lang('Vimeo Videos')</span>
                    </a>
                </li> --}}

                {{-- <li class="sidebar-menu-item {{menuActive('admin.disease*')}}">
                    <a href="{{route('admin.disease')}}" class="nav-link ">
                        <i class="menu-icon fas fa-tooth"></i>
                        <span class="menu-title">@lang('Manage Diseases')</span>
                    </a>
                </li> --}}

                {{-- <li class="sidebar-menu-item {{menuActive('admin.location*')}}">
                    <a href="{{route('admin.location')}}" class="nav-link ">
                        <i class="menu-icon fas fa-map-marker-alt"></i>
                        <span class="menu-title">@lang('Manage Locations')</span>
                    </a>
                </li> --}}

                {{-- <li class="sidebar-menu-item {{menuActive('admin.books*')}}">
                    <a href="{{route('admin.books')}}" class="nav-link ">
                        <i class="menu-icon fas fa-book"></i>
                        <span class="menu-title">@lang('Manage Books')</span>
                    </a>
                </li> --}}

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.doctors*',3)}}">
                        <i class="menu-icon fas fa-chalkboard-teacher"></i>
                        <span class="menu-title">@lang('Manage Coaches')</span>
                        @if($banned_doctors_count > 0 || $email_unverified_doctors_count > 0 || $sms_unverified_doctors_count > 0)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.coaches*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.coaches.new')}}">
                                <a href="{{route('admin.coaches.new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                   
                                    <span class="menu-title">@lang('Add New Coaches')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.coaches.all')}}">
                                <a href="{{route('admin.coaches.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Coaches')</span>
                                </a>
                            </li>

                            <!-- <li class="sidebar-menu-item {{menuActive('admin.coaches.active')}} ">
                                <a href="{{route('admin.coaches.active')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Active Coaches')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.coaches.banned')}} ">
                                <a href="{{route('admin.coaches.banned')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Banned Coaches')</span>
                                    @if($banned_doctors_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$banned_doctors_count}}</span>
                                    @endif
                                </a>
                            </li> -->

                            {{-- <li class="sidebar-menu-item  {{menuActive('admin.coaches.emailUnverified')}}">
                                <a href="{{route('admin.coaches.emailUnverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email Unverified')</span>

                                    @if($email_unverified_doctors_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$email_unverified_doctors_count}}</span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.coaches.smsUnverified')}}">
                                <a href="{{route('admin.coaches.smsUnverified')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('SMS Unverified')</span>
                                    @if($sms_unverified_doctors_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$sms_unverified_doctors_count}}</span>
                                    @endif
                                </a>
                            </li> --}}

                            {{-- <li class="sidebar-menu-item {{menuActive('admin.coaches.login.history')}}">
                                <a href="{{route('admin.coaches.login.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Login History')</span>
                                </a>
                            </li> --}}

                            {{-- <li class="sidebar-menu-item {{menuActive('admin.doctors.email.all')}}">
                                <a href="{{route('admin.doctors.email.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Send Email')</span>
                                </a>
                            </li> --}}

                        </ul>
                    </div>
                </li>

                

                
{{-- Principal --}}
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.principals*',3)}}">
                        <i class="menu-icon fas fa-male"></i>
                        <span class="menu-title">@lang('Manage Principals')</span>
                        @if($banned_staff_count > 0 || $email_unverified_staff_count > 0 || $sms_unverified_staff_count > 0)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.principals*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.principals.new')}}">
                                <a href="{{route('admin.principals.new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Add New Principals')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.principals.all')}}">
                                <a href="{{route('admin.principals.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Principals')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.appointments*',3)}}">
                        <i class="menu-icon fas fa-handshake"></i>
                        <span class="menu-title">@lang('Appointments') </span>
                        @if(0 < $new_appointments_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.appointments*',2)}} ">
                        <ul>

                            {{-- <li class="sidebar-menu-item {{menuActive('admin.appointments.create')}} ">
                                <a href="{{route('admin.appointments.create')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Create')</span>
                                </a>
                            </li> --}}
                            <li class="sidebar-menu-item {{menuActive('admin.appointments.all')}} ">
                                <a href="{{route('admin.appointments.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('New')</span>
                                    @if($new_appointments_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$new_appointments_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.appointments.done')}} ">
                                <a href="{{route('admin.appointments.done')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Done')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.appointments.trashed')}} ">
                                <a href="{{route('admin.appointments.trashed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Trashed')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                

                

                

            </ul>

            {{-- <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{systemDetails()['name']}}</span>
                <span class="text--success">@lang('V'){{systemDetails()['version']}} </span>
            </div> --}}
        </div>
    </div>
</div>
<!-- sidebar end -->
