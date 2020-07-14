<!DOCTYPE html>
<html lang="en">
@include('front.layout.icotoken_header')
<body id="page-top" class="index">



<!-- Navigation -->
@include('front.layout.icotoken_head_bar')


@yield('css')
<!-- /.navbar -->

<!-- latest exchanges -->
@yield('content')
<!-- / latest exchanges -->
<!-- footer -->
@include('front.layout.icotoken_footer')
<!-- / footer -->
<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
@include('front.layout.icotoken_footer_script')
<!--selectpicker ends-->
@yield('xscript')
</body>
</html>
