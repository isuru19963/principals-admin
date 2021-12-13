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
                        <span class="menu-title">@lang('Categories')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.coaches*',3)}}">
                        <i class="menu-icon fas fa-book-open"></i>
                        <span class="menu-title">@lang('Library')</span>
                        
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

                         


                            

                        </ul>
                    </div>
                </li>


                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.coaches*',3)}}">
                        <i class="menu-icon fas fa-chalkboard-teacher"></i>
                        <span class="menu-title">@lang('Coaches')</span>
                       
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

                            

                        </ul>
                    </div>
                </li>

                

                
{{-- Principal --}}
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.principals*',3)}}">
                        <i class="menu-icon fas fa-male"></i>
                        <span class="menu-title">@lang('Principals')</span>
                        
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

                {{-- Author --}}
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.author*',3)}}">
                        <i class="menu-icon fas fa-pen"></i>
                        <span class="menu-title">@lang('Author')</span>
                      
                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.author*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.author.new')}}">
                                <a href="{{route('admin.author.new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Add New Author')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.author.all')}}">
                                <a href="{{route('admin.author.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Authors')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>


                {{-- Video --}}
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.my_video*',3)}}">
                        <i class="menu-icon fas fa-video"></i>
                        <span class="menu-title">@lang('My Video')</span>

                    </a>

                    <div class="sidebar-submenu {{menuActive('admin.my_video*',2)}}">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.my_video.new')}}">
                                <a href="{{route('admin.my_video.new')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Add New Video')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.my_video.all')}}">
                                <a href="{{route('admin.my_video.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Videos')</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.appointments*',3)}}">
                        <i class="menu-icon fas fa-handshake"></i>
                        <span class="menu-title">@lang('Appointments') </span>
                      
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.appointments*',2)}} ">
                        <ul>

                            
                            <li class="sidebar-menu-item {{menuActive('admin.appointments.all')}} ">
                                <a href="{{route('admin.appointments.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Appointments')</span>
                                    @if($new_appointments_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$new_appointments_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <!-- <li class="sidebar-menu-item {{menuActive('admin.appointments.done')}} ">
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
                            </li> -->
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
