<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\video;
use App\Models\course;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = video::latest()->get();
        $type='index';
        return view('admin.videos.index',compact('videos','type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses= course::select('id','name')->get();
        $video=new video();
        return view('admin.videos.create', compact('courses','video'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en'=> 'required',
            'name_ar'=> 'required',
            'path'=> 'required',
            'course_id' =>'required|exists:courses,id'
          ]);

          //upload file
          $path= time().rand().$request->file('path')->getClientOriginalName();
          $request->file('path')->move(public_path('uploads'),$path);


          $name = [
              'en'=> $request->name_en,
              'ar'=> $request->name_ar,
          ];

          video::create([
              'name' => json_encode($name, JSON_UNESCAPED_UNICODE),
              'path'=>$path,
              'type'=>$request->type,
              'course_id'=>$request->course_id,

          ]);

          return redirect()
              ->route('admin.videos.index')
              ->with('msg','Video Updated')
              ->with('type','info');
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
        $video=video::findOrFail($id);
        $courses = course::select('id','name')->get();
        return view('admin.videos.edit', compact('video','courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_en'=> 'required',
            'name_ar'=> 'required',
            'path'=> 'nullable',
            'course_id' =>'required|exists:courses,id'
          ]);


          $video=video::findOrFail($id);
          $path=$video->path;

          if($request->hasFile('path')){
                      //upload file
            $path= time().rand().$request->file('path')->getClientOriginalName();
            $request->file('path')->move(public_path('uploads'),$path);
          }


          $name = [
              'en'=> $request->name_en,
              'ar'=> $request->name_ar,
          ];

          $video->update([
              'name' => json_encode($name, JSON_UNESCAPED_UNICODE),
              'image'=>$path,
              'type'=>$request->type,
              'course_id'=>$request->course_id,

          ]);

          return redirect()
              ->route('admin.videos.index')
              ->with('msg','Video Added')
              ->with('type','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        video::destroy($id);

        return redirect()
        ->route('admin.videos.index')
        ->with('msg','Video moved to trash successfully')
        ->with('type','info');
    }

        /**
     * Display a listing of a trashed  resource.
     */
    public function trash()
    {
        $videos = video::onlyTrashed()->latest()->get();
        $type='trash';
        return view('admin.videos.index',compact('videos','type'));
    }



    /**
     * restore the specified resource from storage.
     */
    public function restore($id)
    {
        video::withTrashed()->find($id)->restore();

        return redirect()
            ->route('admin.videos.index')
            ->with('msg','Video untrashed successfully')
            ->with('type','success');
    }


    /**
     * forceDelete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        video::withTrashed()->find($id)->forceDelete();
        return redirect()
            ->route('admin.videos.index')
            ->with('msg','Video Deleted successfully')
            ->with('type','danger');
    }
}
