<?php

namespace App\Providers;

use App\GeneralSetting;
use App\Language;
use App\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $activeTemplate = activeTemplate();

        $viewShare['general'] = GeneralSetting::first();
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['pages'] = Page::where('tempname',$activeTemplate)->where('slug','!=','home')->get();
        view()->share($viewShare);


        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'pending_ticket_count'         => \App\SupportTicket::whereIN('status', [0,2])->count(),
                'pending_deposits_count'    => \App\Deposit::pending()->count(),
                'pending_ticket_count'         => \App\SupportTicket::whereIN('status', [0,2])->count(),
                'new_appointments_count'           => \App\Appointment::newAppointment()->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = \App\Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        // view()->composer('doctor.partials.sidenav', function ($view) {
        //     $view->with([
        //         // 'doctor_new_appointments_count' =>  \App\Appointment::where('doctor_id',Auth::guard('doctor')->user()->id)->where('try',1)->where('is_complete',0)->where('d_status',0)->count(),
        //     ]);
        // });

        // view()->composer('staff.partials.sidenav', function ($view) {
        //     $view->with([
        //         'staff_new_appointments_count' =>  \App\Appointment::where('staff',Auth::guard('staff')->user()->id)->where('try',1)->where('d_status',0)->where('is_complete',0)->whereHas('doctor', function ($query) {
        //             $query->where('status',1);
        //        })->count(),
        //     ]);
        // });

        // view()->composer('patient.partials.sidenav', function ($view) {
        //     $view->with([
        //         'patient_new_appointments_count' =>  \App\Appointment::where('patient',Auth::guard('patient')->user()->id)->where('try',1)->where('d_status',0)->where('is_complete',0)->whereHas('doctor', function ($query) {
        //             $query->where('status',1);
        //        })->count(),
        //     ]);
        // });

    }
}
