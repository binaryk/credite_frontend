@extends('template.layout')
@section('title') About :: @parent @stop
@section('content')
<div class="row margin-bottom-40">
<!-- BEGIN CONTENT -->
      <div class="col-md-12 col-sm-12">
        <h1>Despre noi</h1>
        <div class="content-page">
          <div class="row margin-bottom-30">
            <!-- BEGIN INFO BLOCK -->               
            <div class="col-md-7">
              <h2 class="no-top-space"></h2>
              <p>
                Firma noastră vă pune la dispoziție o gamă variată de servicii, care vă vor înjumătăți drumul spre visul dvs. Printre serviciile noastre se numără:
              </p>
              <!-- BEGIN LISTS -->
              <div class="row front-lists-v1">
                <div class="col-md-6">
                  <ul class="list-unstyled margin-bottom-20">
                    <li><i class="fa fa-check"></i> Inregistrarea clienților pentru asigurare credite.</li>
                    <li><i class="fa fa-check"></i> Consultanță financiară în scopul obținerii finanțării pentru un proiect European.  </li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul class="list-unstyled">
                    <li><i class="fa fa-check"></i> Asigurări de viață.</li>
                  </ul>
                </div>
              </div>
              <!-- END LISTS -->
            </div>
            <!-- END INFO BLOCK -->
          </div>
          <div class="row margin-bottom-30">
            <!-- BEGIN CAROUSEL -->
            <div class="col-md-12 front-carousel">
              <div id="myCarousel" class="carousel slide">
                <!-- Carousel items -->
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="{{ asset('img/about/img_1-min.jpg') }}" alt="">
                    <div class="carousel-caption">
                      <p>Clientii sunt cei mai importanti.</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="{{ asset('img/about/img_2-min.jpg') }}" alt="">
                    <div class="carousel-caption">
                      <p>Viata poate fi mai frumoasa alaturi de noi.</p>
                    </div>
                  </div>
                </div>
                <!-- Carousel nav -->
                <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                  <i class="fa fa-angle-left"></i>
                </a>
                <a class="carousel-control right" href="#myCarousel" data-slide="next">
                  <i class="fa fa-angle-right"></i>
                </a>
              </div>
            </div>
            <!-- END CAROUSEL -->
          </div>
        </div>
      </div>
      <!-- END CONTENT -->
  </div>
@endsection