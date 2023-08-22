<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style type="text/css">
        .title_dg
        {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            padding-bottom: 40px;
        }

        .table_dg
        {
            border: 2px solid white;
            margin: auto;
            width: 100%;
            text-align: center;
        }

        .th_dg
        {
            background-color: yellowgreen;
        }

        .img_dg
        {
            width: 150px;
            height: 100px;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
        <!-- partial:partials/_navbar.html -->
        @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
               @if(session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{session()->get('message')}}
                </div>
                @endif
                <h1 class="title_dg">All Orders</h1>
                <div style="padding-left: 450px; padding-bottom: 30px;">
                  <form action="{{url('search')}}" method="GET">
                    @csrf
                    <input style="color: black;" type="text" name="search" placeholder="Search orders">
                    <input type="submit" value="Search" class="btn btn-outline-primary">
                  </form>
                </div>
                <table class="table_dg">
                    <tr class="th_dg">
                        <th style="padding: 10px;">Name</th>
                        <th style="padding: 10px;">Email</th>
                        <th style="padding: 10px;">Phone</th>
                        <th style="padding: 10px;">Address</th>
                        <th style="padding: 10px;">Product Title</th>
                        <th style="padding: 10px;">Quantity</th>
                        <th style="padding: 10px;">Price</th>
                        <th style="padding: 10px;">Payment Status</th>
                        <th style="padding: 10px;">Delivery Status</th>
                        <th style="padding: 10px;">Image</th>
                        <th style="padding: 10px;">Delivered</th>
                        <th style="padding: 10px;">Send Email</th>
                        <th style="padding: 10px;">Print</th>
                    </tr>
                    @forelse ($order as $order)
                    <tr>
                        <td>{{$order->name}}</td>
                        <td>{{$order->email}}</td>
                        <td>{{$order->phone}}</td>
                        <td>{{$order->address}}</td>
                        <td>{{$order->product_title}}</td>
                        <td>{{$order->quantity}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{$order->payment_status}}</td>
                        <td>{{$order->delivery_status}}</td>
                        <td><img class="img_dg" src="/product/{{$order->image}}" alt="#"></td>
                        @if($order->delivery_status=='processing')
                        <td><a href="{{url('delivered',$order->id)}}" onclick="return confirm('Are you sure the product is delivered!!!')" class="btn btn-success">Delivered</a></td>
                        @if ($order->email_status == NULL)
                        <td><a href="{{url('send_email',$order->id)}}" class="btn btn-info">Send Email</a></td>
                        @else
                        <td>----</td>
                        @endif
                        @else
                        <td>----</td>
                        <td>----</td>
                        @endif
                        <td><a href="{{url('print_pdf',$order->id)}}" class="btn btn-secondary">Print PDF</a></td>  
                    </tr>
                    @empty
                      <tr>
                        <td colspan="16">No Data Found</td>
                      </tr>
                    @endforelse
                </table>
            </div>
        </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>