<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>@yield('title')</title>

      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="/webisteasset/css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="/webisteasset/css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="/webisteasset/css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="/webisteasset/images/fevicon.png" type="image/gif" />
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700,800|Raleway:400,600,700,800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="/webisteasset/css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   
      
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


   </head>
   <body>
 <div class="header_section">
         <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               {{-- <a class="navbar-brand"href="index.html"><img src="/webisteasset/images/logo.png"></a> --}}
               <b style='color:white'>PSX_I</b>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">Home</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('services') }}">Services</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('features') }}">Features</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('team') }}">Team</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">Blog</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('privacypolicy') }}">Privacy Policy</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                     </li>
                  </ul>
                  </form>
               </div>
            </nav>
         </div>
         <!-- banner section start -->
         <div class="banner_section layout_padding">
            <div class="container">
               <div id="banner_slider" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                     <div class="carousel-item active">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="banner_taital_main">
                                 <h1 class="banner_taital">We Provider <span style="color: #02a763;">Best services</span></h1>
                                 <p class="banner_text">use a passage of Lorem Ipsum, you need to be sure there isn't anything</p>
                                 <div class="btn_main">
                                    <div class="started_bt active"><a href="#">Get a Quote</a></div>
                                                  <div class="buy_bt">
                                       <a href="" download="App">
                                          About Us
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="carousel-item">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="banner_taital_main">
                                 <h1 class="banner_taital">We Provider <span style="color: #02a763">Best services</span></h1>
                                 <p class="banner_text">use a passage of Lorem Ipsum, you need to be sure there isn't anything</p>
                                 <div class="btn_main">
                                    <div class="started_bt active"><a href="#">Get a Quote</a></div>
                                                  <div class="buy_bt">
                                       <a href="" download="App">
                                          About Us
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="carousel-item">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="banner_taital_main">
                                 <h1 class="banner_taital">We Provider <span style="color: #02a763">Best services</span></h1>
                                 <p class="banner_text">use a passage of Lorem Ipsum, you need to be sure there isn't anything</p>
                                 <div class="btn_main">
                                    <div class="started_bt active"><a href="#">Get a Quote</a></div>
                                                  <div class="buy_bt">
                                       <a href="" download="App">
                                           About Us
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <a class="carousel-control-prev" href="#banner_slider" role="button" data-slide="prev">
                  <i class="fa fa-angle-left"></i>
                  </a>
                  <a class="carousel-control-next" href="#banner_slider" role="button" data-slide="next">
                  <i class="fa fa-angle-right"></i>
                  </a>
               </div>
            </div>
         </div>
         <!-- banner section end -->
      </div>
      <!-- header section end -->
      <!-- start content -->
      @yield('content')
      <!-- end content -->

      <!-- footer section start -->
      <div class="footer_section layout_padding margin_top90">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-sm-6">
                  <h3 class="useful_text">Our Company</h3>
                  <div class="footer_menu">
                     <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="contact.html">Contact</a></li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <h3 class="useful_text">Our Company</h3>
                  <div class="footer_menu">
                     <ul>
                        <li><a href="#">Faq</a></li>
                        <li><a href="#">Terms Of Services</a></li>
                        <li><a href="#">404</li>
                        <li><a href="#">Register</a></li>
                        <li><a href="#">Login</a></li>
                        <li><a href="#">Coming Soon</a></li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <h1 class="useful_text">Contact us</h1>
                  <div class="location_text">
                     <ul>
                        <li>
                           <a href="#"><span class="padding_left_10"><i class="fa fa-map-marker" aria-hidden="true"></i></span>Location</a>
                        </li>
                        <li>
                           <a href="#"><span class="padding_left_10"><i class="fa fa-phone" aria-hidden="true"></i></span>+01 1234567890</a>
                        </li>
                        <li>
                           <a href="#"><span class="padding_left_10"><i class="fa fa-envelope" aria-hidden="true"></i></span>demo@gmail.com</a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <h1 class="useful_text">Newsletter</h1>
                  <div class="form-group">
                     <textarea class="update_mail" placeholder="Your Email" rows="5" id="comment" name="Your Email"></textarea>
                     <div class="subscribe_bt"><a href="#"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></div>
                  </div>
                  <div class="footer_social_icon">
                     <ul>
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">© 2024 All Rights Reserved By <a href="https://maventics.com/">Maventics</a></p>
         </div>
      </div>
      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="/webisteasset/js/jquery.min.js"></script>
      <script src="/webisteasset/js/popper.min.js"></script>
      <script src="/webisteasset/js/bootstrap.bundle.min.js"></script>
      <script src="/webisteasset/js/jquery-3.0.0.min.js"></script>
      <script src="/webisteasset/js/plugin.js"></script>
      <!-- sidebar -->
      <script src="/webisteasset/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="/webisteasset/js/custom.js"></script>
   </body>
</html>
