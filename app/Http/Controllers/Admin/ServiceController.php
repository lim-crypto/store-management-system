<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Model\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }
    public function create()
    {
        return view('admin.services.create');
    }

    public function store(ServiceRequest $request)
    {
        $service = new Service;
        $service->service = $request->service;
        $service->description = $request->description;
        $service->image = Helper::saveImage($request->image, $request->service, 'service');
        // offer and price
        $offer_price = [];
        foreach ($request->offer as $key => $offer) {
            $offer_price[] = array(
                'offer' => $offer,
                'price' => $request->price[$key]
            );
        }
        $service->offer = json_encode($offer_price);
        $service->save();
        return redirect()->route('services.index')->with('success', 'Successfully added service');
    }
    public function edit(Service $service)
    {
        $service->offer = json_decode($service->offer);
        return view('admin.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->service = $request->service;
        $service->description = $request->description;
        if ($request->image) {
            Helper::deleteImage($service->image, 'service');
            $service->image = Helper::saveImage($request->image, $request->service, 'service');
        }
        // offer and price
        $offer_price = [];
        foreach ($request->offer as $key => $offer) {
            $offer_price[] = array(
                'offer' => $offer,
                'price' => $request->price[$key]
            );
        }
        $service->offer = json_encode($offer_price);
        $service->save();
        return redirect()->route('services.index')->with('success', 'Service Updated Successfully');
    }

    public function destroy(Service $service)
    {
        Helper::deleteImage($service->image, 'service');
        $service->delete();
        return redirect()->back()->with('success',  ' Deleted Successfully');
    }
}
