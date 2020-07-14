
@extends('front.layout.front')
@section('css')
    <link rel="stylesheet" href="{{URL::asset('front')}}/build/css/countrySelect.css">
    <link rel="stylesheet" href="{{URL::asset('front')}}/build/css/demo.css">
@endsection
@section('content')

    <!-- / contact form -->
    <section class="mt60" style="min-height:740px;">
        <div class="container">
            <div class="row">
                    <h3>Support</h3>
                    <div class="">
                        <!--  <div class="loader"></div>
                         <div class="bar"></div> -->
                        @include('front.alert')
                        <div class="row mt30">

                            <form id="contactForm" action="{{url('contact_us')}}" class="contactForm contactusForm" name="cform2" method="post">
                                {{csrf_field()}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name:</label>
                                        <input id="enquiry_name" type="text" name="enquiry_name" value="{{old('enquiry_name')}}" placeholder="Your Name" class="form-control input-lg" />

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input id="enquiry_email" type="email" name="enquiry_email" value="{{old('enquiry_email')}}" placeholder="Email address" class="form-control input-lg" />


                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mobile Number:</label>
                                        <input id="telephone" type="text" name="telephone" value="{{old('telephone')}}" placeholder="Enter Mobile Number" class="form-control input-lg" />
                                    </div>
                                    <p id="number_example" style="font-size: small;display: block">Enter your number with Countrycode<br> Example(015999999999)</p>
                                    <p id="registerdisplay" style="display:none">Please click on Register Button Below</p>

                                    <label id="phone_no-error" class="error" for="phone_no"></label>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>User Type:</label>
                                        <select id="user_type" type="text"onchange="" name="user_type"   class="form-control input-lg">
                                            <option value="user" rel="user" selected>Existing User</option>
                                            <option value="guest" rel="guest">New User</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Subject:</label>
                                        <select id="subject_type" type="text" name="subject_type"   class="form-control input-lg">

                                            {{-- <option value="Otp" class="user" rel="else">OTP Issue</option> --}}
                                            <option value="Deposit"  class="user" rel="sub_crypto">Crypto Deposit</option>
                                            <option value="Others" class="guest" rel="else">Others</option>
                                            <option value="Others" class="user" rel="else">Others</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4" id ="currency_div">
                                    <div class="form-group">
                                        <label>Currency:</label>
                                        <select id="currency" type="text" name="currency"   class="form-control input-lg">

                                            <option value="BTC" class="sub_crypto" rel="user">BTC</option>
                                            <option value="ETH" class="sub_crypto" rel="user">ETH</option>

                                        </select>
                                    </div>
                                </div>

                                <div id ='trans_div'>
                                    <div class="col-md-3" id ="trans_div">
                                        <div class="form-group">
                                            <label>From:(optional)</label>
                                            <input id="from" type="text" name="from" placeholder="From address" class="form-control input-lg" />

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>To:(optional)</label>
                                            <input  id="to" type="text" name="to"  placeholder="To address" class="form-control input-lg" />

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Transaction Id: (optional)</label>
                                            <input id="transaction" type="text" name="transaction"  placeholder="Enter transaction id" class="form-control input-lg" />

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Amount: (optional)</label>
                                            <input id="amount" type="text" name="amount"  placeholder="Enter amount transferred" class="form-control input-lg" />

                                        </div>
                                    </div>
                                </div>




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <textarea name="enquiry_message" id="enquiry_message" placeholder="Your message..." style="min-height:147px;" class="form-control input-lg">{{old('enquiry_message')}}</textarea>

                                    </div>

                                    <div class="form-group">

                                        <input type="text" name="captcha" id="captcha" placeholder="Enter the code" class="form-control input-lg" />

                                        <p class="contact_us_captcha" id="capimg">{!! captcha_img() !!}</p>
                                        <a class="m_tl" href="javascript:;" onclick="change_captcha()"><i class="fa fa-refresh fa-3x"></i></a>

                                        <div class="clear"></div>


                                    </div>
                                </div>

                                <div class="col-md-12 mt30">
                                    <button type="submit" id="contact_submit" class="btn btn-primary pull-left" name="ec_register"><i class="fa fa-paper-plane"></i> &nbsp; Send</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- / contact form -->

@endsection

@section('xscript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    validate
    <script type="text/javascript">
        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Number Not valid."
        );
        $("#contactForm").validate({
            rules:
                {
                    enquiry_name:{required:true,minlength:2, regex:"^[A-Za-z]*$"},
                    enquiry_email:{required:true,email:true},
                    enquiry_subject:{required:true,lettersonlys:true,},
                    telephone:{required:true,number:true},
                    enquiry_message:{required:true,alphanumer:true,regex:"^[A-Za-z]*$"},
                    captcha:{required:true},

                },
            messages:
                {
                    enquiry_name:{required:'Name is required',minlength:'Name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                    enquiry_email:{required:'Email is required',email:'Enter valid email',},
                    enquiry_subject:{required:'Subject is required',},
                    telephone:{required:'Mobile number is required',number:'Enter valid number',minlength:'Please enter 10 digit number'},
                    enquiry_message:{required:'Message content is required',regex:'Only alphabets allowed'},
                    captcha:{required:'Captcha is required'},
                }
        });


        $("#telephone").keydown(function (evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 32 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 107) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
                return false;
            return true;
        });
        jQuery.validator.addMethod("alphanumer", function(value, element) {
            return this.optional(element) || /^([a-zA-Z0-9 _-]+)$/.test(value);
        }, 'Does not allow any grammatical connotation, like " : ./');

        jQuery.validator.addMethod("lettersonlys", function(value, element) {
            return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
        }, "Letters only please");

    </script>

    <script type="text/javascript">
        function change_captcha()
        {
            $("#capimg").html('Loading....');
            $.post('{{url("ajax/refresh_capcha")}}',function(data,result)
            {
                $("#capimg").html(data);
            });
        }


    </script>

    ready function
    <script>
        $(document).ready(function(){
            var $user_type = $('select[name=user_type]'),
                $subject_type = $('select[name=subject_type]'),
                $currency = $('select[name=currency]');
            var e = document.getElementById("subject_type");

            var strUser = e.options[e.selectedIndex].value;
            if(strUser == 'Otp')

            {
                document.getElementById('trans_div').style.display = 'none';
                document.getElementById('currency_div').style.display = 'none';
            }
            console.log(strUser);
            //user type change
            $user_type.change(function(){
                var $this = $(this).find(':selected'),
                    value = $this.attr('value'),

                    rel = $this.attr('rel'),
                    $set = $subject_type.find('option.' + rel);




                if ($set.size() < 0) {

                    $subject_type.hide();
                    return;
                }
                if(value == 'guest')
                {
                    document.getElementById('trans_div').style.display = 'none';
                    document.getElementById('currency_div').style.display = 'none';
                }
                else
                {
                    document.getElementById('trans_div').style.display = 'block';
                    document.getElementById('currency_div').style.display = 'block';
                }




                $subject_type.show().find('option').hide();

                $set.show().first().prop('selected', true);
            });

            //subject type change
            $subject_type.change(function(){
                var $this = $(this).find(':selected'),
                    rel = $this.attr('rel'),
                    $set = $currency.find('option.' + rel);

                if (rel == 'else') {

                    document.getElementById('trans_div').style.display = 'none';
                    document.getElementById('currency_div').style.display = 'none';
                    $currency.hide();
                    return;
                }
                else
                {
                    document.getElementById('trans_div').style.display = 'block';
                    document.getElementById('currency_div').style.display = 'block';
                }

                $currency.show().find('option').hide();

                $set.show().first().prop('selected', true);
            });

            onloadSelect();

        });

        function set_country() {
            var code = $('#country_id option:selected').attr('data-id');
            $("#country_selector").countrySelect("selectCountry", code);
        }

        function onloadSelect()
        {

            var $user_type = $('select[name=user_type]'),
                $subject_type = $('select[name=subject_type]'),
                $currency = $('select[name=currency]');

           var  $user_selected = $user_type.find(':selected');

           var user = $user_selected.attr('rel');
            $set = $subject_type.find('option.' + user);

            $subject_type.show().find('option').hide();

            $set.show().first().prop('selected', true);

            var $sub_selected = $subject_type.find(':selected');

            var subject = $sub_selected.attr('rel');
            $set = $currency.find('option.'+subject);
            $currency.show().find('option').hide();
            $set.show().first().prop('selected', true);
        }


    </script>

    <script src="{{URL::asset('front')}}/build/js/countrySelect.js"></script>
    <script>

        $("#country_selector").countrySelect({
                       preferredCountries: ['jp','in', 'gb', 'us']
        });

        function set_country() {
            var code = $('#country_id option:selected').attr('data-id');
            $("#country_selector").countrySelect("selectCountry", code);
        }

    </script>




@endsection
