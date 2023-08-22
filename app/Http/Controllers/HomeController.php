<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Contact;

use Session;
use Stripe;

class HomeController extends Controller
{
    public function index()
    {
        $product = Product::paginate(3);
        $comment = comment::orderby('id','desc')->get();
        $reply = reply::all();
        return view('home.userpage',compact('product','comment','reply'));
    }

    public function redirect()
    {
        $user_type=Auth::user()->user_type;

        if($user_type == '1')
        {
            $total_product = product::all()->count();
            $total_order = order::all()->count();
            $total_user = user::all()->count();
            $order = order::all();
            $total_revenue = 0;
            foreach($order as $order)
            {
                $total_revenue = $total_revenue + $order->price;
            }
            $total_delivery = order::where('delivery_status','=','delivered')->get()->count();
            $total_processing = order::where('delivery_status','=','processing')->get()->count();
            return view('admin.home',compact('total_product','total_order','total_user','total_revenue','total_processing','total_delivery'));
        }
        else
        {
            $product = Product::paginate(3);
            $comment = comment::orderby('id','desc')->get();
            $reply = reply::all();
            return view('home.userpage',compact('product','comment','reply'));
        }
    }

    public function product_details($id)
    {
        $product = Product::find($id);
        return view('home.productDetails',compact('product'));
    }

    public function add_cart(Request $request,$id)
    {
        if(Auth::id())
        {
            $user = Auth::user();
            $product = product::find($id);
            $cart = cart::where('product_id','=',$id)->first();
            if($cart != null)
            {
                $cart->quantity = $cart->quantity + $request->quantity;
                if($product->discount_price!=null)
                {
                    $cart->price = $cart->price + $product->discount_price * $request->quantity;
                }
                else
                {
                    $cart->price = $cart->price + $product->price * $request->quantity;
                }
            }
            else
            {
                $cart = new cart;
                $cart->user_id = $user->id;
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->product_title = $product->title;
                if($product->discount_price!=null)
                {
                    $cart->price = $product->discount_price * $request->quantity;
                }
                else
                {
                    $cart->price = $product->price * $request->quantity;
                }
                $cart->image = $product->image;
                $cart->product_id = $product->id;
                $cart->quantity = $request->quantity;
            }
            $product->quantity = $product->quantity - $request->quantity;
            $product->save();
            $cart->save();
            return redirect()->back();
        }
        else
        {
            return redirect('login');
        }
    }

    public function show_cart()
    {
        if(Auth::id())
        {
            $id = Auth::user()->id;
            $cart = cart::where('user_id','=',$id)->get();
            return view('home.showCart',compact('cart'));
        }
        else
        {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {
        $cart = cart::find($id);
        $cart->delete();
        return redirect()->back();
    }

    public function cash_order()
    {
        $user = Auth::User();
        $userid = $user->id;
        $cart = cart::where('user_id','=',$userid)->get();
        foreach($cart as $cart)
        {
            $order = new order;
            $order->name = $cart->name;
            $order->email = $cart->email;
            $order->phone = $cart->phone;
            $order->address = $cart->address;
            $order->user_id = $cart->user_id;
            $order->product_title = $cart->product_title;
            $order->quantity = $cart->quantity;
            $order->price = $cart->price;
            $order->image = $cart->image;
            $order->product_id = $cart->product_id;
            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing';
            $order->save();
            $cartid = $cart->id;
            $data = cart::find($cartid);
            $data->delete();
        }
        return redirect()->back()->with('message','Order Placed Successfully');
    }

    public function stripe($totalprice)
    {
        return view('home.stripe',compact('totalprice'));
    }

    public function show_order()
    {
        if(Auth::id())
        {
            $user = Auth::user();
            $userId = $user->id;
            $order = order::where('user_id','=',$userId)->get();
            return view('home.order',compact('order'));
        }
        else
        {
            return redirect('login');
        }
    }

    public function cancel_order($id)
    {
        $order = order::find($id);
        $order->delivery_status = 'order canceled';
        $order->save();
        return redirect()->back();
    }

    public function add_comment(Request $request)
    {
        if(Auth::id())
        {
            $comment = new comment;
            $comment->name = Auth::user()->name;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;
            $comment->save();
            return redirect()->back();
        }
        else
        {
            return redirect('login');
        }
    }

    public function add_reply(Request $request)
    {
        if(Auth::id())
        {
            $reply = new reply;
            $reply->name = Auth::user()->name;
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;
            $reply->save();
            return redirect()->back();
        }
        else
        {
            return redirect('login');
        }
    }

    public function show_products()
    {
        $product = product::all();
        return view('home.showProducts',compact('product'));
    }

    public function search_products_user(Request $request)
    {
        $searchText = $request->search;
        $product = product::where('title','LIKE',"%$searchText%")->orWhere('catagory','LIKE',"%$searchText%")->get();
        return view('home.showProducts',compact('product'));
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function blog()
    {
        return view('home.blog');
    }

    public function contact_us(Request $request)
    {
        $contact = new contact;
        $contact->user_id = Auth::user()->id;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->body = $request->body;
        $contact->save();
        return redirect()->back()->with('message','Message Sent Successfully');
    }
}
