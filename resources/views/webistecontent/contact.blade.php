@extends('webistecontent.layout')
@section('title', 'Contact')
@section('content')
    <!-- contact section start -->
    <div class="contact_section layout_padding">
        <div class="container">
           <div class="row">
              <div class="col-md-12">
                 <h1 class="contact_taital">REQUEST A CALL BACK</h1>
              </div>
           </div>
           <div class="contact_section_2">
              <div class="row">
                 <div class="col-md-8">
                    <div class="mail_section map_form_container">
                       <form action="">
                          <div class="row">
                             <div class="col-md-6">
                                <input type="text" class="mail_text" placeholder="Your Name" name="Your Name">
                             </div>
                             <div class="col-md-6">
                                <input type="text" class="mail_text" placeholder="Email" name="Email">
                             </div>
                             <div class="col-md-6">
                                <input type="text" class="mail_text" placeholder="Phone Number" name="Phone Number">
                             </div>
                             <div class="col-md-6">
                                <input type="text" class="mail_text" placeholder="Subject" name="Subject">
                             </div>
                          </div>
                          <textarea class="massage-bt" placeholder="Message" rows="5" id="comment" name="Message"></textarea>
                          <div class="btn_main">
                             <div class="send_bt active"><a href="#">Send</a></div>
                          </div>
                       </form>
                    </div>
                 </div>
                 <div class="col-md-4">
                    <div class="contact_img"><img src="/webisteasset/images/coin-img.png"></div>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <!-- contact section end -->

     @endsection
