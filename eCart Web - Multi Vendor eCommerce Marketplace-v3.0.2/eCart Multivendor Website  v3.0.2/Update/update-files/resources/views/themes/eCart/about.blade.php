<!-- breadcumb -->
<section class="page_title corner-title overflow-visible">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h1> {{__('msg.about_us')}}</h1>
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('home') }}">{{__('msg.home')}}</a>
               </li>
               <li class="breadcrumb-item">
                  <a>{{__('msg.more')}}</a>
               </li>
               <li class="breadcrumb-item active">
                  {{__('msg.about_us')}}
               </li>
            </ol>
            <div class="divider-15 d-none d-xl-block"></div>
         </div>
      </div>
   </div>
</section>
<!-- eof breadcumb -->
<div class="main-content">
   <!-- about company -->
   <section class="about-us my-2 my-md-3">
      <div class="about-us-area">
         <div class="container-fluid">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded mb-3">
            <div class="row">
               <div class="col-lg-6 col-md-6">
                  <div class="about-us-img text-center">
                     <a href="#">
                     <img class="lazy" data-original="{{theme('images/aboutus.png')}}" alt="">
                     </a>
                  </div>
               </div>
               <div class="col-lg-6 col-md-6 align-self-center">
                  <div class="about-us-content">
                     <p class="peragraph-blog">{!! $data['content'] !!}</p>
                     <div class="about-us-btn btn-hover hover-border-none">
                        <a class="btn-color-white btn-color-theme-bg black-color" href="{{route('shop')}}">{{__('msg.shop_now')}}</a>
                     </div>
                  </div>
               </div>
            </div>
            </div>
         </div>
      </div>
   </section>
   <!-- feature -->
   <section class="feature-area my-2 my-md-3 section-padding-3">
      <div class="container-fluid">
         <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded mb-3">
         <div class="row">
            <div class="d-block heading-feature">
               <h2 class="text-capitalize">{{__('msg.What We Provide')}}</h2>
               <span class="animate-border mb-40"></span>
            </div>
         </div>
         <div class="feature-border feature-border-about">
            <div class="row">
               <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="feature-wrap mb-30 text-center">
                     <em class="fas fa-star fa-2x"></em>
                     <h5>{{__('msg.Best Product')}}</h5>
                     <span>{{__('msg.Best Queality Products')}}</span>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="feature-wrap mb-30 text-center">
                     <em class="fas fa-cog fa-2x"></em>
                     <h5>{{__('msg.100% fresh')}}</h5>
                     <span>{{__('msg.Best Queality Products')}}</span>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="feature-wrap mb-30 text-center">
                     <em class="fas fa-user-lock fa-2x"></em>
                     <h5>{{__('msg.Secure Payment')}}</h5>
                     <span>{{__('msg.Best Queality Products')}}</span>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="feature-wrap mb-30 text-center">
                     <em class="fas fa-mug-hot fa-2x"></em>
                     <h5>{{__('msg.Best Wood')}}</h5>
                     <span>{{__('msg.Best Queality Products')}}</span>
                  </div>
               </div>
            </div>
         </div>
         </div>
      </div>
   </section>
   <!-- our team -->
   <section class="teams my-2 my-md-3">
      <div class="container-fluid">
         <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded mb-3">
         <div class="heading heading-center mb-3">
            <h2>{{__('msg.Our Team')}}</h2>
            <span class="animate-border"></span>
         </div>
         <div class=" team-members team-members-shadow m-b-40 team-carousel owl-carousel">
            <div class="team-member">
               <div class="team-image">
                  <img class="lazy" data-original="{{theme('images/team.png')}}" alt="team">
               </div>
               <div class="team-desc">
                  <h3>{{__('msg.Alea Smith')}}</h3>
                  <span>{{__('msg.Software Developer')}}</span>
                  <p>{{__('msg.team_description')}}</p>
                  <div class="align-center">
                     <a class="btn btn-xs btn-slide btn-light" href="#">
                     <em class="fab fa-facebook-f"></em>
                     <span>{{__('msg.Facebook')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="100">
                     <em class="fab fa-twitter"></em>
                     <span>{{__('msg.Twitter')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="118">
                     <em class="fab fa-instagram"></em>
                     <span>{{__('msg.Instagram')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="mailto:#" data-width="80">
                     <em class="fas fa-envelope"></em>
                     <span>{{__('msg.Mail')}}</span>
                     </a>
                  </div>
               </div>
            </div>
            <div class="team-member">
               <div class="team-image">
                  <img class="lazy" data-original="{{theme('images/team-2.png')}}" alt="team2">
               </div>
               <div class="team-desc">
                  <h3>{{__('msg.Emma Ross')}}</h3>
                  <span>{{__('msg.Software Developer')}}</span>
                  <p>{{__('msg.team_description')}}</p>
                  <div class="align-center">
                     <a class="btn btn-xs btn-slide btn-light" href="#">
                     <em class="fab fa-facebook-f"></em>
                     <span>{{__('msg.Facebook')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="100">
                     <em class="fab fa-twitter"></em>
                     <span>{{__('msg.Twitter')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="118">
                     <em class="fab fa-instagram"></em>
                     <span>{{__('msg.Instagram')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="mailto:#" data-width="80">
                     <em class="fas fa-envelope"></em>
                     <span>{{__('msg.Mail')}}</span>
                     </a>
                  </div>
               </div>
            </div>
            <div class="team-member">
               <div class="team-image">
                  <img class="lazy" data-original="{{theme('images/team-3.png')}}" alt="team">
               </div>
               <div class="team-desc">
                  <h3>{{__('msg.Ariol Doe')}}</h3>
                  <span>{{__('msg.Software Developer')}}</span>
                  <p>{{__('msg.team_description')}}</p>
                  <div class="align-center">
                     <a class="btn btn-xs btn-slide btn-light" href="#">
                     <em class="fab fa-facebook-f"></em>
                     <span>{{__('msg.Facebook')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="100">
                     <em class="fab fa-twitter"></em>
                     <span>{{__('msg.Twitter')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="118">
                     <em class="fab fa-instagram"></em>
                     <span>{{__('msg.Instagram')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="mailto:#" data-width="80">
                     <em class="fas fa-envelope"></em>
                     <span>{{__('msg.Mail')}}</span>
                     </a>
                  </div>
               </div>
            </div>
            <div class="team-member">
               <div class="team-image">
                  <img class="lazy" data-original="{{theme('images/team-4.png')}}" alt="team">
               </div>
               <div class="team-desc">
                  <h3>{{__('msg.Victor parker')}}</h3>
                  <span>{{__('msg.Software Developer')}}</span>
                  <p>{{__('msg.team_description')}}</p>
                  <div class="align-center">
                     <a class="btn btn-xs btn-slide btn-light" href="#">
                     <em class="fab fa-facebook-f"></em>
                     <span>{{__('msg.Facebook')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="100">
                     <em class="fab fa-twitter"></em>
                     <span>{{__('msg.Twitter')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="118">
                     <em class="fab fa-instagram"></em>
                     <span>{{__('msg.Instagram')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="mailto:#" data-width="80">
                     <em class="fas fa-envelope"></em>
                     <span>{{__('msg.Mail')}}</span>
                     </a>
                  </div>
               </div>
            </div>
            <div class="team-member">
               <div class="team-image">
                  <img class="lazy" data-original="{{theme('images/team-3.png')}}" alt="team">
               </div>
               <div class="team-desc">
                  <h3>{{__('msg.Ariol Doe')}}</h3>
                  <span>{{__('msg.Software Developer')}}</span>
                  <p>{{__('msg.team_description')}}</p>
                  <div class="align-center">
                     <a class="btn btn-xs btn-slide btn-light" href="#">
                     <em class="fab fa-facebook-f"></em>
                     <span>{{__('msg.Facebook')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="100">
                     <em class="fab fa-twitter"></em>
                     <span>{{__('msg.Twitter')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="#" data-width="118">
                     <em class="fab fa-instagram"></em>
                     <span>{{__('msg.Instagram')}}</span>
                     </a>
                     <a class="btn btn-xs btn-slide btn-light" href="mailto:#" data-width="80">
                     <em class="fas fa-envelope"></em>
                     <span>{{__('msg.Mail')}}</span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         </div>
      </div>
   </section>
   <!-- testimonials -->
   <section class="testimonial-area my-2 my-md-3">
      <div class="container-fluid">
         <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded mb-3">
         <div class="section-title-2">
            <h2>{{__('msg.Testimonials')}}</h2>
            <span class="animate-border mb-4"></span>
         </div>
         <div class="testimonial-active owl-carousel">
            <div class="inner-testimonial">
               <div class="client-content">
                  <p>{{__('msg.testimonial_description1')}}</p>
               </div>
               <div class="client-info">
                  <img  class="lazy" data-original="{{theme('images/testimonial-1.png')}}" alt="testimonial">
                  <h5>{{__('msg.testimonial_name1')}}</h5>
                  <span>{{__('msg.Deginer')}}</span>
               </div>
            </div>
            <div class="inner-testimonial">
               <div class="client-content">
                  <p>{{__('msg.testimonial_description2')}}</p>
               </div>
               <div class="client-info">
                  <img class="lazy" data-original="{{theme('images/testimonial-2.png')}}" alt="testimonial">
                  <h5>{{__('msg.testimonial_name2')}}</h5>
                  <span>{{__('msg.Developer')}}</span>
               </div>
            </div>
            <div class="inner-testimonial">
               <div class="client-content">
                  <p>{{__('msg.testimonial_description1')}}</p>
               </div>
               <div class="client-info">
                  <img  class="lazy" data-original="{{theme('images/testimonial-3.png')}}" alt="testimonial">
                  <h5>{{__('msg.testimonial_name1')}}</h5>
                  <span>{{__('msg.Customer')}}</span>
               </div>
            </div>
         </div>
         </div>
      </div>
   </section>
   <!-- partners -->
   <section class="brand-logo-area my-2 my-md-3">
      <div class="container-fluid">
         <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow rounded mb-3">
         <div class="heading heading-center mb-5">
            <h2>{{__('msg.Collabration')}}</h2>
            <span class="animate-border"></span>
         </div>
         <div class="brand-logo-padding bg-light-gray">
            <div class="brand-logo-active-2 owl-carousel">
               <div class="single-brand-logo">
                  <img class="lazy" data-original="{{theme('images/brandpartners.png')}}" alt="">
               </div>
               <div class="single-brand-logo">
                  <img class="lazy" data-original="{{theme('images/brandpartners.png')}}" alt="">
               </div>
               <div class="single-brand-logo">
                  <img class="lazy" data-original="{{theme('images/brandpartners.png')}}" alt="">
               </div>
               <div class="single-brand-logo">
                  <img class="lazy" data-original="{{theme('images/brandpartners.png')}}" alt="">
               </div>
               <div class="single-brand-logo">
                  <img class="lazy" data-original="{{theme('images/brandpartners.png')}}" alt="">
               </div>
               <div class="single-brand-logo">
                  <img class="lazy" data-original="{{theme('images/brandpartners.png')}}" alt="">
               </div>
            </div>
         </div>
         </div>
      </div>
   </section>
</div>
