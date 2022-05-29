@extends('layouts.dashbroad')
@section('title',$page_title)
@section('page_title', $page_title)
{{--  --}}
@section('nav_sectiton') 
<div >
    <ol class="breadcrumb float-sm-right mb-0">
      <li class="breadcrumb-item"><a href="{{ url('admin/home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ url('admin/shop') }}">{{ $page_title}}</a></li>
      <li class="breadcrumb-item active">Add</li>
    </ol>
</div>
@endsection
@section('content')
@php
$active_sidebar="shop";
$active_page="index";
@endphp
<div class="row">
    <div class="col-md-12">
       <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center">   
                <h6 class="m-0 font-weight-bold text-primary">Update {{ $page_title}}</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{ url('admin/shop')."/".$shop->id }}" 
                                enctype="multipart/form-data"
                                onsubmit="return checkLoder(this)" >
                @csrf                        
                @method('PATCH')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">Email</label>
                            <div class="col-sm-11">
                              <input type="text" class="form-control" 
                                placeholder="Email" value="{{ old('email') ?? $shop->email }}"
                                name="email"  required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">Name</label>
                            <div class="col-sm-11">
                              <input type="text" class="form-control" placeholder="Name" 
                                    value="{{ old('name') ?? $shop->name }}"
                                    name="name"  required />
                              <input type="hidden"  name="isvalid" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">Address</label>
                            <div class="col-sm-11">
                              <textarea class="form-control" placeholder="Address"
                                    name="address"  required >{{ old('address') ?? $shop->address }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-md-3 mx-auto">
                        
                        <div class="form-group row">                                    
                            <div class="col-sm-12">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input custom-file" 
                                            name="file" id="customFile" 
                                            accept="image/jpg,image/jpeg,image/png,image/gif" 
                                            onchange="readURL(this)">
                                  <label class="custom-file-label custom-file" for="customFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">                                    
                            <div class="col-sm-12">
                                <img class="img-thumbnail" id="thumb_img" alt="no-image" style="width:100%" src="{{$shop->image == "https://picsum.photos/200/300" ? $shop->image : url('/').$shop->image }}" data-holder-rendered="true">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-icon-split">
                          <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                          </span>
                          <span class="text">Update</span>
                        </button>
                    </div>
                </div>
                </form>
            </div>
       </div> 
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">




function readURL(input) {
    
    $('#thumb_img').attr('src', '');
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if(input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")){
        var reader = new FileReader();
        reader.onload = function(e) {
            var result= e.target.result;
            var image_html='<img class="img-thumbnail" id="thumb_img" alt="no-image" style="width:auto; " src="'+base_url+"/public/assets/backend/images/no-image.png"+'" data-holder-rendered="true">';        
            let myPromise = new Promise(function() {
                $("[name='isvalid']").val("1");   
                $(".custom-file").removeClass("is-invalid");     
                $('#appendHtml').empty();
                $('#appendHtml').html(image_html);
            });
            const imageresult=function() {

                $('#thumb_img').attr('src', result);
            }
            myPromise.then(imageresult());
        }
        reader.readAsDataURL(input.files[0]);
        return;
    }
    $("[name='isvalid']").val("0");
    $('#appendHtml').empty();
    $(".custom-file").addClass("is-invalid"); 
}
</script>
@endpush