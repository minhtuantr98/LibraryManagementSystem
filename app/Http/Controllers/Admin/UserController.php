<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Carbon\Carbon;
use App\Reader;
use App\LibraryCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = Reader::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = Reader::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.Reader::find($id)->id.'',
        ]);

        Reader::findOrFail($id)
            ->fill([
                'name' => $request->name,
                'email' => $request->email,
            ])
            ->save();
        
        return redirect('admin/user')->with('success', ['Edit Success']);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {        
        $this->validate($request, [
            'name' => 'required',
            'cmtnd' => 'required|unique:readers,cmtnd',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'address' => 'required',
            'telephone' => 'required',
            'class' => 'required',
        ]);
        
        Reader::Create([
            'name' => $request->name,
            'CMTND' => $request->cmtnd,
            'sex' => $request->gender, 
            'date_of_birth' => $request->date_of_birth, 
            'address' => $request->address, 
            'telephone' => $request->telephone, 
            'class' => $request->class,
        ]);
        
        LibraryCard::Create([
            'reader_id' => Reader::orderBy('name', 'desc')->first()->id,
            'admin_id' =>  Auth::user()->id,
            'date_create' => Carbon::now()->toDateTimeString(),
            'date_end' =>  Carbon::now()->addYears(5)->toDateTimeString(),
        ]);

        return redirect('/admin/user');

    }

    public function destroy($id)
    {
        // try {
        //     User::where('id', $id)->firstOrFail()->delete();
        // } catch (ModelCouldNotDeletedException $exception) {
        //     return (['error' => 'U cant delete it']);
        // }
        Reader::where('id', $id)->firstOrFail()->delete();

        return redirect()->back();
    }
}
