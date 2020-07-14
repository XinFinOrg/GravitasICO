<title>{{get_meta_title()}}</title>
<link rel="stylesheet" href="{{URL::asset('front')}}/assets/css/vendor.bundle.css">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="shortcut icon" href="{{URL::asset('front')}}/assets/images/fav.png">
    <title>{{get_meta_title()}}</title>
    <link rel="stylesheet" href="{{URL::asset('front')}}/assets/css/vendor.bundle.css">
    <link rel="stylesheet" href="{{URL::asset('front')}}/assets/css/styles3.css">
    <link rel="stylesheet" href="{{URL::asset('front')}}/assets/css/jjc.css">
    <link rel="stylesheet" href="{{URL::asset('front')}}/assets/css/theme-java.css" id="layoutstyle">
    <link rel="stylesheet" href="{{URL::asset('front')}}/assets/css/slider.css" id="layoutstyle">
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
    <script src="{{URL::asset('front')}}/assets/js/jiocharts.js"></script>
    <link rel="stylesheet" href="{{URL::asset('front')}}/assets/css/toastr-2.1.3.css">
    <style type="text/css">
        .error {
            color: #a94442;


        }
    </style>
    {{--<style type="text/css">--}}

        {{--.top-bg {--}}
            {{--background: url({{asset('images/main-bgr.png')}}) no-repeat;--}}
            {{--background-size: cover;--}}
            {{--min-height: 100vh;--}}
        {{--}--}}
        {{--.countdown-box {--}}
            {{--background: #efd10b;--}}
        {{--}--}}
        {{--.dif1{color:#000;}--}}
        {{--.countdown-box .token-countdown .countdown-text {color: #000;}--}}
        {{--.countdown-box .token-countdown .countdown-time {color: #000;}--}}
        {{--.countdown-box .token-countdown .countdown-time:after {color:#000;}--}}

        {{--.site-header .navbar.is-transparent {--}}
            {{--background: #000;--}}
        {{--}--}}

        {{--.align-items-center{padding:80px 0 0px 0;}--}}

        {{--.m_tl {--}}
            {{--margin: 2px 0px 0px 20px;--}}
            {{--display: inline-block;--}}
            {{--vertical-align: top;--}}
        {{--}--}}
        {{--.fa-3x {--}}
            {{--font-size: 2.5em;--}}
        {{--}--}}

        {{--.login-container1{--}}
            {{--background:#f0d20b;--}}
        {{--}--}}

        {{--.login-container2{--}}
            {{--width: 100%;--}}
            {{--background: url({{asset('images/parallax-bg1.jpg')}});--}}
            {{--background-attachment: fixed;--}}
            {{--background-origin: initial;--}}
            {{--background-clip: initial;--}}
            {{--background-size: cover;--}}
            {{--background-repeat: no-repeat;--}}
            {{--background-position: 100% 0;--}}
            {{--background-position: center;--}}
            {{--z-index: 1;--}}
            {{--min-height: 70vh;--}}
        {{--}--}}




        {{--.login-container{--}}
            {{--/*background: url('images/login_back.jpg') no-repeat ;--}}
            {{--min-height: 80vh;--}}
            {{--max-width: 1400px;*/--}}
            {{--background:#f5f5f5;--}}
        {{--}--}}
        {{--.boxsixe{width:350px; height:250px;}--}}

        {{--.login-wpr{--}}
            {{--background: #353535;--}}
            {{--border-top: 5px solid #f0d20b;--}}
            {{--padding: 15px 25px 10px 25px;--}}
            {{--width: 100%;--}}
            {{--border-radius: 10px;--}}
            {{--box-shadow: 8px 8px 4px #9a9a9a61;--}}
        {{--}--}}

        {{--.login-top{--}}
            {{--text-align: center;--}}
        {{--}--}}

        {{--.login-top img{--}}
            {{--display: block;--}}
            {{--margin: 0 auto;--}}
            {{--padding:0 0 5px 0;--}}
            {{--width: 160px;--}}
        {{--}--}}

        {{--.login-form{--}}
            {{--font-size: 13px;--}}
            {{--margin:20px auto;--}}
        {{--}--}}

        {{--.username, .password{--}}
            {{--border: 1px solid #dedede;--}}
            {{--border-radius:16px;--}}
            {{--display: block;--}}
            {{--height: 36px;--}}
            {{--margin-bottom: 15px;--}}
            {{--padding: 5px 15px;--}}
            {{--width: 100%;--}}
            {{--outline: none;--}}
        {{--}--}}

        {{--.forgot, .not-member{--}}
            {{--color: #fff;--}}
            {{--display: block;--}}
            {{--font-size:13px;--}}
            {{--margin:0 0 8px 8px;--}}
        {{--}--}}

        {{--.not-member{--}}
            {{--padding:0 0 0px 0;--}}
        {{--}--}}

        {{--.forgot:hover, .forgot:focus{--}}
            {{--color: #f0d20b;--}}
        {{--}--}}

        {{--.copy-right{--}}
            {{--border-top: 1px solid #2f2f2f;--}}
            {{--color: #fff;--}}
            {{--margin:10px 0 0 0;--}}
            {{--padding: 20px 0  0 0;--}}
            {{--text-align: center;--}}
        {{--}--}}

        {{--.underxxt{}--}}
        {{--.underxxt h2{font-weight: normal;    margin: 0 0 10px 0;    font-size: 40px;    letter-spacing: -1px;}--}}
        {{--.underxxt p{color: #333 !important;    text-align: left !important;    font-size: 18px;    line-height: 25px;}--}}

        {{--.underxxt1{margin-bottom:70px; width: 680px; margin:0 auto; padding-bottom:100px;}--}}
        {{--.underxxt1 h3 {font-size: 20px; text-align: center; color: #fff; font-weight: normal;}--}}
        {{--.clor{color: #333; font-weight:500 !important;}--}}
        {{--.form-control1{margin-bottom:20px;}--}}

        {{--.submit-btn {--}}
            {{--border-radius: 20px;--}}
            {{--border: none;--}}
            {{--color: #353535;--}}
            {{--cursor: pointer;--}}
            {{--text-decoration: none;--}}
            {{--padding: 6px 40px;--}}
            {{--display: block;--}}
            {{--margin: 10px 0;--}}
            {{--max-width: 200px;--}}
            {{--text-align: center;--}}
            {{--text-transform: uppercase;--}}
            {{--font-weight: 600;--}}
            {{--background: linear-gradient(319deg, #a36d2a, #f1d20b, #986025);--}}
            {{--background-size: 400% 400%;--}}
            {{---webkit-animation: AnimationButton 3s ease infinite;--}}
            {{---moz-animation: AnimationButton 3s ease infinite;--}}
            {{--animation: AnimationButton 3s ease infinite;--}}
        {{--}--}}

        {{--.submit-btn:hover{--}}
            {{--cursor:pointer;--}}
        {{--}--}}

        {{--@-webkit-keyframes AnimationButton {--}}
            {{--0%{background-position:49% 0%}--}}
            {{--50%{background-position:52% 100%}--}}
            {{--100%{background-position:49% 0%}--}}
        {{--}--}}
        {{--@-moz-keyframes AnimationButton {--}}
            {{--0%{background-position:49% 0%}--}}
            {{--50%{background-position:52% 100%}--}}
            {{--100%{background-position:49% 0%}--}}
        {{--}--}}
        {{--@keyframes AnimationButton {--}}
            {{--0%{background-position:49% 0%}--}}
            {{--50%{background-position:52% 100%}--}}
            {{--100%{background-position:49% 0%}--}}
        {{--}--}}
        {{--.lg-wpr{--}}
            {{--padding :50px 0 50px 0;--}}
        {{--}--}}

        {{--.lg-wpr1{--}}
            {{--padding :50px 0 50px 0;--}}
        {{--}--}}

        {{--.reg-heading{--}}
            {{--color: #fff;--}}
            {{--font-size: 24px;--}}
            {{--margin-bottom: 5px;--}}
        {{--}--}}

        {{--.reg-sub-heading{--}}
            {{--color:#fff;--}}
            {{--font-size: 14px;--}}
        {{--}--}}

        {{--.text-white{--}}
            {{--color: #fff;--}}
        {{--}--}}

        {{--.mr-bt-20{--}}
            {{--margin-bottom: 20px;--}}
        {{--}--}}

        {{--#forgot-modal{--}}
            {{--top: 10% ;--}}
        {{--}--}}

        {{--body::-webkit-scrollbar {--}}
            {{--width: 0.4em;--}}
        {{--}--}}

        {{--body::-webkit-scrollbar-track {--}}
            {{---webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);--}}
        {{--}--}}

        {{--body::-webkit-scrollbar-thumb {--}}
            {{--background-color: #353535;--}}
            {{--outline: 1px solid slategrey;--}}
        {{--}--}}

        {{--.fr-heading{--}}
            {{--font-size: 20px;--}}
        {{--}--}}

        {{--#forgot-modal .modal-header{--}}
            {{--background: #f0d20b;--}}
            {{--padding:10px 25px;--}}
        {{--}--}}

        {{--.earth-img{--}}
            {{--position: relative;--}}
        {{--}--}}

        {{--.earth-img img  {--}}
            {{--display: block;--}}
            {{--width: 450px ;--}}
            {{--margin:0 auto;--}}
        {{--}--}}

        {{--#loading{--}}
            {{---webkit-animation: rotation 10s infinite linear;--}}
        {{--}--}}

        {{--@-webkit-keyframes rotation {--}}
            {{--from {--}}
                {{---webkit-transform: rotate(0deg);--}}
            {{--}--}}
            {{--to {--}}
                {{---webkit-transform: rotate(359deg);--}}
            {{--}--}}
        {{--}--}}

        {{--.jio-img{--}}
            {{--position: absolute;--}}
            {{--top: 12%;--}}
            {{--left: 50%;--}}
            {{--margin-left: -115px;--}}
        {{--}--}}

        {{--.jio-img img{--}}
            {{--display: block;--}}
            {{--width: 230px;--}}
            {{--margin: 0 auto;--}}
        {{--}--}}

        {{--.mr-tp-30{--}}
            {{--margin-top: 50px;--}}
        {{--}--}}

        {{--@media screen and (max-width:992px){--}}
            {{--.mbool{display:none;}--}}
            {{--.login-wpr, .login-form{--}}
                {{--width: 100%;--}}
            {{--}--}}

            {{--.mr-tp-30{--}}
                {{--margin-top: 10px;--}}
            {{--}--}}

            {{--.jio-img{--}}
                {{--top: 4%;--}}
            {{--}--}}


        {{--}--}}


        {{--.margn {width:50%; float:left; text-align: center;}--}}
        {{--.margn1 {width:50%; float:right; text-align: center;}--}}

        {{--@media screen and (width:414px){--}}
            {{--.align-items-center {padding:50px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:411px){--}}
            {{--.align-items-center {padding:50px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:375px){--}}
            {{--.align-items-center {padding:50px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:360px){--}}
            {{--.align-items-center {padding:50px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:320px){--}}
            {{--.align-items-center {padding:50px 0 0px 0 !important;}--}}
        {{--}--}}


        {{--@media screen and (max-width:767px){--}}
            {{--.clor {font-weight: 600 !important; font-size: 30px !important;}--}}
            {{--.lg-wpr1 {padding:30px 0 30px 0;}--}}

            {{--.bg-opacity-9{min-height: inherit;}--}}
            {{--.login-container2{min-height: inherit;}--}}
            {{--.margn {width: 50%;}--}}
            {{--.underxxt1 {padding-bottom: 50px;   padding-left: 15px;  padding-right: 15px; width:auto;}--}}
            {{--.underxxt1 h3 {font-size: 18px;}--}}

            {{--.lg-wpr {padding: 30px 0 50px 0;}--}}
            {{--.top-bg {background-size: contain;     min-height: inherit;}--}}
            {{--.login-container{--}}
                {{--padding-right: 15px;--}}
            {{--}--}}

            {{--.login-wpr{--}}
                {{--margin-top:40px;--}}
                {{--width:100%;--}}
            {{--}--}}

            {{--.login-form{--}}
                {{--margin:0 auto;--}}
                {{--width:calc(100% - 2%);--}}
            {{--}--}}

            {{--.login-top img{--}}
                {{--margin-bottom: 15px;--}}
            {{--}--}}

            {{--.copy-right {--}}
                {{--padding: 10px 0 0 0;--}}
            {{--}--}}

            {{--.reg-sub-heading{--}}
                {{--padding-bottom: 20px;--}}
            {{--}--}}

            {{--.jio-img img{--}}
                {{--display: block;--}}
                {{--width: 180px;--}}
                {{--margin: 0 auto;--}}
            {{--}--}}

            {{--.jio-img{--}}
                {{--left: 58%;--}}
                {{--top: 12%;--}}
            {{--}--}}
        {{--}--}}


        {{--@media screen and (max-width:768px){--}}
            {{--.top-bg {--}}
                {{--background: url({{asset('images/main-bgr.png')}}) no-repeat;--}}
                {{--background-size: contain;--}}
                {{--min-height: auto;--}}
            {{--}--}}
            {{--.login-container2{min-height:auto;}--}}
            {{--.align-items-center {--}}
                {{--padding:100px 0 20px 0;--}}
            {{--}--}}
        {{--}--}}



    {{--</style>--}}
    {{--<style type="text/css">--}}

        {{--.top-bg {--}}
            {{--background: url(images/main-bgr.png) no-repeat;--}}
            {{--background-size: cover;--}}
            {{--min-height: 100vh;--}}
        {{--}--}}
        {{--.countdown-box {--}}
            {{--background: #efd10b;--}}
        {{--}--}}

        {{--.col-sm-12.col-xs-12 span {--}}
            {{--color: #fff;--}}
        {{--}--}}


        {{--.site-header .navbar.is-transparent {--}}
            {{--background: #000;--}}
        {{--}--}}

        {{--.align-items-center{padding:80px 0 0px 0;}--}}

        {{--.m_tl {--}}
            {{--margin: 10px 0px 0px 20px;--}}
            {{--display: inline-block;--}}
            {{--vertical-align: top;--}}
        {{--}--}}


        {{--.login-container1{--}}
            {{--background:#f0d20b;--}}
        {{--}--}}

        {{--.login-container2{--}}
            {{--width: 100%;--}}
            {{--background: url(images/parallax-bg1.jpg);--}}
            {{--background-attachment: fixed;--}}
            {{--background-origin: initial;--}}
            {{--background-clip: initial;--}}
            {{--background-size: cover;--}}
            {{--background-repeat: no-repeat;--}}
            {{--background-position: 100% 0;--}}
            {{--background-position: center;--}}
            {{--z-index: 1;--}}
            {{--min-height: 70vh;--}}
        {{--}--}}




        {{--.login-container{--}}
            {{--/*background: url('images/login_back.jpg') no-repeat ;--}}
            {{--min-height: 80vh;--}}
            {{--max-width: 1400px;*/--}}
            {{--background:#f5f5f5;--}}
        {{--}--}}

        {{--.login-wpr{--}}
            {{--background: #353535;--}}
            {{--border-top: 5px solid #f0d20b;--}}
            {{--padding: 15px 25px 10px 25px;--}}
            {{--width: 100%;--}}
            {{--border-radius: 10px;--}}
            {{--box-shadow: 8px 8px 4px #9a9a9a61;--}}
        {{--}--}}

        {{--.login-top{--}}
            {{--text-align: center;--}}
        {{--}--}}

        {{--.login-top img{--}}
            {{--display: block;--}}
            {{--margin: 0 auto;--}}
            {{--padding:0 0 5px 0;--}}
            {{--width: 160px;--}}
        {{--}--}}

        {{--.login-form{--}}
            {{--font-size: 13px;--}}
            {{--margin:20px auto;--}}
        {{--}--}}

        {{--.username, .password{--}}
            {{--border: 1px solid #dedede;--}}
            {{--border-radius:16px;--}}
            {{--display: block;--}}
            {{--height: 36px;--}}
            {{--margin-bottom: 15px;--}}
            {{--padding: 5px 15px;--}}
            {{--width: 100%;--}}
            {{--outline: none;--}}
        {{--}--}}

        {{--.forgot, .not-member{--}}
            {{--color: #fff;--}}
            {{--display: block;--}}
            {{--font-size:13px;--}}
            {{--margin:0 0 8px 8px;--}}
        {{--}--}}

        {{--.not-member{--}}
            {{--padding:0 0 0px 0;--}}
        {{--}--}}

        {{--.forgot:hover, .forgot:focus{--}}
            {{--color: #f0d20b;--}}
        {{--}--}}

        {{--.copy-right{--}}
            {{--border-top: 1px solid #2f2f2f;--}}
            {{--color: #fff;--}}
            {{--margin:10px 0 0 0;--}}
            {{--padding: 20px 0  0 0;--}}
            {{--text-align: center;--}}
        {{--}--}}

        {{--.underxxt{}--}}
        {{--.underxxt h2{font-weight: normal;    margin: 0 0 10px 0;    font-size: 40px;    letter-spacing: -1px;}--}}
        {{--.underxxt p{color: #333 !important;    text-align: left !important;    font-size: 18px;    line-height: 25px;}--}}

        {{--.underxxt1{margin-bottom:70px; width: 680px; margin:0 auto; padding-bottom:100px;}--}}
        {{--.underxxt1 h3 {font-size: 20px; text-align: center; color: #fff; font-weight: normal;}--}}
        {{--.clor{color: #333; font-weight:500 !important;}--}}
        {{--.form-control1{margin-bottom:20px;}--}}

        {{--.submit-btn {--}}
            {{--border-radius: 20px;--}}
            {{--border: none;--}}
            {{--color: #353535;--}}
            {{--cursor: pointer;--}}
            {{--text-decoration: none;--}}
            {{--padding: 6px 40px;--}}
            {{--display: block;--}}
            {{--margin: 10px 0;--}}
            {{--max-width: 200px;--}}
            {{--text-align: center;--}}
            {{--text-transform: uppercase;--}}
            {{--font-weight: 600;--}}
            {{--background: linear-gradient(319deg, #a36d2a, #f1d20b, #986025);--}}
            {{--background-size: 400% 400%;--}}
            {{---webkit-animation: AnimationButton 3s ease infinite;--}}
            {{---moz-animation: AnimationButton 3s ease infinite;--}}
            {{--animation: AnimationButton 3s ease infinite;--}}
        {{--}--}}

        {{--.submit-btn:hover{--}}
            {{--cursor:pointer;--}}
        {{--}--}}

        {{--@-webkit-keyframes AnimationButton {--}}
            {{--0%{background-position:49% 0%}--}}
            {{--50%{background-position:52% 100%}--}}
            {{--100%{background-position:49% 0%}--}}
        {{--}--}}
        {{--@-moz-keyframes AnimationButton {--}}
            {{--0%{background-position:49% 0%}--}}
            {{--50%{background-position:52% 100%}--}}
            {{--100%{background-position:49% 0%}--}}
        {{--}--}}
        {{--@keyframes AnimationButton {--}}
            {{--0%{background-position:49% 0%}--}}
            {{--50%{background-position:52% 100%}--}}
            {{--100%{background-position:49% 0%}--}}
        {{--}--}}
        {{--.lg-wpr{--}}
            {{--padding :50px 0 50px 0;--}}
        {{--}--}}

        {{--.lg-wpr1{--}}
            {{--padding :50px 0 50px 0;--}}
        {{--}--}}

        {{--.reg-heading{--}}
            {{--color: #fff;--}}
            {{--font-size: 24px;--}}
            {{--margin-bottom: 5px;--}}
        {{--}--}}

        {{--.reg-sub-heading{--}}
            {{--color:#fff;--}}
            {{--font-size: 14px;--}}
        {{--}--}}

        {{--.text-white{--}}
            {{--color: #fff;--}}
        {{--}--}}

        {{--.mr-bt-20{--}}
            {{--margin-bottom: 20px;--}}
        {{--}--}}

        {{--#forgot-modal{--}}
            {{--top: 10% ;--}}
        {{--}--}}

        {{--body::-webkit-scrollbar {--}}
            {{--width: 0.4em;--}}
        {{--}--}}

        {{--body::-webkit-scrollbar-track {--}}
            {{---webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);--}}
        {{--}--}}

        {{--body::-webkit-scrollbar-thumb {--}}
            {{--background-color: #353535;--}}
            {{--outline: 1px solid slategrey;--}}
        {{--}--}}

        {{--.fr-heading{--}}
            {{--font-size: 20px;--}}
        {{--}--}}

        {{--#forgot-modal .modal-header{--}}
            {{--background: #f0d20b;--}}
            {{--padding:10px 25px;--}}
        {{--}--}}

        {{--.earth-img{--}}
            {{--position: relative;--}}
        {{--}--}}

        {{--.earth-img img  {--}}
            {{--display: block;--}}
            {{--width: 450px ;--}}
            {{--margin:0 auto;--}}
        {{--}--}}

        {{--#loading{--}}
            {{---webkit-animation: rotation 10s infinite linear;--}}
        {{--}--}}

        {{--@-webkit-keyframes rotation {--}}
            {{--from {--}}
                {{---webkit-transform: rotate(0deg);--}}
            {{--}--}}
            {{--to {--}}
                {{---webkit-transform: rotate(359deg);--}}
            {{--}--}}
        {{--}--}}

        {{--.jio-img{--}}
            {{--position: absolute;--}}
            {{--top: 12%;--}}
            {{--left: 50%;--}}
            {{--margin-left: -115px;--}}
        {{--}--}}

        {{--.jio-img img{--}}
            {{--display: block;--}}
            {{--width: 230px;--}}
            {{--margin: 0 auto;--}}
        {{--}--}}

        {{--.mr-tp-30{--}}
            {{--margin-top: 50px;--}}
        {{--}--}}

        {{--@media screen and (max-width:992px){--}}
            {{--.mbool{display:none;}--}}
            {{--.login-wpr, .login-form{--}}
                {{--width: 100%;--}}
            {{--}--}}

            {{--.mr-tp-30{--}}
                {{--margin-top: 10px;--}}
            {{--}--}}

            {{--.jio-img{--}}
                {{--top: 4%;--}}
            {{--}--}}


        {{--}--}}


        {{--.margn {width:50%; float:left; text-align: center;}--}}
        {{--.margn1 {width:50%; float:right; text-align: center;}--}}

        {{--@media screen and (width:414px){--}}
            {{--.align-items-center {padding:40px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:411px){--}}
            {{--.align-items-center {padding:40px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:375px){--}}
            {{--.align-items-center {padding:40px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:360px){--}}
            {{--.align-items-center {padding:40px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:320px){--}}
            {{--.align-items-center {padding:40px 0 0px 0 !important;}--}}
        {{--}--}}


        {{--@media screen and (max-width:767px){--}}
            {{--.clor {font-weight: 600 !important; font-size: 30px !important;}--}}
            {{--.lg-wpr1 {padding:30px 0 30px 0;}--}}

            {{--.bg-opacity-9{min-height: inherit;}--}}
            {{--.login-container2{min-height: inherit;}--}}
            {{--.margn {width: 50%;}--}}
            {{--.underxxt1 {padding-bottom: 50px;   padding-left: 15px;  padding-right: 15px; width:auto;}--}}
            {{--.underxxt1 h3 {font-size: 18px;}--}}

            {{--.lg-wpr {padding: 30px 0 50px 0;}--}}
            {{--.top-bg {background-size: contain;     min-height: inherit;}--}}
            {{--.login-container{--}}
                {{--padding-right: 15px;--}}
            {{--}--}}

            {{--.login-wpr{--}}
                {{--margin-top:40px;--}}
                {{--width:100%;--}}
            {{--}--}}

            {{--.login-form{--}}
                {{--margin:0 auto;--}}
                {{--width:calc(100% - 2%);--}}
            {{--}--}}

            {{--.login-top img{--}}
                {{--margin-bottom: 15px;--}}
            {{--}--}}

            {{--.copy-right {--}}
                {{--padding: 10px 0 0 0;--}}
            {{--}--}}

            {{--.reg-sub-heading{--}}
                {{--padding-bottom: 20px;--}}
            {{--}--}}

            {{--.jio-img img{--}}
                {{--display: block;--}}
                {{--width: 180px;--}}
                {{--margin: 0 auto;--}}
            {{--}--}}

            {{--.jio-img{--}}
                {{--left: 58%;--}}
                {{--top: 12%;--}}
            {{--}--}}
        {{--}--}}


        {{--@media screen and (max-width:768px){--}}
            {{--.top-bg {--}}
                {{--background: url(images/main-bgr.png) no-repeat;--}}
                {{--background-size: contain;--}}
                {{--min-height: auto;--}}
            {{--}--}}
            {{--.login-container2{min-height:auto;}--}}
            {{--.align-items-center {--}}
                {{--padding: 80px 0 20px 0;--}}
            {{--}--}}
        {{--}--}}

        {{--hr, .hr {--}}
            {{--border: #5d5d5d solid 1px;--}}
            {{--margin: 10px 0 0px 0;--}}
        {{--}--}}
        {{--#reg_but{margin-top:10px;}--}}
        {{--.select2-container--default .select2-selection--single .select2-selection__rendered{color:#333;}--}}
        {{--.select2-container {border-radius: 4px;  width: 100% !important;  background: #fff;}--}}
        {{--.select2-container--default .select2-results>.select2-results__options {max-height: 200px; background: #fff;}--}}
        {{--.select2-container--default .select2-results__option--highlighted[aria-selected] {background: rgb(240, 210, 11);}--}}
        {{--.select2-container .select2-selection--single {height: 38px;}--}}
        {{--.select2-container--default .select2-selection--single .select2-selection__arrow:after {line-height: 38px;}--}}
        {{--.select2-container--default .select2-selection--single .select2-selection__rendered {--}}
            {{--line-height: 38px;--}}
            {{--font-size: 16px;--}}
            {{--padding-left: 13px;--}}
            {{--padding-right: 44px;--}}
        {{--}--}}


    {{--</style>--}}
    {{--<style type="text/css">--}}

        {{--.top-bg {--}}
            {{--background: url(images/main-bgr.png) no-repeat;--}}
            {{--background-size: cover;--}}
            {{--min-height: 100vh;--}}
        {{--}--}}
        {{--.countdown-box {--}}
            {{--background: #efd10b;--}}
        {{--}--}}
        {{--.dif1{color:#000;}--}}
        {{--.countdown-box .token-countdown .countdown-text {color: #000;}--}}
        {{--.countdown-box .token-countdown .countdown-time {color: #000;}--}}
        {{--.countdown-box .token-countdown .countdown-time:after {color:#000;}--}}

        {{--.site-header .navbar.is-transparent {--}}
            {{--background: #000;--}}
        {{--}--}}

        {{--.align-items-center{padding:80px 0 0px 0;}--}}

        {{--.m_tl {--}}
            {{--margin: 10px 0px 0px 20px;--}}
            {{--display: inline-block;--}}
            {{--vertical-align: top;--}}
        {{--}--}}


        {{--.login-container1{--}}
            {{--background:#f0d20b;--}}
        {{--}--}}

        {{--.login-container2{--}}
            {{--width: 100%;--}}
            {{--background: url(images/parallax-bg1.jpg);--}}
            {{--background-attachment: fixed;--}}
            {{--background-origin: initial;--}}
            {{--background-clip: initial;--}}
            {{--background-size: cover;--}}
            {{--background-repeat: no-repeat;--}}
            {{--background-position: 100% 0;--}}
            {{--background-position: center;--}}
            {{--z-index: 1;--}}
            {{--min-height: 70vh;--}}
        {{--}--}}




        {{--.login-container{--}}
            {{--/*background: url('images/login_back.jpg') no-repeat ;--}}
            {{--min-height: 80vh;--}}
            {{--max-width: 1400px;*/--}}
            {{--background:#f5f5f5;--}}
        {{--}--}}

        {{--.login-wpr{--}}
            {{--background: #353535;--}}
            {{--border-top: 5px solid #f0d20b;--}}
            {{--padding: 15px 25px 10px 25px;--}}
            {{--width: 100%;--}}
            {{--border-radius: 10px;--}}
            {{--box-shadow: 8px 8px 4px #9a9a9a61;--}}
        {{--}--}}

        {{--.login-top{--}}
            {{--text-align: center;--}}
        {{--}--}}

        {{--.login-top img{--}}
            {{--display: block;--}}
            {{--margin: 0 auto;--}}
            {{--padding:0 0 5px 0;--}}
            {{--width: 160px;--}}
        {{--}--}}

        {{--.login-form{--}}
            {{--font-size: 13px;--}}
            {{--margin:20px auto;--}}
        {{--}--}}

        {{--.login-form level{color: #fff; font-size: 16px; font-weight: 600;}--}}

        {{--.username, .password{--}}
            {{--border: 1px solid #dedede;--}}
            {{--border-radius:16px;--}}
            {{--display: block;--}}
            {{--height: 36px;--}}
            {{--margin-bottom: 15px;--}}
            {{--padding: 5px 15px;--}}
            {{--width: 100%;--}}
            {{--outline: none;--}}
        {{--}--}}

        {{--.forgot, .not-member{--}}
            {{--color: #fff;--}}
            {{--display: block;--}}
            {{--font-size:13px;--}}
            {{--margin:0 0 8px 8px;--}}
        {{--}--}}

        {{--.not-member{--}}
            {{--padding:0 0 0px 0;--}}
        {{--}--}}

        {{--.forgot:hover, .forgot:focus{--}}
            {{--color: #f0d20b;--}}
        {{--}--}}

        {{--.copy-right{--}}
            {{--border-top: 1px solid #2f2f2f;--}}
            {{--color: #fff;--}}
            {{--margin:10px 0 0 0;--}}
            {{--padding: 20px 0  0 0;--}}
            {{--text-align: center;--}}
        {{--}--}}

        {{--.underxxt{}--}}
        {{--.underxxt h2{font-weight: normal;    margin: 0 0 10px 0;    font-size: 40px;    letter-spacing: -1px;}--}}
        {{--.underxxt p{color: #333 !important;    text-align: left !important;    font-size: 18px;    line-height: 25px;}--}}

        {{--.underxxt1{margin-bottom:70px; width: 680px; margin:0 auto; padding-bottom:100px;}--}}
        {{--.underxxt1 h3 {font-size: 20px; text-align: center; color: #fff; font-weight: normal;}--}}
        {{--.clor{color: #333; font-weight:500 !important;}--}}
        {{--.form-control1{margin-bottom:20px;}--}}
        {{--.form-control {--}}
            {{--display: block;--}}
            {{--width: 100%;--}}
            {{--padding: .600rem .75rem;--}}
            {{--font-size: 14px;--}}
            {{--letter-spacing: -0.7px;--}}
            {{--line-height: 1.5;--}}
            {{--color: #495057;--}}
            {{--background-color: #fff;--}}
            {{--background-clip: padding-box;--}}
            {{--border: 1px solid #ced4da;--}}
            {{--border-radius: .25rem;--}}
            {{--transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;--}}
        {{--}--}}
        {{--.submit-btn {--}}
            {{--border-radius: 20px;--}}
            {{--border: none;--}}
            {{--color: #353535;--}}
            {{--cursor: pointer;--}}
            {{--text-decoration: none;--}}
            {{--padding: 6px 40px;--}}
            {{--display: block;--}}
            {{--margin:10px 7px 0 0px;--}}
            {{--max-width: 200px;--}}
            {{--text-align: center;--}}
            {{--text-transform: uppercase;--}}
            {{--font-weight: 600;--}}
            {{--background: linear-gradient(319deg, #a36d2a, #f1d20b, #986025);--}}
            {{--background-size: 400% 400%;--}}
            {{---webkit-animation: AnimationButton 3s ease infinite;--}}
            {{---moz-animation: AnimationButton 3s ease infinite;--}}
            {{--animation: AnimationButton 3s ease infinite;--}}
        {{--}--}}

        {{--.submit-btn:hover{--}}
            {{--cursor:pointer;--}}
        {{--}--}}

        {{--@-webkit-keyframes AnimationButton {--}}
            {{--0%{background-position:49% 0%}--}}
            {{--50%{background-position:52% 100%}--}}
            {{--100%{background-position:49% 0%}--}}
        {{--}--}}
        {{--@-moz-keyframes AnimationButton {--}}
            {{--0%{background-position:49% 0%}--}}
            {{--50%{background-position:52% 100%}--}}
            {{--100%{background-position:49% 0%}--}}
        {{--}--}}
        {{--@keyframes AnimationButton {--}}
            {{--0%{background-position:49% 0%}--}}
            {{--50%{background-position:52% 100%}--}}
            {{--100%{background-position:49% 0%}--}}
        {{--}--}}
        {{--.lg-wpr{--}}
            {{--padding :80px 0 100px 0;--}}
        {{--}--}}

        {{--.lg-wpr1{--}}
            {{--padding :50px 0 50px 0;--}}
        {{--}--}}

        {{--.reg-heading{--}}
            {{--color: #fff;--}}
            {{--font-size: 23px;--}}
            {{--margin-bottom: 5px;--}}
        {{--}--}}

        {{--.reg-sub-heading{--}}
            {{--color:#fff;--}}
            {{--font-size: 14px;--}}
        {{--}--}}

        {{--.text-white{--}}
            {{--color: #fff;--}}
        {{--}--}}

        {{--.mr-bt-20{--}}
            {{--margin-bottom: 20px;--}}
        {{--}--}}

        {{--#forgot-modal{--}}
            {{--top: 10% ;--}}
        {{--}--}}

        {{--body::-webkit-scrollbar {--}}
            {{--width: 0.4em;--}}
        {{--}--}}

        {{--body::-webkit-scrollbar-track {--}}
            {{---webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);--}}
        {{--}--}}

        {{--body::-webkit-scrollbar-thumb {--}}
            {{--background-color: #353535;--}}
            {{--outline: 1px solid slategrey;--}}
        {{--}--}}

        {{--.fr-heading{--}}
            {{--font-size: 20px;--}}
        {{--}--}}

        {{--#forgot-modal .modal-header{--}}
            {{--background: #f0d20b;--}}
            {{--padding:10px 25px;--}}
        {{--}--}}

        {{--.earth-img{--}}
            {{--position: relative;--}}
        {{--}--}}

        {{--.earth-img img  {--}}
            {{--display: block;--}}
            {{--width: 450px ;--}}
            {{--margin:0 auto;--}}
        {{--}--}}

        {{--#loading{--}}
            {{---webkit-animation: rotation 10s infinite linear;--}}
        {{--}--}}

        {{--@-webkit-keyframes rotation {--}}
            {{--from {--}}
                {{---webkit-transform: rotate(0deg);--}}
            {{--}--}}
            {{--to {--}}
                {{---webkit-transform: rotate(359deg);--}}
            {{--}--}}
        {{--}--}}

        {{--.jio-img{--}}
            {{--position: absolute;--}}
            {{--top: 12%;--}}
            {{--left: 50%;--}}
            {{--margin-left: -115px;--}}
        {{--}--}}

        {{--.jio-img img{--}}
            {{--display: block;--}}
            {{--width: 230px;--}}
            {{--margin: 0 auto;--}}
        {{--}--}}

        {{--.mr-tp-30{--}}
            {{--margin-top: 50px;--}}
        {{--}--}}

        {{--@media screen and (max-width:992px){--}}
            {{--.mbool{display:none;}--}}
            {{--.login-wpr, .login-form{--}}
                {{--width: 100%;--}}
            {{--}--}}

            {{--.mr-tp-30{--}}
                {{--margin-top: 10px;--}}
            {{--}--}}

            {{--.jio-img{--}}
                {{--top: 4%;--}}
            {{--}--}}


        {{--}--}}


        {{--.margn {width:50%; float:left; text-align: center;}--}}
        {{--.margn1 {width:50%; float:right; text-align: center;}--}}

        {{--@media screen and (width:414px){--}}
            {{--.align-items-center {padding:80px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:411px){--}}
            {{--.align-items-center {padding:80px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:375px){--}}
            {{--.align-items-center {padding:80px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:360px){--}}
            {{--.align-items-center {padding:80px 0 0px 0 !important;}--}}
        {{--}--}}

        {{--@media screen and (width:320px){--}}
            {{--.align-items-center {padding:80px 0 0px 0 !important;}--}}
        {{--}--}}


        {{--@media screen and (max-width:767px){--}}
            {{--.footer-links li {font-size: 12px;}--}}
            {{--.contennt1 h2 {font-size: 18px !important;}--}}
            {{--.contennt1 p {font-size: 10px !important;}--}}
            {{--.flag-t {    margin: 30px -10px 0 0 !important;    }--}}
            {{--.timeddss1 {    margin: 20px 0 30px !important;}--}}
            {{--.countdown-box{margin-top:10px !important;}--}}
            {{--.clor {font-weight: 600 !important; font-size: 30px !important;}--}}
            {{--.lg-wpr1 {padding:30px 0 30px 0;}--}}

            {{--.bg-opacity-9{min-height: inherit;}--}}
            {{--.login-container2{min-height: inherit;}--}}
            {{--.margn {width: 50%;}--}}
            {{--.underxxt1 {padding-bottom: 50px;   padding-left: 15px;  padding-right: 15px; width:auto;}--}}
            {{--.underxxt1 h3 {font-size: 18px;}--}}

            {{--.lg-wpr {padding: 30px 0 50px 0;}--}}
            {{--.top-bg {background-size: contain;     min-height: inherit;}--}}
            {{--.login-container{--}}
                {{--padding-right: 15px;--}}
            {{--}--}}

            {{--.login-wpr{--}}
                {{--margin-top:40px;--}}
                {{--width:100%;--}}
            {{--}--}}

            {{--.login-form{--}}
                {{--margin:0 auto;--}}
                {{--width:calc(100% - 2%);--}}
            {{--}--}}

            {{--.login-top img{--}}
                {{--margin-bottom: 15px;--}}
            {{--}--}}

            {{--.copy-right {--}}
                {{--padding: 10px 0 0 0;--}}
            {{--}--}}

            {{--.reg-sub-heading{--}}
                {{--padding-bottom: 20px;--}}
            {{--}--}}

            {{--.jio-img img{--}}
                {{--display: block;--}}
                {{--width: 180px;--}}
                {{--margin: 0 auto;--}}
            {{--}--}}

            {{--.jio-img{--}}
                {{--left: 58%;--}}
                {{--top: 12%;--}}
            {{--}--}}
        {{--}--}}


        {{--@media screen and (max-width:768px){--}}
            {{--.top-bg {--}}
                {{--background: url(images/main-bgr.png) no-repeat;--}}
                {{--background-size: contain;--}}
                {{--min-height: auto;--}}
            {{--}--}}
            {{--.login-container2{min-height:auto;}--}}
            {{--.align-items-center {--}}
                {{--padding:100px 0 20px 0;--}}
            {{--}--}}

            {{--.timeddss ul li {--}}
                {{--font-size: 25px !important;--}}
                {{--font-weight: 600;--}}
                {{--margin-bottom: 10px;--}}
                {{--margin-right:0 !important;--}}
            {{--}--}}

        {{--}--}}

        {{--.contennt{margin-top:20px;}--}}
        {{--.contennt h2{font-size: 20px;    color: #fff;    margin: 0 0 5px 0; font-weight:600;}--}}
        {{--.contennt p{font-size: 13px;    color: #fff;    margin: 0 0 15px 0;  font-weight:normal;   line-height: 20px;}--}}

        {{--.contennt1{margin-top:5px;}--}}
        {{--.contennt1 h2{font-size:18px;    color: #fff;    margin: 0 0 0px 0; font-weight:600;}--}}
        {{--.contennt1 p{font-size: 13px;    color: #fff;    margin: 0 0 10px 0;  font-weight:normal;   line-height: 20px;}--}}

        {{--.timeddss{margin-bottom: 5px;    margin-right: 0px;}--}}
        {{--/*.timeddss:last-child{margin-right:0px !important;}*/--}}
        {{--.timeddss h2{font-size: 20px;    color: #565656;    margin: 0 0 5px 0; font-weight:600;}--}}
        {{--.timeddss p{font-size: 14px;    color: #565656;    margin: 0 0 5px 0;  font-weight:normal;   line-height: 20px;}--}}
        {{--.timeddss ul{list-style:none; margin:0; padding:0;}--}}
        {{--.timeddss ul li{    display: block;--}}
            {{--margin: 0;--}}
            {{--font-size: 40px;--}}
            {{--font-weight: 600;--}}
            {{--color: #565656;--}}
            {{--margin-right: 20px;--}}
            {{--border-radius: 65px;--}}
            {{--margin-bottom: 10px;--}}
            {{--background: linear-gradient(#f7f7f7, #d8d8d8);--}}
            {{--text-align: center;--}}
            {{--border: #999 solid 2px;}--}}




        {{--.timeddss2{margin-bottom: 5px;    margin-right: 0px; margin-top:5px;}--}}
        {{--.timeddss2 h2{font-size: 20px;    color: #565656;    margin: 0 0 5px 0; font-weight:600;}--}}
        {{--.timeddss2 p{font-size: 14px;    color: #565656;    margin: 0 0 5px 0;  font-weight:normal;   line-height: 20px;}--}}
        {{--.timeddss2 ul{list-style:none; margin:0; padding:0;}--}}
        {{--.timeddss2 ul li{    display: block;    margin: 0;    font-size:11px;    font-weight: 600;--}}
            {{--color: #565656;   border-radius: 5px;    margin-bottom: 10px;--}}
            {{--background: linear-gradient(#f7f7f7, #d8d8d8);    text-align: center;    border: #999 solid 2px;}--}}
        {{--.timeddss2 ul li p{font-size:24px; font-weight:600;}--}}





        {{--.timeddss1{margin:50px 0 60px; text-align:center;}--}}
        {{--.timeddss1 h2{font-size: 38px;    color: #565656;    margin: 0 0 5px 0; font-weight:600;}--}}
        {{--.timeddss1 p{font-size: 16px;--}}
            {{--color: #565656;--}}
            {{--margin: 0 0 7px 0;--}}
            {{--font-weight: normal;--}}
            {{--line-height: 20px;}--}}
        {{--.countdown-box {padding: 20px 20px 0px 20px;}--}}

        {{--.progress {background-color: #ffffff !important;}--}}

        {{--#reg_but{margin-top:10px;}--}}
        {{--.select2-container--default .select2-selection--single .select2-selection__rendered{color:#333;}--}}
        {{--.select2-container {border-radius: 4px;  width: 100% !important;  background: #fff;}--}}
        {{--.select2-container--default .select2-results>.select2-results__options {max-height: 200px; background: #fff;}--}}
        {{--.select2-container--default .select2-results__option--highlighted[aria-selected] {--}}
            {{--background: rgb(240, 210, 11);--}}
        {{--}--}}
        {{--.leftsd {display: flex; margin-top:15px;}--}}
        {{--.leftsd label {font-weight: 600;--}}
            {{--color: #fff;--}}
            {{--margin-top: 11px;--}}
            {{--line-height: 22px;--}}
            {{--font-size: 20px;--}}
            {{--margin-right: 6px;}--}}

        {{--.nav-pills > li > a {border-radius: 4px 4px 0 0;--}}
            {{--background: #e9e9e9;--}}
            {{--font-size: 18px;--}}
            {{--font-weight: 600;--}}
            {{--color: #000;}--}}
        {{--.nav-pills > li{margin-right:5px; width: 49%;}--}}
        {{--#exTab3 .nav-pills > li:last-child{margin-right:0;}--}}

        {{--a.active {background: #f0d20b !important;    color: #000 !important;}--}}

        {{--.tab-content {color: white;  width:100%;    padding:1px 0px 0 0;}--}}
        {{--.nav-pills {margin-top: 10px;}--}}

    {{--</style>--}}
</head>
