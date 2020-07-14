@extends('front.layout.front')

@section('content')
    <div class="page-content-wrapper">

        <div class="page-content">

            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title"> Wallets </div>
                    <hr />
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table my-wallet-table">
                                    <thead>
                                    <tr>
                                        <th>Currency</th>
                                        <th>Balance</th>
                                        <th>Deposit</th>
                                        <th>Withdraw</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <tr>
                                        <td class="title"><div class="item"><img src="{{URL::asset('front')}}/assets/img/ethereum.png"> Ethereum</div></th>
                                        <td><div class="item">{{$Bal['ETH']}}</div></td>
                                        <td><div class="item deposit"><a onclick="depositmodall('ETH')"><img src="{{URL::asset('front')}}/assets/img/deposit.png"> Deposit</a></div></td>
                                        <td><div class="item withdraw"><a onclick="withdrawalmodal('ETH','{{$address['ETH']}}','{{$Bal['ETH']}}')" disabled="true"><img src="{{URL::asset('front')}}/assets/img/withdraw.png"> Withdraw</a></div></td>
                                    </tr>

                                    <tr>
                                       <td class="title"><div class="item"><img src="{{URL::asset('front')}}/assets/img/gravitas23.png">GIFT</div></th>
                                       <td><div class="item">{{$Bal['GIFT']}}</div></td>
                                       <td><div class="item deposit"><a onclick="depositmodal('GIFT')"><img src="{{URL::asset('front')}}/assets/img/deposit.png"> Deposit</a></div></td>
                                       <td><div class="item withdraw"><a onclick="withdrawalmodal('GIFT','{{$address['GIFT']}}','{{$Bal['GIFT']}}')"><img src="{{URL::asset('front')}}/assets/img/withdraw.png"> Withdraw</a></div></td>
                                   </tr>
                                   
                                   </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- /PAGE CONTENT AAA-->

        </div>
    </div>

    <div class="deposit-overlay"></div>
    <div class="deposit-block">
        <h3  class="deposit-title"><img src="{{URL::asset('front')}}/assets/img/deposit.png"><label id="deposit-header"></label>  <a class="close" href="#"><img src="{{URL::asset('front')}}/assets/img/close.png"></a></h3>
        <div class="text-center">
            <div class="download-graph">
                <img id="deposit" name ='deposit' src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=">
            </div>
        </div>
        <div class="graph-copy">
            <p id="deposit_add" name="deposit_add"></p>
            <div id="mess"></div>
            <a href="#" onclick="copyToClipboard('deposit_add')"><img src="{{URL::asset('front')}}/assets/img/copy.png"> Copy</a>

        </div>

    </div>
    <div class="withdraw-overlay"></div>

    {{--btc withdrawal--}}
    <div class="withdraw-block" id="btc_withdraw">
        <h3 class="withdraw-title"><img src="{{URL::asset('front')}}/assets/img/withdraw.png"> <label id="withdraw_name"> </label>&nbsp;Withdraw <a class="close" href="#"><img src="{{URL::asset('front')}}/assets/img/close.png"></a></h3>

        <h4>Note</h4>
        <p>Withdrawal request are being processed manually. Kindly expect a delay of 1-2 working days for its processing. Appreciate your patience.</p>
        <form id="fund_transfer" action="{{url('/transferverify')}}" method="post">
            {{csrf_field()}}
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Address" id="your_addr" name="your_addr" value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="To Address" id="to_addr" name="to_addr">
                        <label id="error_addr" style="color: red" hidden>Address is invalid.</label>
                    </div>
                </div>
                <div id="xrp_tag" class="col-sm-12" style="display: none;">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="XRP Destination Tag" id="xrp_desttag" name="xrp_desttag">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="graph-copy">
                            <p id="withdraw_balance">0 currency</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Transfer Amount" id="to_amount" name="to_amount">
                        <label id="error_withdraw_amount" style="color: red" hidden>Insufficient Balance.</label>
                        <label id="error_val" style="display: none; color: red">*Minimum Withdraw limit: 5000</label>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Total Amount" id="total_amount" name="total_amount" readonly="readonly">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="OTP" id="otp_code" name="otp_code">
                        <span class="send-otp" id="gen_otp"><a href="#" onclick="genotp();">Generate OTP</a></span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div id="countdown" style="display: none">
                        <span style="float:left"> OTP sent to your mobile number. Resend Link:&nbsp;</span>
                        <div id="minutes" style="float:left;color: red">00</div>
                        <div style="float:left">:</div>
                        <div id="seconds" style="float:left;color: red">00</div>
                    </div>
                    <div id="aftercount" style="display:none">OTP via call:&nbsp;<a href="#" onclick="otp_call()" style="color: lightblue">Click Here</a></div>
                    <div id="aftercount_msg" style="display:none">*If you do not recieve OTP within 15 minutes please contact support</div>
                </div>
                <div class="col-sm-12 otp text-right">
                    <div class="form-group">
                        <button class="btn yellow-btn min-width-btn" onclick="Submitform(event)">Withdraw</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection

