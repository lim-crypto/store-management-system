<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BreedRequest;
use App\Model\Breed;
use App\Model\Type;
use Illuminate\Http\Request;
class BreedController extends Controller
{
    public function index()
    {
        $breeds = Breed::all();
        $types = Type::all();
        return view('admin.breeds.index', compact('breeds', 'types'));
    }
    public function create()
    {
        $types = Type::all();
        return view('admin.breeds.create', compact('types'));
    }
    public function store(BreedRequest $request)
    {
        $breed = new Breed;
        $breed->name = $request->name;
        $breed->type_id = $request->type_id;
        $breed->save();
        return redirect()->route('breed.index')->with('success', $breed->name . ' Added Successfully');
    }
    public function edit(Breed $breed)
    {
        $types = Type::all();
        return view('admin.breeds.edit', compact('breed', 'types'));
    }
    public function update(BreedRequest $request, Breed $breed)
    {
        $breed->name = $request->name;
        $breed->type_id = $request->type_id;
        $breed->save();
        return redirect()->route('breed.index')->with('success', $breed->name . ' Updated Successfully');
    }
    public function destroy(Breed $breed)
    {
        if ($breed->pets->count() > 0) {
            return redirect()->route('breed.index')->with('error', $breed->name . ' Cannot be delete');
        }
        $breed->delete();
        return redirect()->route('breed.index')->with('success', $breed->name . ' Deleted Successfully');
    }
}
