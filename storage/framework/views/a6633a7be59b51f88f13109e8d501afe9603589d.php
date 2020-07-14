<?php $__env->startSection('content'); ?>
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
                        <?php if($document_status != 1): ?>
                            <div class="notepsc">
                                <p><strong>Note:</strong></p>
                                <p>You have successfully completed your KYC request. We will protect your personal information. </p>
                                <p> KYC Verification process takes 3-4 days
                                <p> Our Customer support will contact you once your document is verified </p>
                            </div>
                        <?php else: ?>
                            <div class="notepsc">

                                <p>Your KYC Is been Completed. We will protect your personal information.</p>
                            </div>
                        <?php endif; ?>

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




<?php $__env->stopSection(); ?>
<?php $__env->startSection('xscript'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    
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
                    country_id: { required: true},
                    f_side: {required: true,filesize:3145728},
                    b_side: {required: true,filesize:3145728},
                    h_side: {required: true,filesize:3145728},
                },
            messages:
                {
                    first_name: { required: 'First Name  is required',minlength:'First name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                    last_name: { required: 'Last Name  is required',minlength:'Last name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                    country_id: { required: 'Country  is required'},
                    f_side: { required: 'Front Side  is required',filesize:"Maximum size is 3mb"},
                    b_side: { required: 'Back Side  is required',filesize:"Maximum size is 3mb"},
                    h_side: { required: 'Selfie with ID is required',filesize:"Maximum size is 3mb"},

                }
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>