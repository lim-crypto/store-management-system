<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TypeRequest;
use App\Model\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
    }
    public function create()
    {
        return view('admin.types.create');
    }

    public function store(TypeRequest $request)
    {
        $type = new Type;
        $type->name = $request->name;
        $type->image = Helper::saveImage($request->image, $request->name, 'type');
        $type->save();
        return redirect()->route('type.index')->with('success', $type->name . ' Added Successfully');
    }

    public function update(TypeRequest $request, Type $type)
    {
        $type->name = $request->name;
        if ($request->image) {
            Helper::deleteImage($type->image, 'type');
            $type->image = Helper::saveImage($request->image, $request->name, 'type');
        }
        $type->save();
        return redirect()->route('type.index')->with('success', $type->name . ' Updated Successfully');
    }

    public function destroy(Type $type)
    {
        if ($type->breed->count() > 0) {
            return redirect()->route('type.index')->with('error', $type->name . ' Cannot be delete');
        }
        Helper::deleteImage($type->image, 'type');
        $type->delete();
        return redirect()->route('type.index')->with('success', $type->name . ' Deleted Successfully');
    }
}
