<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style type="text/css">
        label
        {
            display: inline-block;
            width: 200px;
            font-size: 15px;
            font-weight: bold;
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
                <h1 style="text-align: center; font-size: 25px;">Send email to {{$contact->email}}</h1>
                <form action="{{url('reply_user_email',$contact->id)}}" method="POST">
                    @csrf
                <div style="padding-left: 35%; padding-top: 30px;">
                    <label>Email Geeting :</label>
                    <input style="color: black;" type="text" name="greeting">
                </div>
                <div style="padding-left: 35%; padding-top: 30px;">
                    <label>Email Body :</label>
                    <input style="color: black;" type="text" name="body">
                </div>
                <div style="padding-left: 35%; padding-top: 30px;">
                    <label>Email Lastline :</label>
                    <input style="color: black;" type="text" name="lastline">
                </div>
                <div style="padding-left: 35%; padding-top: 30px;">
                    <input type="submit" value="Send Email" class="btn btn-primary">
                </div>
                </form>
            </div>
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>