<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Model\Pet;
use App\Model\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Helper::checkPetReservation();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // services
    public function serviceDetails(Service $service)
    {
        $service->offer = json_decode($service->offer);
        return view('services.show', compact('service'));
    }
}
