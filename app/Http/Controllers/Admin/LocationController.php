<?php

namespace App\Http\Controllers\Admin;

use App\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index()
    {
        $location = Location::all();
        return view('admin.location.index', compact('location'));
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);

        return view('admin.location.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:book_location,name,'.Location::find($id)->id.'',
        ]);

        Location::findOrFail($id)
            ->fill([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ])
            ->save();
        
        return redirect('admin/location')->with('success', ['Edit Success']);
    }

    public function create()
    {
        return view('admin.location.create');
    }

    public function store(Request $request)
    {        
        $this->validate($request, [
            'name' => 'required',
        ]);
        
        Location::Create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        
        return redirect('/admin/location');

    }

    public function destroy($id)
    {
        // try {
        //     User::where('id', $id)->firstOrFail()->delete();
        // } catch (ModelCouldNotDeletedException $exception) {
        //     return (['error' => 'U cant delete it']);
        // }
        Location::where('id', $id)->firstOrFail()->delete();

        return redirect()->back();
        
    }
}
