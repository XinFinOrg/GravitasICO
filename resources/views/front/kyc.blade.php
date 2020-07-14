@extends('front.layout.front')
@section('content')
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN PAGE BAR -->
                <!--<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="index.html">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Dashboard</span>
        </li>
    </ul>
    <div class="page-toolbar">
        <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
            <i class="icon-calendar"></i>&nbsp;
            <span class="thin uppercase hidden-xs"></span>&nbsp;
            <i class="fa fa-angle-down"></i>
        </div>
    </div>
</div>-->
                <!-- END PAGE BAR -->
                <!-- END PAGE HEADER-->
                <!-- PAGE CONTENT AAA-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title"> KYC Verification </div>
                        <hr>
                    </div>

                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet light ">
                            <div class="notepsc">
                                <p><strong>Note:</strong></p>
                                <p>Please make sure you use your real identity to do this verification. We will protect your personal information. </p>
                                <p> You can use any one of the below metioned document for kyc verification:</p>
                                <p> 1. Passport </p>
                                <p> 2. Driver's License </p>
                                <p> 3. National ID Card </p>
                                <p> Please provide full name as shown in your passport.</p>
                            </div>
                            <div class="row">
                                <form id="kyc" method="post" action="{{url('/kyc')}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="first_name" type="text" name="first_name" value="" placeholder="First Name" class="form-control input-lg">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                <div class="form-group">
                                        <input id="last_name" type="text" name="last_name" value="" placeholder="Last Name" style="" class="form-control input-lg">
                                </div>
                                </div>

                                <div class="col-md-4">
                                        <div class="form-group radio-group">
                                            <label for="gender" class="gender-main-label"><strong>Gender:</strong></label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" class="gender-list" value="male">
                                                <span class="male-female">Male</span><span class="checkmark"></span>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" class="gender-list" value="female">
                                                <span class="male-female">Female</span>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <!-- <label><strong>Country:&nbsp; &nbsp;&nbsp; </strong></label> -->
                                            <select name="country_id" id="country_id" class="form-control input-lg" onchange="set_country()">
                                                @foreach($country as $val)
                                                    <option value="{{$val->id}}" @if($val->id==old('country_id')) selected
                                                            @endif data-id="{{strtolower($val->iso)}}">{{$val->nicename}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group-mobile">
                                        
                                            <input type="text" class="form-control input-lg mobile_code_input" placeholder="" name="isdcode" id="isdcode" value="+93"readonly="">
                                            <input type="text" class="form-control input-lg mobile_code_input" placeholder="Mobile no." name="phone_no" id="phone-no">
                                        </div>

                                    </div>

                                   <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="dob" type="text" name="dob" value="" placeholder="DOB Here" class="form-control input-lg">
                                        </div>
                                    </div> -->
                                    
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="doc_id" type="text" name="doc_id" value="" placeholder="Document ID" class="form-control input-lg">
                                        </div>
                                    </div>
                                    
                                
                                    <div class="form-group col-md-12 ">
                                    <label><strong>Identity Card Front Side:</strong></label><br>
                                    <input type="file" accept="image/*" name="f_side" id="f_side">
                                    <br>
                                    <span>Please make sure that the photo is complete and clearly visible, in JPG format.
										</span>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="cf_side" class="boxsixe" style="border:1px solid #d3d3d3;background:#ffffff;">
                                            </canvas>
                                        </div>
                                        <div class="col-md-6">
                                            <span style="padding-toptop: 250px">Example</span>
                                            <img width="350" height="250" style="border:1px solid #d3d3d3;" src="{{URL::asset('front')}}/assets/img/idcard-f.jpg">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12 ">
                                    <label><strong>Identity Card Back Side:</strong></label><br>
                                    <input type="file" accept="image/*" name="b_side" id="b_side">
                                    <br>
                                    <span>Please make sure that the photo is complete and clearly visible, in JPG format. Id card must be in the valid period</span>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="cb_side" class="boxsixe" style="border:1px solid #d3d3d3;background:#ffffff;">
                                            </canvas>
                                        </div>
                                        <div class="col-md-6">
                                            <span style="padding-toptop: 250px">Example</span>
                                            <img width="350" height="250" style="border:1px solid #d3d3d3;" src="{{URL::asset('front')}}/assets/img/idcard-b.jpg">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group col-md-12 ">
                                    <label><strong>Selfie With Photo ID And Note:</strong></label><br>
                                    <input type="file" accept="image/*" name="h_side" id="h_side">
                                    <br>
                                    <span>Please provide a photo of you holding your Identity Card front side. In the same picture, make a reference to Gravitas and today's date displayed. Make sure your face is clearly visible and that all passport details are clearly readable.</span>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="ch_side" class="boxsixe" style="border:1px solid #d3d3d3;background:#ffffff;">
                                            </canvas>
                                        </div>
                                        <div class="col-md-6">
                                            <span style="padding-toptop: 250px">Example</span>
                                            <img width="350" height="250" style="border:1px solid #d3d3d3;" src="{{URL::asset('front')}}/assets/img/idcard-h.jpg">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="submit-btn">Submit</button>
                                    <p>KYC verification would need 3 - 4 working days to be complete.</p>
                                    <br>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /PAGE CONTENT AAA-->

            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>




@endsection
@section('xscript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    {{--form validation--}}
    <script>
        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Number Not valid."
        );
        $.validator.addMethod('filesize', function (value, element, arg) {
            console.log(element.files[0].size);
            console.log(arg);
            return this.optional(element) || (element.files[0].size <= arg)
        }, 'File size must be less than {0}');

        $("#kyc").validate({
            rules:
                {
                    first_name: { required: true,minlength:2, regex:"^[A-Za-z]*$"},
                    last_name: { required: true,minlength:2, regex:"^[A-Za-z]*$"},
                    isdcode:{required:'ISD code is required'},
                    country_id: { required: true},
                    // dob: { required: true},
                    gender:{required:true},
                    doc_id: { required: true,regex:"(?!^ +$)^.+$"},
                    phone_no: {required:true, number: true,regex:"^[1-9][0-9]*$"},
                    f_side: {required: true,filesize:3145728},
                    b_side: {required: true,filesize:3145728},
                    h_side: {required: true,filesize:3145728},
                },
            messages:
                {
                    first_name: { required: 'First Name  is required',minlength:'First name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                    last_name: { required: 'Last Name  is required',minlength:'Last name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                    phone_no: { required:'Phone number is required',number: 'Digit only allowed',regex:'Number not valid should not start with zero'},
                    isdcode:{required:'ISD code is required'},
                    country_id: { required: 'Country  is required'},
                    // dob: { required: 'Date of Birth  is required'},
                    gender:{required:'Gender is required'},
                    doc_id: { required: 'Document ID  is required',regex:"Space not Allowed"},
                    f_side: { required: 'Front Side  is required',filesize:"Maximum size is 3mb"},
                    b_side: { required: 'Back Side  is required',filesize:"Maximum size is 3mb"},
                    h_side: { required: 'Selfie with ID is required',filesize:"Maximum size is 3mb"},

                }
        });
    </script>
    <script src="{{URL::asset('front')}}/assets/js/countrySelect.js"></script>
    <script type="text/javascript">


        function set_country() {
            var code = $('#country_id option:selected').attr('data-id');
            $("#country_selector").countrySelect("selectCountry", code);
            var data = {!! json_encode($country) !!};
            $.each(data, function(k,v) {
                if(v.iso == code.toUpperCase()){
                    document.getElementById("isdcode").value ='+'+ v.phonecode;
                }
            })
        }
        
    </script>


    <script>
        $("#country_id").countrySelect({
            preferredCountries: ['jp','in', 'gb', 'us']
        });
    </script>

    <script>
        $(function(){
            $("#dob").datepicker({changeMonth:true,
            changeYear:true, yearRange: "1900:+0"}
            );
        });
    </script>
    <script>
        function el(id){return document.getElementById(id);} // Get elem by ID

        var canvas1  = el("cf_side");
        var context1 = canvas1.getContext("2d");
        function readImage1() {
            if ( this.files && this.files[0] ) {
                var FR= new FileReader();
                FR.onload = function(e) {
                    var img = new Image();

                    img.addEventListener("load", function() {
                        var x = 0;
                        var y = 0;
                        var width = 350;
                        var height = 250;

                        context1.drawImage(img,x,y,width,height);
                    });
                    img.src = e.target.result;
                };
                FR.readAsDataURL( this.files[0] );
            }
        }

        el("f_side").addEventListener("change", readImage1, false);
    </script>

    <script>
        function el(id){return document.getElementById(id);} // Get elem by ID

        var canvas2  = el("cb_side");
        var context2 = canvas2.getContext("2d");
        function readImage2() {
            if ( this.files && this.files[0] ) {
                var FR= new FileReader();
                FR.onload = function(e) {
                    var img = new Image();

                    img.addEventListener("load", function() {
                        var x = 0;
                        var y = 0;
                        var width = 350;
                        var height = 250;

                        context2.drawImage(img,x,y,width,height);
                    });
                    img.src = e.target.result;
                };
                FR.readAsDataURL( this.files[0] );
            }
        }

        el("b_side").addEventListener("change", readImage2, false);
    </script>

    <script>
        function el(id){return document.getElementById(id);} // Get elem by ID

        var canvas3  = el("ch_side");
        var context3 = canvas3.getContext("2d");
        function readImage3() {
            if ( this.files && this.files[0] ) {
                var FR= new FileReader();
                FR.onload = function(e) {
                    var img = new Image();

                    img.addEventListener("load", function()
                    {
                        var x = 0;
                        var y = 0;
                        var width = 350;
                        var height = 250;
                        context3.drawImage(img,x,y,width,height);
                    });
                    img.src = e.target.result;
                };
                FR.readAsDataURL( this.files[0] );
            }
        }

        el("h_side").addEventListener("change", readImage3, false);
    </script>
    @endsection