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
      <title>Cart</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}" />
      <!-- font awesome style -->
      <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{asset('home/css/responsive.css')}}" rel="stylesheet" />

      <style type="text/css">
        .center
        {
            margin: auto;
            width: 70%;
            text-align: center;
            padding: 70px;
        }

        table,th,td
        {
            border: 1px solid gray;
        }

        .th_dg
        {
            font-size: 23px;
            padding: 5px;
            background: yellowgreen;
        }

        .img_dg
        {
            height: 130px;
            width: 200px;
        }

        .total_price
        {
            font-size: 20px;
            padding: 40px;
        }
      </style>
   </head>
   <body class="sub_page">
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
      </div>
       @if(session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{session()->get('message')}}
                </div>
       @endif
      <!-- inner page section -->
      <section class="inner_page_head">
         <div class="container_fuild">
            <div class="row">
               <div class="col-md-12">
                  <div class="full">
                     <h3>Cart</h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- end inner page section -->
      <div class="center">
        <table>
            <tr>
                <th class="th_dg">Product Title</th>
                <th class="th_dg">Product Quantity</th>
                <th class="th_dg">Product Price</th>
                <th class="th_dg">Product Image</th>
                <th class="th_dg">Action</th>
            </tr>
            <?php $totalprice = 0; ?>
            @foreach ($cart as $cart)
                <tr>
                    <td>{{$cart->product_title}}</td>
                    <td>{{$cart->quantity}}</td>
                    <td>BDT-{{$cart->price}}</td>
                    <td><img class="img_dg" src="/product/{{$cart->image}}" alt="#"></td>
                    <td><a class="btn btn-danger" onclick="return confirm('Are you sure to remove this product?')" href="{{url('/remove_cart',$cart->id)}}">Remove Product</a></td>
                </tr>
                <?php $totalprice = $totalprice + $cart->price; ?>
            @endforeach
        </table>
        <div>
            <h1 class="total_price">Total Price : BDT-{{$totalprice}}</h1>
        </div>
        <div>
            <h1 style="font-size: 25px; padding-bottom: 15px;">Proceed to Order</h1>
            <a href="{{url('cash_order')}}" class="btn btn-danger">Cash On Delivery</a>
            <a href="{{url('pay',$totalprice)}}" class="btn btn-danger">Pay Using Paypal</a>
        </div>
      </div>
      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
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