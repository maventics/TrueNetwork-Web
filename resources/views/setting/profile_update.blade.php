@extends('layout.app')
@section('content')
     <!-- start page title -->
     <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Setting</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Setting</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="card-title">Update Profile</p>
                </div>
                <div class="card-body">

    @if ($message = Session::get('message'))
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
                    <form method="post" action="{{route('update_profile')}}" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered">
                            <thead>

                                <p class="text-warning"><strong>{{ auth()->user()->email }}</strong></p>
                                <tr class="mt-2">
                                    <th>Email</th>
                                    <th><input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control"></th>
                                    <th>Password</th>
                                    <th><input type="password" name="password" class="form-control"></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="col-12">
                            <input type="submit" value="Submit" class="btn btn-primary float-end">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
