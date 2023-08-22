<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">
        .center
        {
            margin: auto;
            width: 70%;
            border: 2px solid white;
            text-align: center;
            margin-top: 40px;
        }

        .font_size
        {
            text-align: center;
            font-size: 40px;
            padding-top: 20px;
        }

        .th_color
        {
            background: yellowgreen;
        }

        .th_dg
        {
            padding: 30px;
        }

        .td_dg
        {
            padding: 20px;
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
                <h2 class="font_size">User Queries</h2>
                <table class="center">
                    <tr class="th_color">
                        <th class="th_dg">User Name</th>
                        <th class="th_dg">User Email</th>
                        <th class="th_dg">Subject</th>
                        <th class="th_dg">Message</th>
                        <th class="th_dg">Send Email</th>
                    </tr>
                    @foreach ($contact as $contact)
                        <tr>
                            <td class="td_dg">{{$contact->name}}</td>
                            <td class="td_dg">{{$contact->email}}</td>
                            <td class="td_dg">{{$contact->subject}}</td>
                            <td class="td_dg">{{$contact->body}}</td>
                            @if ($contact->email_status == NULL)
                                <td class="td_dg"><a href="{{url('reply_email',$contact->id)}}" class="btn btn-info">Send Email</a></td>
                            @else
                                <td class="td_dg">----</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
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