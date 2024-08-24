@extends('layout.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Scheme</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Scheme</li>
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

    @if (session('alert'))
    <div class="alert alert-danger">
        {{ session('alert') }}
    </div>
@endif




    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">

                    <p class="card-title">Scheme</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModaladd">
                        ADD Scheme
                    </button>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="schemes_table" class="table table-bordered  nowrap table-striped align-middle "
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>User  ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Profit <strong class="text-danger">%</strong><small>(Percent)</small></th>
                                    <th>Duration</th>
                                    <th>User Investment Limit</th>
                                    <th>Investment Limit</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schemes as $scheme)
                                    <tr>
                                        <td>{{ $scheme->id }}</td>
                                        <td>{{ $scheme->title }}</td>
                                        <td>{{ $scheme->sub_title }}</td>
                                        <td>{{ $scheme->profit }} <small>%</small></td>
                                        <td>{{ $scheme->duration }} <small>(Days)</small></td>
                                        <td>{{ $scheme->user_investment_limit }}</td>
                                        <td>
                                            {{ number_format($scheme->starting_investment) }} - {{ number_format($scheme->ending_investment) }}
                                        </td>
                                        <td>
                                            <a href="/update-scheme-status/{{ $scheme->id }}" class="btn btn-sm btn-{{ $scheme->status ? 'success' : 'danger' }}">
                                                {{ $scheme->status ? 'Unlock' : 'Lock' }}

                                            </a>
                                        </td>


                                        <td>
                                            <a href="/admin/scheme/view/{{ $scheme->id }}"><i
                                                    class="ri-eye-line text-dark"></i></a>
                                            <i class="ri-ball-pen-fill" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalupdate{{ $scheme->id }}"></i>

                                        </td>
                                    </tr>
                                    {{--  --}}
                                    <!--  add Modal -->
                                    <div class="modal fade" id="exampleModalupdate{{ $scheme->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Record</h5>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('scheme.update', $scheme->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="">Scheme Title</label>
                                                        <input type="text" name="title" required class="form-control"
                                                            value="{{ $scheme->title }}">
                                                        @error('title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <label for="">Sub Title</label>
                                                        <input type="text" name="sub_title" required class="form-control"
                                                            value="{{ $scheme->sub_title }}">
                                                        @error('sub_title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                        <label for="profit">profit <strong class="text-danger">%</strong><small>(Percent)</small></label>
                                                        <input type="number" step="0.01" name="profit"  required class="form-control" value="{{ $scheme->profit }}">
                                                        @error('profit')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <label for="">Duration</label>
                                                        <input type="number" name="duration" required class="form-control"
                                                            value="{{ $scheme->duration }}">
                                                        @error('duration')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <label for="">User Investment Limit</label>
                                                        <input type="number" name="user_investment_limit" required class="form-control"
                                                            value="{{ $scheme->user_investment_limit }}">
                                                        @error('user_investment_limit')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <label for="">Starting Investment</label>
                                                        <input type="number" name="starting_investment" required class="form-control"  value="{{ $scheme->starting_investment }}">
                                                        @error('starting_investment')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <label for="">End Investment</label>
                                                        <input type="number" name="ending_investment" required class="form-control"  value="{{ $scheme->ending_investment }}">
                                                        @error('ending_investment')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                        <label for="">Background Image</label>
                                                        <input type="file" name="image" id=""
                                                            class="form-control" value="{{ $scheme->image }}" >
                                                        @error('image')
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



                    {{-- view modal --}}
                    {{-- <div class="modal fade" id="showmodal{{ $scheme->id }}" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Scheme Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if ($scheme->bg_image)
                                            <img class="sq_image" src="{{ asset('upload_image/' . $scheme->bg_image) }}" alt="Scheme Image">
                                          @else
                                            <p class="text-center">Image not found</p>
                                          @endif

                                        </div>

                                        <div class="col-md-9">
                                            <p><strong>Title:</strong> {{ ucwords($scheme->title) }}</p>
                                            <p><strong>Description:</strong> {{ ucwords($scheme->sub_title) }}</p>
                                            <p><strong>Profit:</strong> {{ $scheme->profit }} <small>(%)</small></p>
                                            <p><strong>Duration:</strong> {{ ucwords($scheme->duration) }} <small>(Days)</small></p>
                                            <p><strong>Duration:</strong> {{ ucwords($scheme->duration) }} <small>(Days)</small></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}


                    {{-- view modal --}}
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
                    <form action="{{ url('/admin/scheme/store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="">Scheme Title</label>
                        <input type="text" name="title" required  class="form-control">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Sub Title</label>
                        <input type="text" name="sub_title" required class="form-control">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Profit with percentage <strong class="text-danger">%</strong><small>(Percent)</small></label>
                        <input type="number" name="profit" required class="form-control">
                        @error('profit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Duration</label>
                        <input type="number" name="duration" required class="form-control">
                        @error('duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">User Investment Limit</label>
                        <input type="number" name="user_investment_limit" required class="form-control">
                        @error('user_investment_limit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <label for="">Starting Investment</label>
                        <input type="number" name="starting_investment" required class="form-control" >
                        @error('starting_investment')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">End Investment</label>
                        <input type="number" name="ending_investment" required class="form-control" >
                        @error('ending_investment')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <label for="">Image</label>
                        <input type="file" name="image" id="" required class="form-control" >
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

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
