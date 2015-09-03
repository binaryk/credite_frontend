@include('flash::message')
<div class="main">
  <div class="container">
   @include('template.parts.body.~breadcrumbs')
    <!-- BEGIN SIDEBAR & CONTENT -->
    <div class="row margin-bottom-40">
        @yield('content')
    </div>
  </div>
</div>