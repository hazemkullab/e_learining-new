<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label>English Name</label>
            <input name="name_en" value="{{ old('name_en',$video->en_name) }}" class="form-control" placeholder="English Name">
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label>Arabic Name</label>
            <input name="name_ar" value="{{ old('name_ar',$video->ar_name) }}" class="form-control" placeholder="Arabic Name">
        </div>
    </div>


    <div class="col-md-12">
        <div class="mb-3">
            <label> Video </label>
            <input type="file" name="path" class="form-control">
            @if ($video->path)
            
            <video width="400"  src="{{ asset('uploads/'.$video->path)}}"controls></video>

            @endif
            {{-- <img width="100" class="img-thumbnail" src="{{ asset('uploads/'.$video->image)}}" alt=""> --}}
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label> Type </label><br>
            <label><input type="radio" checked  name="type" value="paid" >paid</label><br>
            <label><input type="radio" onclick="return confirm ('Are You Sure ?')"  name="type" value="free" >free</label>
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label>Course</label>
                <select class="form-control" name="course_id" id="">
                    <option value="" selected>Select</option>
                    @foreach ($courses as $item)
                    <option {{ ($item->id == $video->course_id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->trans_name }}</option>
                    @endforeach
                </select>
        </div>
    </div>
