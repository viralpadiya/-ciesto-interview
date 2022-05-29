@extends('layouts.dashbroad')
@section('title',$page_title)
@section('page_title', $page_title)

@section('nav_sectiton') 
<div >
    <ol class="breadcrumb float-sm-right mb-0">
      <li class="breadcrumb-item"><a href="{{ url('admin/home') }}">Home</a></li>
      <li class="breadcrumb-item active">{{ $page_title}}</li>
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
            <div class="card-header py-2">
                <div class="row">
                    <div class="col-md-2 py-1">
                       <a class="btn btn-primary btn-icon-split text-white" href="{{ url('/admin/product/create') }}">
                         <span class="icon text-white-50">
                           <i class="fas fa-plus"></i>
                         </span>
                         <span class="text">Add</span>
                       </a> 
                    </div>
                    <div class="col-md-3 py-1">
                      <input type="number" class="form-control" 
                        placeholder="MIN PRICE" id="min"  />
                    </div>
                    <div class="col-md-3 py-1">
                      <input type="number" class="form-control" 
                      placeholder="MAX PRICE" id="max"  /> 
                    </div>
                    
                </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-center" id="datatable-buttons" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="3%">Sr</th> 
                      <th width="15%">Name</th>
                      <th width="15%">Shop</th>
                      <th width="15%">Price</th>
                      <th width="15%">Stock</th>
                      <th width="22%">video</th>                        
                      <th width="15%"></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript" >
$(document).ready(function() {
        var table = $('#datatable-buttons').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "/admin/product/show-all",
            type: "POST",
            data: {
                'min': function() {
                    return $('#min').val();
                },
                'max': function() {
                    return $('#max').val();
                },
                
            } // Some data that the server needs
        },
        order: [
            [0, "DESC"]
        ],
        columns: [{
                data: 'DT_RowIndex',
                name: 'id',
                searchable: false
            },
            {
                data: 'name',
                name: 'products.name'
            },
            {
                data: 'shop_name',
                name: 'shop.name'
            },
            {
                data: 'price',
                name: 'products.price'
            },
            {
                data: 'stock',
                name: 'products.stock'
            },
            {
                data: 'video',
                name: 'products.video',
                orderable: false,
                searchable: false
            },
            
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        
    });
    $('#min,#max').keyup(function() {
        table.ajax.reload();
    });
    $('body').on('click', '[data-id=delete]', function(e) {
        e.preventDefault();
        var uniq_id=$(this).data("value");
        alertify.confirm("Confirm?", function(ev) {
            ev.preventDefault();
            
            $.ajax({               
               type:'DELETE',
               data:{                    
                    'uniq_id':uniq_id,
               },
               url:base_url+'/admin/product/'+ uniq_id,
               success:function(data) {
                 alertify.success(data.message);
                 table.ajax.reload();
                }
            });
        });
    });
  });
</script>
@endpush