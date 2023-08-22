<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="{{asset('home/images/favicon.png')}}" type="">
      <title>All Products</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}" />
      <!-- font awesome style -->
      <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{asset('home/css/responsive.css')}}" rel="stylesheet" />
   </head>
   <body class="sub_page">
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
      </div>
      <!-- inner page section -->
      <section class="inner_page_head">
         <div class="container_fuild">
            <div class="row">
               <div class="col-md-12">
                  <div class="full">
                     <h3>All Products</h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <div style="padding : 30px;">
         <form class="form-inline" action="{{url('search_products_user')}}" method="GET">
            @csrf
            <input style="color: black;" type="text" name="search" placeholder="Search Products">
            <input  align:center;" type="submit" value="Search" class="btn btn-outline-primary">
         </form>
      </div>
      <section class="product_section layout_padding">
         <div class="container">
            <div class="row">
               @foreach ($product as $products)
               <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="box">
                     <div class="option_container">
                        <div class="options">
                           <a href="{{url('product_details',$products->id)}}" class="option1">
                           Product Details
                           </a>
                           @if ($products->quantity == 0)
                               <p>Out Of Stock</p>
                           @else
                              <form action="{{url('add_cart',$products->id)}}" method="POST">
                              @csrf
                              <div class="row">
                                 <div class="col-md-4">
                                    <input type="number" name="quantity" value="1" min="1" width="100px">
                                 </div>
                                 <div class="col-md-4">
                                    <input type="submit" value="Add to Cart">
                                 </div>
                              </div>
                              </form>
                           @endif
                        </div>
                     </div>
                     <div class="img-box">
                        <img src="product/{{$products->image}}" alt="">
                     </div>
                     <div class="detail-box">
                        <h5>
                           {{$products->title}}
                        </h5>

                        @if ($products->discount_price!=null)
                           <h6 style="color: blue"> BDT{{$products->discount_price}} </h6>
                           <h6 style="text-decoration: line-through; color: red"> BDT{{$products->price}} </h6>
                        @else
                           <h6 style="color: blue"> BDT{{$products->price}} </h6>
                        @endif
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </section>
      <!-- footer section -->
      @include('home.footer')
      <!-- footer section -->
      <!-- jQery -->
      <script src="{{asset('home/js/jquery-3.4.1.min.js')}}"></script>
      <!-- popper js -->
      <script src="{{asset('home/js/popper.min.js')}}"></script>
      <!-- bootstrap js -->
      <script src="{{asset('home/js/bootstrap.js')}}"></script>
      <!-- custom js -->
      <script src="{{asset('home/js/custom.js')}}"></script>
   </body>
</html>