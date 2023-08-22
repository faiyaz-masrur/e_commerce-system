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
      <title>Order</title>
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
            padding: 70px;
            text-align: center;
        }

        table,th,td
        {
            border: 1px solid black;
        }

        .th_dg
        {
            padding: 10px;
            background-color: yellowgreen;
            font-size: 20px;
            font-weight: bold;
        }

        .img_dg
        {
            height: 100px;
            width: 150px;
        }
      </style>
   </head>
   <body class="sub_page">
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
      </div>
        <section class="inner_page_head">
         <div class="container_fuild">
            <div class="row">
               <div class="col-md-12">
                  <div class="full">
                     <h3>Order</h3>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <div class="center">
            <table>
                <tr>
                    <th class="th_dg">Product Title</th>
                    <th class="th_dg">Quantity</th>
                    <th class="th_dg">Price</th>
                    <th class="th_dg">Payment Status</th>
                    <th class="th_dg">Delivery Status</th>
                    <th class="th_dg">Image</th>
                    <th class="th_dg">Cancel Order</th>
                </tr>
                @foreach ($order as $order)
                    <tr>
                        <td>{{$order->product_title}}</td>
                        <td>{{$order->quantity}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{$order->payment_status}}</td>
                        <td>{{$order->delivery_status}}</td>
                        <td><img class="img_dg" src="product/{{$order->image}}" alt="#"></td>
                        @if ($order->delivery_status == 'processing')
                            <td><a class="btn btn-danger" onclick="return confirm('Are you sure to cancel this order?')" href="{{url('cancel_order',$order->id)}}">Cancel Order</a></td>
                        @else
                            <td>Not Allowed</td>
                        @endif
                    </tr>
                @endforeach
            </table>
         </div>
      @include('home.footer')
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