@section('xscript')
<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
</script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.bar-toggle').on('click', function () {
                $('.leftbar').toggleClass('open');
            })
            // $('.deposit').on('click', function () {
            //     $('.deposit-block, .deposit-overlay').addClass('is-active');
            // })
            $('.close, .deposit-overlay').on('click', function () {
                $('.deposit-block, .deposit-overlay').removeClass('is-active');
            })
            // $('.withdraw').on('click', function () {
            //     $('.withdraw-block, .withdraw-overlay').addClass('is-active');
            // })
            $('.close, .deposit-overlay').on('click', function () {
                $('.withdraw-block, .withdraw-overlay').removeClass('is-active');
            })
        })

        $(window).scroll(function () {
            if ($(this).scrollTop()) {
                $('#toTop').fadeIn();
            } else {
                $('#toTop').fadeOut();
            }
        });

        $("#toTop").click(function () {
            $("html, body").animate({scrollTop: 0}, 1000);
        });

    </script>
    <script type="text/javascript">

        function depositmodall(value) {
            document.getElementById('deposit-header').innerHTML = value + ' Deposit';
                $.ajax({
                    url: '{{url("ajax/get_currency_address")}}',
                    method: 'post',
                    data: {'currency': value + '_addr'},
                    success: function (data) {
                        if (value != 'XRP') {
                            document.getElementById('deposit').src = 'https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=' + data;
                            document.getElementById('deposit_add').innerHTML = data;
                            
                        }
                        
                    }
                });
                $('.deposit-block, .deposit-overlay').addClass('is-active');
            
            }
        function depositmodal(value,address)
        {
         console.log(value);
            if(value === 'GIFT')
            {
                toastr.info("Deposit only available for ETH");
            }
            else
                {
                    document.getElementById('deposit-header').innerHTML = value+' Deposit';
                    document.getElementById('deposit').src = 'https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=' + address;
                    document.getElementById('deposit_add').innerHTML = address;

                    $('.deposit-block, .deposit-overlay').addClass('is-active');
                }


        }
        function copyToClipboard(id)
        {
            var aux = document.createElement("input");
            aux.setAttribute("value", document.getElementById(id).innerHTML);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");

            document.body.removeChild(aux);

            toastr.success('<div>Address Copied</div>');
        }

        function withdrawalmodal(curr,addr,bal)
        {
         console.log("ddd"+curr);
            if(curr =='ETH')
            {

                toastr.info("Withdrawal only available for GIFT");
                $('.withdraw-block, .withdraw-overlay').removeClass('is-active');
            }
            else {
                toastr.info("Withdrawal only available after ICO");
                $('.withdraw-block, .withdraw-overlay').removeClass('is-active');
                //     document.getElementById('fund_transfer').reset();
                //     var validator = $("#fund_transfer").validate();
                //     validator.resetForm();
                //     $('#countdown').hide();
                //     $('#aftercount').hide();
                //     $('#aftercount_msg').hide();
                //     document.getElementById('error_val').style.display= 'none';
                //     document.getElementById('withdraw_name').innerHTML = curr;
                //     currency = curr;
                //     $('#gen_otp').html('<a href="#" onclick="genotp();">Generate OTP</a>');
                //
                //     $('#withdraw_address').text(addr);
                //     $('#your_addr').val(addr);
                //     $('#withdraw_balance').text(parseFloat(bal).toFixed(8));
                //     if(curr=='XRP')
                //     {
                //         $('#xrp_tag').css('display','block');
                //     }
                //     else
                //     {
                //         $('#xrp_tag').css('display','none');
                //     }
                //     $('.withdraw-block, .withdraw-overlay').addClass('is-active');
                // }
            }
        }

    </script>

@endsection