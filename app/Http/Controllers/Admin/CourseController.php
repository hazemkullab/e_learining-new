<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\course;
use App\Models\category;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = course::latest()->get();
        $type='index';
        return view('admin.courses.index',compact('courses','type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $categories= category::all();
       $course = new course();

        return view('admin.courses.create',compact('categories', 'course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
          'name_en'=> 'required',
          'name_ar'=> 'required',
          'en_content'=> 'required|min:100',
          'ar_content'=> 'required|min:100',
          'image'=> 'required|image|mimes:png,jpg,jpeg,gif,svg',
          'discount'=>'nullable|numeric',
          'category_id' =>'required'
        ]);

        //upload file
        $imagename= time().rand().$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads'),$imagename);


        $name = [
            'en'=> $request->name_en,
            'ar'=> $request->name_ar,
        ];

        $excerpt = [
            'en'=> $request->en_excerpt,
            'ar'=> $request->ar_excerpt,
        ];

        $content = [
            'en'=> $request->en_content,
            'ar'=> $request->ar_content,
        ];

        course::create([
            'name' => json_encode($name, JSON_UNESCAPED_UNICODE),
            'slug'=>Str::slug($request->name_en),
            'excerpt' => json_encode($excerpt, JSON_UNESCAPED_UNICODE),
            'content' => json_encode($content, JSON_UNESCAPED_UNICODE),
            'image'=>$imagename,
            'discount'=>$request->discount,
            'category_id'=>$request->category_id,

        ]);

        return redirect()
            ->route('admin.courses.index')
            ->with('msg','Course Added')
            ->with('type','success');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course=course::findOrFail($id);
        $categories = category::select('id','name')->get();
        return view('admin.courses.edit', compact('course','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name_en'=> 'required',
            'name_ar'=> 'required',
            'en_content'=> 'required|min:100',
            'ar_content'=> 'required|min:100',
            'image'=> 'nullable|image|mimes:png,jpg,jpeg,gif,svg',
            'discount'=>'nullable|numeric',
            'category_id' =>'required'
          ]);

          $course = course::findOrFail($id);
          $imagename = $course->image;

          if($request->hasFile('image')){
            //upload file
                $imagename= time().rand().$request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('uploads'),$imagename);

          }


          $name = [
              'en'=> $request->name_en,
              'ar'=> $request->name_ar,
          ];

          $excerpt = [
              'en'=> $request->en_excerpt,
              'ar'=> $request->ar_excerpt,
          ];

          $content = [
              'en'=> $request->en_content,
              'ar'=> $request->ar_content,
          ];

          $course->update([
              'name' => json_encode($name, JSON_UNESCAPED_UNICODE),
              'excerpt' => json_encode($excerpt, JSON_UNESCAPED_UNICODE),
              'content' => json_encode($content, JSON_UNESCAPED_UNICODE),
              'image'=>$imagename,
              'discount'=>$request->discount,
              'category_id'=>$request->category_id,

          ]);

          return redirect()
              ->route('admin.courses.index')
              ->with('msg','Course Updated')
              ->with('type','info');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        course::destroy($id);

            return redirect()
            ->route('admin.courses.index')
            ->with('msg','Course moved to trash successfully')
            ->with('type','info');
    }

        /**
     * Display a listing of a trashed  resource.
     */
    public function trash()
    {
        $courses = course::onlyTrashed()->latest()->get();
        $type='trash';
        return view('admin.courses.index',compact('courses','type'));
    }



    /**
     * restore the specified resource from storage.
     */
    public function restore($id)
    {
        course::withTrashed()->find($id)->restore();

        return redirect()
            ->route('admin.courses.index')
            ->with('msg','Course untrashed successfully')
            ->with('type','success');
    }


    /**
     * forceDelete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        course::withTrashed()->find($id)->forceDelete();
            return redirect()
                ->route('admin.courses.index')
                ->with('msg','Course Deleted successfully')
                ->with('type','danger');
    }
}
