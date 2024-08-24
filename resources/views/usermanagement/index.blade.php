@extends('layout.app')
@section('content')

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">User</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
   

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="card-title">Users</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModaladd">
                        Add User
                    </button>

                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="users_table" class="table table-bordered nowrap table-striped align-middle "
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    {{-- <th>Available Amount</th> --}}
                                    <th>Phone</th>
                                    <th>Referral Link</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                    <tbody>
                    </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div>
    <!--  add Modal -->
    <div class="modal fade" id="exampleModaladd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add an User</h5>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/user/store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="">Name</label>
                        <input type="text" name="name" required class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Email</label>
                        <input type="email" name="email" required class="form-control">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Phone</label>
                        <input type="number" name="phone" required class="form-control">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Password</label>
                        <input type="text" name="password" required class="form-control">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Image</label>
                        <input type="file" name="image" id=""  class="form-control">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <hr>
                    <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script type="text/javascript">
    $(function() {
     var table = $('#users_table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "/admin/user/index",
         columns: [
             { data: 'id', name: 'id' },
             { data: 'image', name: 'image' },
             { data: 'name', name: 'name' },
             { data: 'email', name: 'email' },
             { data: 'phone', name: 'phone' },
             { 
                 data: 'referral_link',
                 name: 'referral_link',
                 render: function(data, type, full, meta) {
                     return '<a href="https://pakistanstockexchangeinvesters.com/invite?id=' + data + '">https://pakistanstockexchangeinvesters.com/invite?id= '+ data +'</a>';
                 }
             },
             { data: 'status', name: 'status' },
             { data: 'action', name: 'action', orderable: false, searchable: true }
         ]
     });
 });
 </script>
 
 