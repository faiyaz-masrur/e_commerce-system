<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Catagory;

use App\Models\Product;

use App\Models\Order;

use App\Notifications\SendEmailNotification;

use App\Models\Contact;

use Notification;

use \PDF;

class AdminController extends Controller
{
    public function view_catagory()
    {
        $data = catagory::all();
        return view('admin.catagory',compact('data'));
    }

    public function add_catagory(Request $request)
    {
        $data = new catagory;

        $data->catagory_name=$request->catagory;

        $data->save();

        return redirect()->back()->with('message','Catagory Added Successfully');
    }

    public function delete_catagory($id)
    {
        $data = catagory::find($id);
        $data->delete();
        return redirect()->back()->with('message','Catagory Deleted Successfully');
    }

    public function view_product()
    {
        $catagory = catagory::all();
        return view('admin.product',compact('catagory'));
    }

    public function add_product(Request $request)
    {
        $product = new product;
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->discount_price=$request->dis_price;
        $product->catagory=$request->catagory;
        $image = $request->image;
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $request->image->move('product',$imagename);
        $product->image=$imagename;
        $product->save();
        return redirect()->back()->with('message','Product Added Successfully');
    }

    public function show_product()
    {
        $product = product::all();
        return view('admin.showProduct',compact('product'));
    }

    public function delete_product($id)
    {
        $product = product::find($id);
        $product->delete();
        return redirect()->back()->with('message','Product Deleted Successfully');
    }

    public function edit_product($id)
    {
        $product = product::find($id);
        $catagory = catagory::all();
        return view('admin.editProduct',compact('product','catagory'));
    }

    public function update_product(Request $request, $id)
    {
        $product = product::find($id);
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->discount_price=$request->dis_price;
        $product->catagory=$request->catagory;
        $image = $request->image;
        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('product',$imagename);
            $product->image=$imagename;
        }
        $product->save();
        return redirect()->back()->with('message','Product Updated Successfully');
    }

    public function order()
    {
        $order = order::all();
        return view('admin.order',compact('order'));
    }

    public function delivered($id)
    {
        $order = order::find($id);
        $order->delivery_status = "delivered";
        $order->payment_status = "paid";
        $order->save();
        return redirect()->back();
    }

    public function print_pdf($id)
    {
        $order = order::find($id);
        $pdf = PDF::loadView('admin.pdf',compact('order'));
        return $pdf->download('order_details.pdf');
    }

    public function search(Request $request)
    {
        $searchText = $request->search;
        $order = order::where('name','LIKE',"%$searchText%")->orWhere('phone','LIKE',"%$searchText%")->orWhere('product_title','LIKE',"%$searchText%")->get();
        return view('admin.order',compact('order'));
    }

    public function search_products(Request $request)
    {
        $searchText = $request->search;
        $product = product::where('title','LIKE',"%$searchText%")->orWhere('catagory','LIKE',"%$searchText%")->get();
        return view('admin.showProduct',compact('product'));
    }

    public function send_email($id)
    {
        $order = order::find($id);
        $order->email_status = 'emailed';
        $details = [
            'greeting' => 'Hello Sir!',
            'body' => 'We get your order and the order is processing for delivery.',
            'lastline' => 'Thank you for choosing us.',
        ];
        Notification::send($order, new SendEmailNotification($details));
        $order->save();
        return redirect()->back()->with('message','Message sent successfully');
    }

    public function queries()
    {
        $contact = contact::all();
        return view('admin.queries',compact('contact'));
    }

    public function reply_email($id)
    {
        $contact = contact::find($id);
        return view('admin.emailinfo',compact('contact'));
    }

    public function reply_user_email(Request $request, $id)
    {
        $contact = contact::find($id);
        $contact->email_status = 'emailed';
        $details = [
            'greeting' => $request->greeting,
            'body' => $request->body,
            'lastline' => $request->lastline,
        ];
        Notification::send($contact, new SendEmailNotification($details));
        $contact->save();
        return redirect()->back()->with('message','Message sent successfully');
    }
}
