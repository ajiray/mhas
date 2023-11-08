<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\AcceptedAppointment;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with('comments')->get();
       
    
        return view('dashboard', ['posts' => $posts]);
    }
    


    public function message() {
        return view('message');
    }

    public function appointment() {
        $appointments = Appointment::all()->sortBy(function ($appointment) {
            return $appointment->date . ' ' . $appointment->time;
        });
    
        return view('appointment', ['appointments' => $appointments]);
    }
    

    public function profile() {
        return view('profile');
    }

    public function resources() {
        return view('resources');
    }


    
    public function adminHome()
    {
        $posts = Post::all();
        return view('admindashboard', ['posts' => $posts]);
    }

    public function adminappointment()
{
    // Get all appointments and sort them by 'date' and 'time'
    $appointments = Appointment::all()->sortBy(function ($appointment) {
        return $appointment->date . ' ' . $appointment->time;
    });

    // Get all accepted appointments
    $acceptedAppointments = AcceptedAppointment::all()->sortBy(function ($acceptedAppointment){
        return $acceptedAppointment->appointment->date . '' . $acceptedAppointment->appointment->time;
    });

    return view('adminappointment', [
        'appointments' => $appointments,
        'acceptedAppointments' => $acceptedAppointments,
    ]);
}

    

    public function adminmessage()
    {
        return view('adminmessage');
    }

    public function adminresources()
    {
        return view('adminresources');
    }
}