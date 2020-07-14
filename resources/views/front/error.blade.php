@extends('front.layout.front')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class=" imgs" align="center" style="width: 450px;height: 500px;margin-top: 150px;margin-left: 300px">
                    <h1 class="">Website is Under Maintenance.</h1>
                    <img src="{{url('front')}}/assets/underconstruction.gif" align="center" width="100" height="250"
                    alt="Web Site Under Construction">

                </div>

            </div>

        </div>
    </div>
<style>
    imgs {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -(100/2)px;
        margin-top: -(250/2)px;
    }
</style>
@endsection
