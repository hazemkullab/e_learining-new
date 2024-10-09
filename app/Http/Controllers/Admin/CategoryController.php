<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = category::latest()->get();
        $type='index';
        return view('admin.categories.index',compact('categories','type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = category::select('id','name')->get();
        $category = new category();
        return view('admin.categories.create',compact('categories','category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);


        $name=[
            'en'=> $request->name_en,
            'ar'=> $request->name_ar
        ];

        category::create([
            'name'=> json_encode($name,JSON_UNESCAPED_UNICODE),
            'slug'=>Str::slug($request->name_en),
            'parent_id'=> $request->parent_id
        ]);

        return redirect()
        ->route('admin.categories.index')
        ->with('msg','Category Added')
        ->with('type','success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return'eee';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category=category::findOrFail($id);
        $categories = category::select('id','name')->get();
        return view('admin.categories.edit', compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);


        $name=[
            'en'=> $request->name_en,
            'ar'=> $request->name_ar
        ];

        category::findOrFail($id)->update([
            'name'=> json_encode($name,JSON_UNESCAPED_UNICODE),
            'slug'=>Str::slug($request->name_en),
            'parent_id'=> $request->parent_id
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('msg','Category Updated')
            ->with('type','warning');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        category::destroy($id);

        return redirect()
        ->route('admin.categories.index')
        ->with('msg','Category moved to trash successfully')
        ->with('type','info');
    }




        /**
     * Display a listing of a trashed  resource.
     */
    public function trash()
    {
        // return'eee';

        $categories = category::onlyTrashed()->latest()->get();
        $type='trash';
        return view('admin.categories.index',compact('categories','type'));
    }



    /**
     * restore the specified resource from storage.
     */
    public function restore($id)
    {
        category::withTrashed()->find($id)->restore();
        return redirect()
            ->route('admin.categories.index')
            ->with('msg','Category untrashed successfully')
            ->with('type','success');

    }



    /**
     * forceDelete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        category::withTrashed()->find($id)->forceDelete();
            return redirect()
                ->route('admin.categories.index')
                ->with('msg','Category Deleted successfully')
                ->with('type','danger');
    }
}
