<!DOCTYPE html>
<html lang="en">
@include('front.layout.header')
<body id="page-top" class="index">
@yield('css')
<!-- Navigation -->
@include('front.layout.head_barerror')
<div class="clearfix"> </div>
<!-- BEGIN CONTAINER -->
<div class="page-container">


<!-- /.navbar -->
<div class="page-content-wrapper">

<!-- latest exchanges -->
@yield('content')
<!-- / latest exchanges -->
</div>
<!-- footer -->
@include('front.layout.footer')
<!-- / footer -->
<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
@include('front.layout.footer_script')
<!--selectpicker ends-->
@yield('xscript')
</body>
</html>
