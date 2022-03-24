<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetRequest;
use App\Model\Breed;
use App\Model\Pet;
use App\Model\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function __construct()
    {
        Helper::checkPetReservation();
    }
    public function index()
    {
        $pets = Pet::all();
        return view('admin.pets.index', compact('pets'));
    }
    public function create()
    {
        $types = Type::all();
        $breeds = Breed::all();
        return view('admin.pets.create', compact('types', 'breeds'));
    }
    public function store(PetRequest $request)
    {
        $pet = new Pet;
        $pet->type_id = $request->type_id;
        $pet->breed_id = $request->breed_id;
        $pet->name = $request->name;
        $pet->gender = $request->gender;
        $pet->price = $request->price;
        $pet->status = $request->status;
        $pet->birthday = Carbon::parse($request->birthday)->format('Y-m-d');
        $pet->weight = $request->weight;
        $pet->height = $request->height;
        $images = $pet->saveImages($request->images);
        $pet->images  = json_encode($images);
        $pet->save();   // save to get slug ,
        $pet->description =  $pet->getDescription($request->description, $pet->slug);
        $pet->save();
        return redirect()->route('pets.index')->with('success', 'Pet Added Successfully');
    }
    public function edit(Pet $pet)
    {
        $types = Type::all();
        $breeds = Breed::all();
        $pet->images = json_decode($pet->images);
        return view('admin.pets.edit', compact('pet', 'types', 'breeds'));
    }

    public function update(Request $request, Pet $pet)
    {
        if ($request->has('images')) {
            $pet->deleteImages($pet->images);
            $images = $pet->saveImages($request->images);
            $pet->images  = json_encode($images);
        }
        $pet->type_id = $request->type_id;
        $pet->breed_id = $request->breed_id;
        $pet->name = $request->name;
        $pet->gender = $request->gender;
        $pet->price = $request->price;
        $pet->status = $request->status;
        $pet->birthday = Carbon::parse($request->birthday)->format('Y-m-d');
        $pet->weight = $request->weight;
        $pet->height = $request->height;
        $pet->description =  $pet->getDescription($request->description, $pet->slug);
        $pet->save();
        return redirect()->route('pets.index')->with('success', 'Pet updated successfully');
    }

    public function destroy(Pet $pet)
    {
        if ($pet->reservation == null) {
            $pet->deleteImages($pet->images);
            $pet->deleteDescriptionImages($pet->name);
            $pet->delete();
            return redirect()->route('pets.index')->with('success', 'Pet deleted successfully');
        }
        return redirect()->route('pets.index')->with('error', 'Cannot delete pet,  Pet has a reservation');
    }

    public function getPetsByStatus($status)
    {
        $pets = Pet::where('status', $status)->get();
        return view('admin.pets.index', compact('pets'));
    }
    public function getPetsByType(Type $type)
    {
        $pets = Pet::where('type_id', $type->id)->get();
        return view('admin.pets.index', compact('pets'));
    }
    public function getPetsByBreed(Breed $breed)
    {
        $pets = Pet::where('breed_id', $breed->id)->get();
        return view('admin.pets.index', compact('pets'));
    }
}
