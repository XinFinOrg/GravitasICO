@extends('front.layout.front')
@section('content')



    <section class="mt60" style="min-height:740px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default noBorder">
                        <h3 class="mb20">{{$page->heading}}</h3>
                        <p class="font16">
                            {!! $page->content !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection