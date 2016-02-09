<div class="header">
  <div class="container">
   <div class="col-md-3">
     <a class="site-logo" href="{{route('home')}}">
       <img width="500" class="logo" src="{{ asset('img/logo.png') }}" alt="creditfin.ro"></a>
     <a href="{{route('home')}}" class="mobi-toggler"><i class="fa fa-bars"></i></a>
   </div>
    <div class="col-md-9">
      @include('template.parts.body.~menu')
    </div>
  </div>
</div>

