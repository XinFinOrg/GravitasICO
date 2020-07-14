@extends('front.layout.front')
@section('content')

    <!-- Profile, Edit Profile & Change Password -->
    <section class="mt60" style="min-height:740px;">
        <div class="container">
            <div class="row">

                <!-- left navigation -->
            @include('front.sidebar')
            <!-- / left navigation -->

                <!--  right panel - profile, edit profile & change password data -->
                <div class="col-md-9">
                    <span><strong>Note:</strong> Withdrawal request  are being processed manually. Kindly expect a delay of 1-2 working days for its processing. Appreciate your patience.<br></span>

                    <br>
                    @include('front.alert')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel-body noPadd">
                                @include('front.transfer_head')

                                <div class="tab-content m-0">


                                    <!-- Change Password -->
                                    <div id="projects" class="tab-pane active">
                                        <div class="user-profile-content">

                                            <form id="fund_transfer" action="{{url('/transferverify/'.$currency)}}" onsubmit="return minAmount('{{$currency}}')" method="post" role="form">
                                                {{csrf_field()}}
                                                <input type="hidden" name="key" value="{{$urlcurrency}}">
                                                <div class="form-group">
                                                    <input title="Your {{$currency}} Address" type="text" class="form-control input-lg" value="{{get_user_details($userid,$currency.'_addr')}}" disabled="disabled">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-lg" id="to_addr" name="to_addr" placeholder="To {{$currency}} Address" value="{{old('to_addr')}}">
                                                </div>
                                                <div class="form-group">
                                                    <input title="Your current {{$currency}} Balance." type="text" class="form-control input-lg" value="{{get_userbalance($userid,$currency)}}  {{$currency}}" disabled="disabled">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-lg" name="to_amount" id="to_amount" placeholder="Transfer Amount" value="{{old('to_amount')}}">
                                                    <label id="error_val" style="display: none; color: red">*Minimum Withdraw limit: 5000</label>
                                                </div>

                                            <!--
                                                 <div class="form-group input-group">
                                                    <input type="text" class="form-control input-lg" name="fee_amount" id="fee_amount" title="Fee" value="{{get_fee_settings('withdraw_fee_eth')}}" readonly="readonly">
                                                     <span class="input-group-addon">%</span>
                                                </div> -->

                                                <div class="form-group">
                                                    <input type="text" class="form-control input-lg" name="total_amount" id="total_amount" value="{{old('total_amount')}}" readonly="readonly" title="Final Transfer Amount">
                                                </div>

                                                <div class="form-group input-group">
                                                    <input type="text" class="form-control input-lg" name="otp_code" id="otp_code" placeholder="OTP" >
                                                    <span class="input-group-addon" id="gen_otp">
                                                     <a href="#" onclick="genotp('{{$currency}}');" class="btn btn-info btn-sm">Generate OTP</a>
                                                     </span>
                                                </div>
                                                <label id="otp_code-error" class="error" for="otp_code"></label>

                                                <div id="alert_mess" class="text-center"></div>

                                                @if($currency == 'XDCE')
                                                    <span><strong>Note: Currently XDCE  is compatible with MyEtherWallet and MetaMask. ICOToken is not responsible if you are transferring XDCE to anyother wallet.</strong> </span><br><br>
                                                @endif
                                                <button class="btn btn-primary" type="submit">Send</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- / Change Password -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / right panel - profile, edit profile & change password data -->
            </div>
        </div>
    </section>
    <!-- / Profile, Edit Profile & Change Password -->

    <!-- Modal -->
    <!-- Modal -->
    <div id="withdraw_bal" class="modal danger fade"  role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id ="header"><strong>Confirm Withdrawal</strong></h4>
                </div>
                <div class="modal-body">
                    <form id="withdrawal" method="post" action="{{url('//update_user_balance')}}">
                        <div class="row">
                            <input type="hidden" class="form-control" name="user_id" id="user_id">
                            <input type="hidden" class="form-control" name="user_name" id="user_name">
                            <div class="form-group col-md-6">
                                <label >Amount</label>
                                <input type="text" class="form-control" name="xdce_amount" id="xdce_amount" >
                            </div>
                            <div class="form-group col-md-6">
                                <label>Withdraw Fee</label>
                                <input type="text" class="form-control" name="withdrawal_fee" id="withdrawal_fee" >
                            </div>
                            <div class="form-group col-md-6">
                                <label>Total Amount</label>
                                <input type="text" class="form-control" name="total_amt" id="total_amt" >
                            </div>
                        </div>
                        <div class="form-group col-md-6 pull-right">

                            <button type="button" class="btn btn-blue pull-right" data-dismiss="modal" style="margin: 5px">Close</button>&nbsp;
                            <button type="submit" class="btn btn-danger pull-right" style="margin: 5px;">Submit</button>&nbsp;&nbsp;

                        </div><br><br>
                        {{csrf_field()}}
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div id="message_modal" class="modal danger fade"  role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><strong>OTP</strong></h4>
                </div>
                <div class="modal-body">
                    <p>Withdrawal OTP has been sent to your register email<br>Please check your inbox or spam folder.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('xscript')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>

    <script>

    </script>

    <script type="text/javascript">
        var amount = '';
        jQuery.validator.addMethod("minbal", function(value, element, params) {
           var curr = '{{$currency}}';
             if(value < 0.1 && curr == 'ETH')
             {
                 amount = '0.1';
                 return false;

             }
             else if(value < 5000 && curr == 'XDC')
             {
                 amount = '5000';
                 return false;
             }

             else
                 {
                     amount = '0';
                     return true;
                 }
        },
            function()
        {
            return "Minimum withdrawal amount for {{$currency}} is "+" "+amount
        });


        var valid = $("#fund_transfer").validate({
            rules:
                {
                    to_addr:{required:true,remote:{
                            url:'{{url("ajax/address_validation")}}',
                            type:'post',
                            data:{ 'curr':'{{$currency}}',},
                        }},
                    to_amount:{required:true, remote:{
                            url:'{{url("ajax/limit_balance")}}',
                            type:'post',
                            data:{ 'curr':'{{$currency}}', },
                        }, minbal:true},
                    total_amount:{
                        remote:{
                            url:'{{url("ajax/limit_balance")}}',
                            type:'post',
                            data:{ 'curr':'{{$currency}}', },
                        }

                    },
                    otp_code:{required:true,number:true,},
                    withdraw_amount:{required:true,number:true,remote:{
                            url:'{{url("ajax/withdraw_limit_balance")}}',
                            type:'post',
                            data:{ 'curr':'{{$currency}}'}
                        }}


                },
            messages:
                {
                    to_addr:{required:'To {{$currency}} Address is required', remote:'{{$currency}} address is not valid'},
                    to_amount:{required:'Transfer Amount is required',remote:'Insufficient balance'},
                    total_amount:{remote:'Insufficient balance',},
                    otp_code:{required:'OTP Code is required',number:'Enter Digit only',}
                }
        });

        $("#to_amount").keydown(function (evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 32 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 107) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
                return false;
            return true;
        });

        function minAmount(currency)
        {
            if(currency == 'XDCE')
            {
                var amount = document.getElementById('to_amount').value;
                if(amount >= 5000)
                {
                    document.getElementById('error_val').style.display= 'none';
                    if(valid.form())
                    {
                        // $('#withdraw_bal').modal('show');
                        return true;
                    }



                }
                else
                {
                    document.getElementById('error_val').style.display= 'block';
                    return false;
                }
            }
            else
            {
                return true;
            }
        }
    </script>
    <script type="text/javascript">
        $("#to_amount").bind("input",function(){
            var amt=this.value;
            var feeper='{{get_fee_settings("withdraw_fee_".strtolower($currency))}}';
            var total;
            var trans;
            total = parseFloat(amt) * (parseFloat(feeper) / 100);
            trans = parseFloat(amt) - parseFloat(total);
            $("#total_amount").val(trans);
        });
    </script>
    <script type="text/javascript">
        function genotp(currency)
        {
            document.getElementById("gen_otp").disabled = true;
            var bal = document.getElementById('to_amount').value;
            console.log(currency);
            if(bal < 5000 && currency == 'XDCE')
            {
                document.getElementById('error_val').style.display= 'block';
            }
            else
                {

                    document.getElementById('error_val').style.display= 'none';
                    $.ajax({
                        url:'{{url("ajax/generate_email_otp")}}',
                        type:'post',
                        data:'key={{time()}}&type=Withdraw Request&_token={{ csrf_token() }}',
                        success:function(data)
                        {

                            $("#gen_otp").html('<a href="#">Sent</a>');
                            $('#message_modal').modal('show');
                        }
                    });

                }

        }
    </script>
@endsection