@extends('layouts.admin_master')
@section('page_title', 'Admin - Dashboard')
@section('admin_main_content')

<div class="row  mx-auto container-fluied">
<div class="col-lg-9 text-center ">
    <div class="card-style mb-30 ">
        <h3 class="mb-10">ABout Section</h3>

        <div class="table table-bordered table-striped table-hover col-lg-6 text-center  col-md-12 col-12 mt-5">
          <table class="table striped-table">
            <thead>
                <tr>
                    <th> <h6> Sl.No</h6></th>
                    <th>
                      <h6> title</h6>
                    </th>
                    <th>
                      <h6>Slug</h6>
                    </th>
                    <th>
                        <h6>Author</h6>
                      </th>
                      <th>
                        <h6>Description</h6>
                      </th>
                    <th>
                      <h6>Status</h6>
                    </th>
                    <th>
                        <h6>Action</h6>
                      </th>
                  </tr>
              <!-- end table row-->
            </thead>
            <tbody>
@forelse ( $abouts as $key=> $about )
<tr>
    <td>
      <h6 class="text-sm">#{{ $abouts->firstItem()+$key }}</h6>
    </td>
    <td>
      <p>{{ $about->title}}</p>
    </td>
    <td>
      <p>{{ $about->slug }}</p>
    </td>

    <td>
        <p>{{ $about->author->name}}</p>
      </td>
      <td>
        <p>{{ $about->description}}</p>
      </td>
    <td>
        <div class="form-check form-switch toggle-switch ">
            <input class="form-check-input change_status" type="checkbox"{{$about->status ?'checked':'' }} data-post-id="{{$about->id }}">

          </div>
    </td>
    <td class="d-flex" >
        <a href="{{ route('admin.about.edit', $about->id) }}" class="btn btn-sm btn-warning btn-hover"><i class="fas fa-edit"></i></a>

       <button class="btn  btn-sm btn-danger btn-hover delete_btn">
        <i class="fas fa-trash"></i>
    </button>
 <form  action="{{ route('admin.about.delete', $about->id)}}"method="POST">
        @csrf
        @method('DELETE')

       </form>
    </td>
  </tr>
@empty
<tr>
    <td colspan="5"class="text-center text-danger"><strong>No Data Found</strong></td>
</tr>
@endforelse
              <!-- end table row -->

              <!-- end table row -->
            </tbody>
          </table>
          <!-- end table -->
        </div>
<div>
{{ $abouts->links() }}
</div>
      </div>
</div>
<div class="col-lg-3">
    <div class="card-style mb-30">
        <h6 class="mb-25 text-center">{{ isset($Data)? 'Update' :'Create new' }} About</h6>
       <form action=" {{ isset($Data)? route('admin.about.update',$Data->id) : route('admin.about.store') }}" method="POST">
        @isset($Data)
@method('PUT')
        @endisset

        @csrf

        <div class="select-style-1 ">
            <label>Author</label><br><br>
            <div class="select-position">
              <select name="author">
                <option>Select Author</option>
               @foreach ($authors as $author )
               <option value="{{ $author->id }}">{{ $author->name }}</option>
               @endforeach


              </select>
            </div>
          </div>


        <div class="input-style-1"><br>
            <label>title Name </label><br><br>
            <input type="text" placeholder="Title"name="title"value="{{ isset($Data)? $Data->title :'' }}"><br><br>
            @error('title')
            <p class="text-danger">{{ $message }}</p>
                        @enderror
          </div>
          <div class="input-style-1">
            <label for=""> Description</label><br><br>
            <textarea  id="description_editor" placeholder="Description" name="description"class="form-control mb-4">{{ isset($Data)? $Data->description:'' }}</textarea>
            @error('description')
            <p class="text-danger">{{ $message}}</p>
                      @enderror
        </div>
          <div class="input-style-1">
              <button type="submit"class="main-btn primary-btn btn-hover w-100"style="color:rgb(14, 13, 13); background-color:aqua ">{{ isset($Data)? 'Update' :'Create new' }}About</button>
                        </div>
       </form>

      </div>
</div>
</div>
@endsection

@push('additional_js')
<script src="{{ asset('backend/assets/js/sweetalert2@11.js')}}"></script>

    <script>
const Toast = Swal.mixin({
  toast: true,
  position: "bottom-end",
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});


$('.change_status').on('change',function(){
$.ajax({


    url: "{{ route('admin.about.change_status') }}",
    method:"GET",
    data:{
post_id: $(this).data('post-id')
    },
    success: function(){
        Toast.fire({
  icon: "success",
  title: "Status Change successfully"
});


    }
})

})

    </script>
<script>
    $('.delete_btn').on('click' , function(){
        Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
$(this).next('form').submit();
      }
    });
    })
    </script>
@endpush
@push('additional.bd')
<style>
/* body{
    background-color:rgb(176, 220, 160);
} */
</style>
@endpush
