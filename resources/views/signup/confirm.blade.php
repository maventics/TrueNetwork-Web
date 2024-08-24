@extends('webistecontent.withoutbannersectionlayoutpage')
@section('title', 'Confirm')
@section('content')

    {{-- <div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <img src="/webisteasset/images/psx-logo.png" alt="" width="270px;">
        </div>
    </div>
</div> --}}


    <div class="services_section layout_padding " style="margin-top: -70px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="services_main">
                        <hr class="border">
                        <h1 class="services_taital">Your account has been created</h1>
                        <hr class="border">
                    </div>
                </div>
            </div>
            <div class="services_section_2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="icon_img"><img src="/webisteasset/images/icon-1.png"></div>
                        <h3 class="bitcoin_text">Download App</h3>
                        <p class="services_text">Use your account now to invest with Pakistan Stock Exchange Investors.
                            Download the Google App for enhanced features.</p>
                        {{-- <div class="readmore_btn"><a href="#"></a></div> --}}
                        <div class="row">
                            <div class="readmore_btn">
                                <a href="{{ App\Models\Setting::where('key', 'android_app_url')->get()->first()->value }}"
                                    target="_blank">
                                    <i class="fab fa-google-play fa-rotate-by"></i>&nbsp;Android App
                                </a>
                            </div>
                            <div class="readmore_btn">
                                <a href="{{ App\Models\Setting::where('key', 'ios_app_url')->get()->first()->value }}"
                                    target="_blank">
                                    <i class="fab fa-app-store fa-rotate-by"></i>&nbsp;IOS App
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="icon_img"><img src="/webisteasset/images/icon-3.png"></div>
                        <h3 class="bitcoin_text">Login</h3>
                        <p class="services_text">Unlock the potential of your account for investing with Pakistan Stock
                            Exchange Investors. Click here to access the login page.</p>
                        {{-- <div class="readmore_btn"><a href="#">Read More</a></div> --}}
                        <div class="readmore_btn"><a href="/invite-link">Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


{{-- <div class="started_bt active"><a href="/invite-link">Sign Up</a></div> --}}

{{-- <div class="buy_bt">
   <a href="{{ route('download.apk') }}" download="App">
       <i class="fab fa-google-play fa-rotate-by"></i>&nbsp;Android App
   </a>
</div> --}}
