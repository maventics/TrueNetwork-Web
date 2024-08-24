@extends('layout.app')
@section('title', 'Settings')
@section('content')

    @if ($message = Session::get('success'))
        <div id="successMessage"
            class="alert alert-success alert-dismissible alert-solid alert-label-icon fade show position-fixed top-0 end-0"
            style="z-index: 9999; margin-top: 25px;" role="alert">
            <i class="ri-check-double-line label-icon"></i><strong>{{ $message }}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('danger'))
        <div id="dangerMessage"
            class="alert alert-danger alert-dismissible alert-solid alert-label-icon fade show position-fixed top-0 end-0"
            style="z-index: 9999; margin-top: 25px;" role="alert">
            <i class="ri-error-warning-line label-icon"></i><strong>{{ $message }}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Settings</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
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
                    <p class="card-title">Settings</p>
                </div>
                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                            @foreach ($settings as $setting)
                                <form method="post" action="{{ route('update_setting') }}" enctype="multipart/form-data">
                                    @csrf
                                    <tr>
                                        <th>{{ $setting->key }}</th>
                                        <td>

                                            <div class="input-group">
                                                <input type="hidden" name="key"
                                                        value="{{ $setting->key }}" class="form-control">
                                                @if ($setting->key == 'default_currency_symbol')
                                                    <input type="text" name="value"
                                                        value="{{ $setting->value }}" class="form-control">
                                                @elseif($setting->key == 'logo')
                                                    <input type="file" name="value"  class="form-control" required>
                                                @else
                                                    <input name="value" value="{{ $setting->value }}"
                                                        class="form-control">
                                                @endif
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class='fas fa-sync fa-1x'></i>
                                                    </button>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                </form>
                            @endforeach
                        </thead>
                    </table>



                </div>
            </div>
        </div>
    </div>





@endsection
