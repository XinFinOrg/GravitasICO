    @if(count($errors) > 0) 
           <div class="alert alert-danger">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        @foreach($errors->all() as $er)
        {{$er}}<br/>
        @endforeach
        </div>
        @endif

        @if($error)
    <div class="alert alert-danger">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ $error }}</div>
    @endif

     @if($success')
    <div class="alert alert-success">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ $success }}</div>
    @endif