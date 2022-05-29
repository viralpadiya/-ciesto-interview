@extends('layouts.dashbroad')
@section('title',$page_title)
@section('page_title', $page_title)
{{--  --}}
@section('nav_sectiton') 
<div >
    <ol class="breadcrumb float-sm-right mb-0">
      <li class="breadcrumb-item"><a href="{{ url('admin/home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ url('admin/product') }}">{{ $page_title}}</a></li>
      <li class="breadcrumb-item active">Update</li>
    </ol>
</div>
@endsection
@section('content')
@php
$active_sidebar="product";
$active_page="index";
@endphp
<div class="row">
    <div class="col-md-12">
       <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center">   
                <h6 class="m-0 font-weight-bold text-primary">Update {{ $page_title}}</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{ url('admin/product').'/'.$product->id }}" 
                                enctype="multipart/form-data"
                                onsubmit="return checkLoder(this)" >
                @csrf                        
                @method('PATCH')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">Shop</label>
                            <div class="col-sm-11">
                                <select class="form-control" name="shop_id">
                                    @foreach ($shop as $shop)
                                    <option value="{{$shop->id}}" {{$shop->id==$product->shop_id ? "selected":""}}>{{$shop->name}}</option>                                       
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">Name</label>
                            <div class="col-sm-11">
                              <input type="text" class="form-control" placeholder="Name" 
                                    value="{{ old('name') ?? $product->name }}"
                                    name="name"  required />
                              <input type="hidden"  name="isvalid" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">Price</label>
                            <div class="col-sm-11">
                              <input type="number" class="form-control" 
                                placeholder="Price" value="{{ old('price') ?? $product->price  }}"
                                name="price"  required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">Stock</label>
                            <div class="col-sm-11">
                              <input type="number" class="form-control" 
                                placeholder="Stock" value="{{ old('stock') ?? $product->stock  }}"
                                name="stock"  required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mx-auto">
                        <div class="form-group row">                                    
                            <div class="col-sm-12">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input custom-file" 
                                            name="file" id="customFile" 
                                            accept="video/*" 
                                            onchange="readURL(this)">
                                  <label class="custom-file-label custom-file" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <video width="320" height="150" controls>
                                    <source src="{{url('/') . $product->video }}">
                                </video>
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
</script>
@endpush