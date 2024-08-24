@extends('layout.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Bank</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Bank</li>
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
                    <p class="card-title">Bank</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModaladd">
                        ADD Bank
                    </button>

                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="banks_table" class="table table-bordered  nowrap table-striped align-middle "
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Bank Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banks as $bank)
                                    <tr>
                                        <td>{{ $bank->id }}</td>
                                        <td>{{ $bank->bank }}</td>
                                            <?php
                                            if ($bank->status == 0) {
                                                echo " <td><span class='badge bg-primary'>UnBlock</span></td>";
                                            }else {
                                                echo " <td><span class='badge bg-danger'>Block</span></td>";
                                            }

                                            ?>
                                        </td>
                                        <td>
                                            <i class="ri-ball-pen-fill" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalupdate{{ $bank->id }}"></i>
                                            {{-- <i class="ri-delete-bin-line"  data-bs-toggle="modal" data-bs-target="#deleteRecordModal{{ $bank->id }}"></i> --}}
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
                                                    <form action="{{ route('bank.update', $bank->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="">Bank Name</label>
                                                        <input type="text" name="bank" class="form-control" required
                                                            value="{{ $bank->bank }}">
                                                        @error('bank')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <label for="">Status</label>
                                                        {{-- <input type="text" name="status" class="form-control" required
                                                            value="{{ $bank->status }}"> --}}
                                                        <select name="status" id="" class="form-control" required>
                                                             <option value="0">UnBlock</option>    
                                                             <option value="1">Block</option>    
                                                        </select>    
                                                        @error('status')
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
                                        <form action="{{ route('bank.destroy', $bank->id) }}" method="POST">
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
                    <form action="{{ url('/admin/bank/store') }}" method="post">
                        @csrf
                        <label for="">Bank Name</label>
                        <input type="text" name="bank" required class="form-control">
                        @error('bank')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Status</label>
                        {{-- <input type="text" name="status" required class="form-control" value="0"> --}}
                        <select name="status" id="" class="form-control" required>
                            <option value="0">UnBlock</option>
                            <option value="1">Block</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
