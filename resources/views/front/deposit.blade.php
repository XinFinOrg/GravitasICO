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
                @include('front.alert')
                    <span><strong>Note:</strong>Deposits to ICOToken can take upto 2 - 6 hours depending upon transaction and processing speed in public networks.</span>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel-body noPadd">
                                <ul class="nav nav-tabs profile-tabs">
                               <li class="{{admin_class('ETH')}}"><a data-toggle="tab" href="#aboutme" aria-expanded="false">ETH</a></li>
                                  <li class="{{admin_class('BTC')}}"><a data-toggle="tab" href="#btcdeposit" aria-expanded="false">BTC</a></li>
                                </ul>

                                <div class="tab-content m-0">

                                    <!-- Profile -->
                                    <div id="aboutme" class="tab-pane {{admin_class('ETH')}}">
                                        <div class="profile-desk">

                                            <h4>ETH Deposit</h4>
                                            <div id="ethaddr_mess"></div>
                                             <h4 style="font:bold">This is Ethereum-ETH Address</h4>
                                        <div class="text-center">
                            <img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={{$result->ETH_addr}}" alt="" class="mb20">
                            <h5 class="center" id="ethaddr">{{$result->ETH_addr}}</h5>
                            <button class="center btn btn-primary btn-sm" onclick="copyToClipboard('ethaddr')">Copy Address</button>

                                     </div>






                                        </div>
                                    </div>

                                    <div id="btcdeposit" class="tab-pane {{admin_class('BTC')}}">
                                        <div class="profile-desk">

                                            <h4>BTC Deposit</h4>
                                            <div id="btcaddr_mess"></div>
                                            <h4 style="font: bold">This is Bitcoin-BTC Address</h4>
                                        <div class="text-center">
                            <img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={{$result->BTC_addr}}" alt="" class="mb20">
                            <h5 class="center" id="btcaddr">{{$result->BTC_addr}}</h5>
                            <button class="center btn btn-primary btn-sm" onclick="copyToClipboard('btcaddr')">Copy Address</button>

                                     </div>
                                        </div>
                                    </div>



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



@endsection

@section('xscript')
    <script src="{{URL::asset('front')}}/assets/js/Bchaddress.js"></script>
<script>

    var toLegacyAddress = bchaddr.toLegacyAddress('{{$result->BCH_addr}}');

    document.getElementById('barcode').src = "https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl="+toLegacyAddress;

    document.getElementById('legacy_address').innerHTML = toLegacyAddress;
</script>

<script type="text/javascript">
    function copyToClipboard(elementId) {


  var aux = document.createElement("input");
  aux.setAttribute("value", document.getElementById(elementId).innerHTML);
  document.body.appendChild(aux);
  aux.select();
  document.execCommand("copy");

  document.body.removeChild(aux);

  document.getElementById(elementId+'_mess').innerHTML = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Address Copied</div>';

}
</script>

@endsection
