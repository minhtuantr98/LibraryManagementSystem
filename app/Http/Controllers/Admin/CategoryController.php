<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:book_categories,name,'.Category::find($id)->id.'',
        ]);

        Category::findOrFail($id)
            ->fill([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ])
            ->save();
        
        return redirect('admin/category')->with('success', ['Edit Success']);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {        
        $this->validate($request, [
            'name' => 'required',
        ]);
        
        Category::Create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        
        return redirect('/admin/category');

    }

    public function destroy($id)
    {
        // try {
        //     User::where('id', $id)->firstOrFail()->delete();
        // } catch (ModelCouldNotDeletedException $exception) {
        //     return (['error' => 'U cant delete it']);
        // }
        Category::where('id', $id)->firstOrFail()->delete();

        return redirect()->back();
    }
}
