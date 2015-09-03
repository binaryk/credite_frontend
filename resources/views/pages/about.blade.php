@extends('template.layout')
@section('title') About :: @parent @stop
@section('content')
<div class="row margin-bottom-40">
<!-- BEGIN CONTENT -->
      <div class="col-md-12 col-sm-12">
        <h1>About Us</h1>
        <div class="content-page">
          <div class="row margin-bottom-30">
            <!-- BEGIN INFO BLOCK -->               
            <div class="col-md-7">
              <h2 class="no-top-space">Vero eos et accusamus</h2>
              <p>Eurosofttech Ltd is a pioneer in the software industry. We create and adapt tailor-made software solutions of any kind for our customer. 
				Our customers are located all over the world and we ensure they are completely satisfied with our services. We liaise with our customers to ensure that during the development phase all their needs and requirements are incorporated into the systems and programmes we create. 

				</p><p>Cab Treasure is the most user-friendly and reliable system available, designed to meet the sales, efficiency and customer satisfaction objectives of the taxi and private hire industry. 
				Don't miss out on the opportunity to upgrade your business.</p>
              <!-- BEGIN LISTS -->
              <div class="row front-lists-v1">
                <div class="col-md-6">
                  <ul class="list-unstyled margin-bottom-20">
                    <li><i class="fa fa-check"></i> We have a large amount of experience in meeting the needs of the taxi industry.</li>
                    <li><i class="fa fa-check"></i> We have customers throughout the UK and some based overseas in other countries. </li>
                    <li><i class="fa fa-check"></i> We are able to supply you with the any additional hardware you may need (such as desktop PCs).</li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul class="list-unstyled">
                    <li><i class="fa fa-check"></i> We consider that superior technology should be trouble-free, convenient and most importantly adaptable.e consider that superior technology should be trouble-free, convenient and scalable.</li>
                    <li><i class="fa fa-check"></i> We have served many clients all around the world. </li>
                    <li><i class="fa fa-check"></i> We are known for the lowest rates among competitors.</li>
                  </ul>
                </div>
              </div>
              <!-- END LISTS -->
            </div>
            <!-- END INFO BLOCK -->   

            <!-- BEGIN CAROUSEL -->            
            <div class="col-md-5 front-carousel">
              <div id="myCarousel" class="carousel slide">
                <!-- Carousel items -->
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="{{ asset('assets/frontend/pages/img/pics/img2-medium.jpg') }}" alt="">
                    <div class="carousel-caption">
                      <p>Excepturi sint occaecati cupiditate non provident</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="{{ asset('assets/frontend/pages/img/pics/img1-medium.jpg') }}" alt="">
                    <div class="carousel-caption">
                      <p>Ducimus qui blanditiis praesentium voluptatum</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="{{ asset('assets/frontend/pages/img/pics/img2-medium.jpg') }}" alt="">
                    <div class="carousel-caption">
                      <p>Ut non libero consectetur adipiscing elit magna</p>
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

          <div class="row margin-bottom-40">
            <!-- BEGIN TESTIMONIALS -->
            <div class="col-md-7 testimonials-v1">
              <h2>Clients Testimonials</h2>                
              <div id="myCarousel1" class="carousel slide">
                <!-- Carousel items -->
                <div class="carousel-inner">
                  <div class="active item">
                    <blockquote><p>We have experience in the taxi and private hire industry and we believe that this experience allows us to understand the needs of our clients. 
					We are honest when it comes to pricing – there are no hidden charges</p></blockquote>
                    <div class="carousel-info">
                      <img class="pull-left" src="{{ asset('assets/frontend/pages/img/people/img1-small.jpg') }}" alt="">
                      <div class="pull-left">
                        <span class="testimonials-name">Lina Mars</span>
                        <span class="testimonials-post">Commercial Director</span>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <blockquote><p>Raw denim you Mustache cliche tempor, williamsburg carles vegan helvetica probably haven't heard of them jean shorts austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.</p></blockquote>
                    <div class="carousel-info">
                      <img class="pull-left" src="{{ asset('assets/frontend/pages/img/people/img5-small.jpg') }}" alt="">
                      <div class="pull-left">
                        <span class="testimonials-name">Kate Ford</span>
                        <span class="testimonials-post">Commercial Director</span>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <blockquote><p>Reprehenderit butcher stache cliche tempor, williamsburg carles vegan helvetica.retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid Aliquip placeat salvia cillum iphone.</p></blockquote>
                    <div class="carousel-info">
                      <img class="pull-left" src="{{ asset('assets/frontend/pages/img/people/img2-small.jpg') }}" alt="">
                      <div class="pull-left">
                        <span class="testimonials-name">Jake Witson</span>
                        <span class="testimonials-post">Commercial Director</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Carousel nav -->
                <a class="left-btn" href="#myCarousel1" data-slide="prev"></a>
                <a class="right-btn" href="#myCarousel1" data-slide="next"></a>
              </div>
            </div>
            <!-- END TESTIMONIALS -->  
          </div>

          <div class="row front-team">
            <ul class="list-unstyled">
              <li class="col-md-3">
                <div class="thumbnail">
                  <img alt="" src="{{ asset('assets/frontend/pages/img/people/img1-large.jpg') }}">
                  <h3>
                    <strong>Lina Doe</strong> 
                    <small>Chief Executive Officer / CEO</small>
                  </h3>
                  <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, justo sit amet risus etiam porta sem...</p>
                  <ul class="social-icons social-icons-color">
                    <li><a class="facebook" data-original-title="Facebook" href="#"></a></li>
                    <li><a class="twitter" data-original-title="Twitter" href="#"></a></li>
                    <li><a class="googleplus" data-original-title="Goole Plus" href="#"></a></li>
                    <li><a class="linkedin" data-original-title="Linkedin" href="#"></a></li>
                  </ul>
                </div>
              </li>
              <li class="col-md-3">
                <div class="thumbnail">
                  <img alt="" src="{{ asset('assets/frontend/pages/img/people/img4-large.jpg') }}">
                  <h3>
                    <strong>Carles Puyol</strong> 
                    <small>Chief Executive Officer / CEO</small>
                  </h3>
                  <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, justo sit amet risus etiam porta sem...</p>
                  <ul class="social-icons social-icons-color">
                    <li><a class="facebook" data-original-title="Facebook" href="#"></a></li>
                    <li><a class="twitter" data-original-title="Twitter" href="#"></a></li>
                    <li><a class="googleplus" data-original-title="Goole Plus" href="#"></a></li>
                    <li><a class="linkedin" data-original-title="Linkedin" href="#"></a></li>
                  </ul>
                </div>
              </li>
              <li class="col-md-3">
                <div class="thumbnail">
                  <img alt="" src="{{ asset('assets/frontend/pages/img/people/img2-large.jpg') }}">
                  <h3>
                    <strong>Andres Iniesta</strong> 
                    <small>Chief Executive Officer / CEO</small>
                  </h3>
                  <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, justo sit amet risus etiam porta sem...</p>
                  <ul class="social-icons social-icons-color">
                    <li><a class="facebook" data-original-title="Facebook" href="#"></a></li>
                    <li><a class="twitter" data-original-title="Twitter" href="#"></a></li>
                    <li><a class="googleplus" data-original-title="Goole Plus" href="#"></a></li>
                    <li><a class="linkedin" data-original-title="Linkedin" href="#"></a></li>
                  </ul>
                </div>
              </li>
              <li class="col-md-3">
                <div class="thumbnail">
                  <img alt="" src="{{ asset('assets/frontend/pages/img/people/img5-large.jpg') }}">
                  <h3>
                    <strong>Jessica Alba</strong> 
                    <small>Chief Executive Officer / CEO</small>
                  </h3>
                  <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, justo sit amet risus etiam porta sem...</p>
                  <ul class="social-icons social-icons-color">
                    <li><a class="facebook" data-original-title="Facebook" href="#"></a></li>
                    <li><a class="twitter" data-original-title="Twitter" href="#"></a></li>
                    <li><a class="googleplus" data-original-title="Goole Plus" href="#"></a></li>
                    <li><a class="linkedin" data-original-title="Linkedin" href="#"></a></li>
                  </ul>
                </div>
              </li>
            </ul>            
          </div>

        </div>
      </div>
      <!-- END CONTENT -->
  </div>
@endsection