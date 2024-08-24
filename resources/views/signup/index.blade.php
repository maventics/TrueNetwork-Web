@extends('webistecontent.withoutbannersectionlayoutpage')
@section('title', 'Sign Up')
@section('content')
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    .input-group .form-control {
        border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;
        border-top-right-radius: 50px;
        border-bottom-right-radius: 50px;
    }
    .input-group .input-group-text {
        border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;
    }
    .input-group .form-control {
        border-top-right-radius: 50px;
        border-bottom-right-radius: 50px;
    }
</style>




<div class="services_section layout_padding "  >
    <div class="container">
       <div class="row">
          <div class="col-md-12">
             <div class="services_main">
                <hr class="border">
                <h1 class="services_taital">Sign Up</h1>
                <hr class="border">
             </div>
          </div>
       </div>

       



       <div class="services_section_2 text-center">
        <div class="row justify-content-center">
            <div class="col-md-7" >
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
            
                <form action="{{ url('/signup/store') }}" method="post" class="form-group">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="name" id="name" placeholder="Your Name" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="phone" id="phone" placeholder="Your Phone" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" name="email" id="email" placeholder="Your Email" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" name="password" id="password" placeholder="Your Password" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                        </div>
                        @if($name)
                            <input type="text" name="referral_id" id="referral" value="You were invited by {{ $name }}" class="form-control" disabled>
                        @else
                            <input type="text" name="referral_id" id="referral" value="No Referral ID provided." class="form-control" disabled>
                        @endif
                    </div>
                    {{-- here the referral id submit --}}
                        @if($id)
                            <input type="text" name="referral_id" id="referral" value="{{ $id }}" class="form-control" hidden>
                        @else
                            <input type="text" name="referral_id" id="referral" value="No Referral ID provided." class="form-control" hidden>
                        @endif
                  
                    
                    <div class="mb-3">
                        <input type="submit" value="Create Account" class="btn btn-success rounded-pill">
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    
    </div>
 </div>

 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection