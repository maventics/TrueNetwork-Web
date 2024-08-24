@extends('layout.app')
@section('content')
<!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Send Notification</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Send Notification</li>
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
                <p class="card-title">Send Notification</p>
            </div>
            <div class="card-body">

                <!-- Add Record Form -->
                <div class="">
                    <form action="{{ url('/admin/sendnotification/store') }}" method="post" id="myForm">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>

                         {{-- Links is use to create this ! --}}
                        <div class="form-group mb-3">
                            <label for="user_select">Select Users:</label>
                            <select name="user_ids[]" id="user_select" multiple class="form-control">
                                <option value="" disabled selected>Choose the user(s)</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                                <optgroup label="All Users">
                                    <option value="all" data-all-users="{{ json_encode($users->pluck('id')) }}">All Users</option> <!-- Option for selecting all users -->
                                </optgroup>
                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                                    </div>
                <!-- End Add Record Form -->
            </div>
        </div>
    </div>
</div>

@endsection
<!-- Include jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 on the select element
        $('#user_select').select2();
    });
</script>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    $(document).ready(function() {
        $('#user_select').change(function() {
            if ($(this).val() && $(this).val().includes('all')) {
                var allUsers = $(this).find('option[value="all"]').data('all-users');
                $(this).val(allUsers);
            }
        });
    });
</script>




