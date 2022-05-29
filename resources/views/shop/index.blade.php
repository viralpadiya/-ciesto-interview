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
$active_sidebar="shop";
$active_page="index";
@endphp
<div class="row">    
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-2">
                <div class="row">
                    <div class="col-md-2 py-1">
                       <a class="btn btn-primary btn-icon-split text-white" href="{{ url('/admin/shop/create') }}">
                         <span class="icon text-white-50">
                           <i class="fas fa-plus"></i>
                         </span>
                         <span class="text">Add</span>
                       </a> 
                    </div>
                    <div class="col-md-2 py-1">
                      <a class="btn btn-primary btn-icon-split text-white" href="{{ url('/admin/export-shop') }}">
                        <span class="icon text-white-50">
                          <i class="fas fa-file-export"></i>
                        </span>
                        <span class="text">Export </span>
                      </a> 
                   </div>                   
                    <div class="col-md-3 py-1">
                        
                      <button class="btn btn-primary btn-icon-split text-white" data-toggle="modal" data-target="#exampleModal">
                        <span class="icon text-white-50">
                          <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Import </span>
                      </button> 

                      
                      
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Import Shop</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ url('admin/import-shop') }}" 
                                enctype="multipart/form-data"
                                onsubmit="return checkLoder(this)" >
                                  @csrf
                                  @method("POST")
                                  <div class="col-md-12 mx-auto">
                        
                                    <div class="form-group row">                                    
                                        <div class="col-sm-12">
                                            <div class="custom-file">
                                              <input type="file" required class="custom-file-input custom-file" 
                                                        name="file" id="customFile" 
                                                        
                                                        onchange="readURL(this)">
                                              <label class="custom-file-label custom-file" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-icon-split">
                                      <span class="icon text-white-50">
                                        <i class="fas fa-save"></i>
                                      </span>
                                      <span class="text">Save</span>
                                    </button>
                                </div>
                                </form>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    
                </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-center" id="datatable-buttons" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th width="3%">Sr</th> 
                                               
                        <th width="15%">Email</th>
                        <th width="15%">Name</th>
                        <th width="22%">Address</th>
                        <th width="30%">Image</th>
                        
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
            url: base_url + "/admin/shop/show-all",
            type: "POST",
            data: {
                
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
                data: 'email',
                name: 'email'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'image',
                name: 'image',
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
               url:base_url+'/admin/shop/'+ uniq_id,
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