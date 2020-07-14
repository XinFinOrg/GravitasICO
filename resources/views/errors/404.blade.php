{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--<title></title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<center><img src="{{URL::asset('front/assets/imgs')}}/error-404.png" /></center>--}}
{{--</body>--}}
{{--</html>--}}

@extends('front.layout.front_error')
@section('content')
<div class="clearfix"></div>
<div class="main-flex">
	<div class="main-content inner_content">
		<div class="container-fluid"><br>
			<div class="row">
				<br>
				<div class="col-md-12">
					<div class="panel panel-default panel-heading-space text-center error-main" style="background-color: #273747;">
						<br><p> </p>
						<div class="oops-image">
							<img src="{{URL::asset('front')}}/assets/img/oops-icon.png" alt="oops" />
						</div><br>
						<h1 style="color: #FFF;">Oops!</h1>
						<p style="color: #FFF;font-size:25px;!important">Something went wrong and we couldn't process your request.</p>
						<p style="color: #FFF;font-size:25px;!important">Please go back to the previous page and try again.</p><br>
						<button type="button" class="btn yellow-btn min-width-btn go-back" onclick= "window.location.href = '{{url('/login')}}'">Go Back</button>
						<br><p></p><br>
					</div>
					<br>
				</div>
				<br>
			</div>
			
		</div>
	</div>
	<div class="clearfix"></div>
</div>
@endsection

