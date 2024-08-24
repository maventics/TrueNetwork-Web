@extends('layout.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">PSX Bank Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">PSX Bank Details</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    @if ($message = Session::get('success'))
        <div id="successMessage" class="alert alert-primary text-primary mt-3">
            <p class="fs-14">{{ $message }}</p>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div id="dangerMessage" class="alert alert-danger text-primary mt-3">
            <p class="fs-14">{{ $message }}</p>
        </div>
    @endif


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Something went wrong.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="card-title">PSX Bank Details</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModaladd">
                        ADD PSX Bank Details
                    </button>

                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="adminbanks_table" class="table table-bordered  nowrap table-striped align-middle "
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Account Title</th>
                                    <th>Account Number<small class="text-danger">*</small></th>
                                    <th>Bank Name</th>
                                    {{-- <th>Admin Id</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adminbanks as $bank)
                                    <tr>
                                        <td>{{ $bank->id }}</td>
                                        <td>{{ $bank->account_title }}</td>
                                        <td>{{ $bank->account_number }}</td>
                                        <td>{{ $bank->bank->bank }}</td>
                                        {{-- <th>{{ $bank->admin->adminname }}</th> --}}
                                        <td>
                                            <i class="ri-ball-pen-fill" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalupdate{{ $bank->id }}"></i>
                                            {{-- <i class="ri-delete-bin-line" data-bs-toggle="modal"
                                                data-bs-target="#deleteRecordModal{{ $bank->id }}"></i> --}}
                                        </td>
                                    </tr>
                                    <!--  add Modal -->
                                    <div class="modal fade" id="exampleModalupdate{{ $bank->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Record</h5>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('adminbank.update', $bank->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="">Account Title</label>
                                                        <input type="text" name="account_title" class="form-control"
                                                            value="{{ $bank->account_title }}">
                                                        @error('account_title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <label for="">Account Number</label>
                                                        <input type="text" name="account_number" class="form-control"
                                                            value="{{ $bank->account_number }}">
                                                        @error('account_number')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <label for="">Bank Name</label>
                                                        <select name="bank_id" id="" class="form-control">
                                                            <option value="">Choose the Bank..!</option>
                                                            @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}">{{ $bank->bank }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('bank_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <label for="">Admin</label>
                                                        <select name="admin_id" id="" class="form-control">
                                                            <option value="">Choose the Admin..!</option>
                                                            @foreach ($admins as $admin)
                                                                <option value="{{ $admin->id }}">
                                                                    {{ $admin->adminname }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('admin_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>

                                                    <input type="submit" value="Update" class="btn btn-primary">
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                    </div>

                    {{-- delete modal --}}

                    <!-- Modal -->
                    <div class="modal fade zoomIn" id="deleteRecordModal{{ $bank->id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="btn-close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mt-2 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                            colors="primary:#f7b84b,secondary:#f06548"
                                            style="width:100px;height:100px"></lord-icon>
                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                            <h4>Are you Sure ?</h4>
                                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record ?
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                        <form action="{{ route('adminbank.destroy', $bank->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->
                    @endforeach
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/adminbank/store') }}" method="post">
                        @csrf
                        <label for="">Account Title</label>
                        <input type="text" name="account_title" required class="form-control">
                        @error('account_title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Account Number</label>
                        <input type="text" name="account_number" required class="form-control">
                        @error('account_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Bank Name</label>
                        <select name="bank_id" id="" class="form-control">
                            <option value="">Choose the Bank..!</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->bank }}</option>
                            @endforeach
                        </select>
                        @error('bank_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Admin</label>
                        <select name="admin_id" id="" class="form-control">
                            <option value="">Choose the Admin..!</option>
                            @foreach ($admins as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->adminname }}</option>
                            @endforeach
                        </select>
                        @error('admin_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>

                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
