<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Models\Product;

use App\Models\Order;

use App\Models\Cart;

use App\Models\Comment;

use App\Models\Reply;

use Session;

use Stripe;


class HomeController extends Controller
{

    public function index()
    {
        $product=Product::paginate(6);
        $comment=comment::orderby('id','desc')->get();
        $reply=reply::all();
        return view('home.userpage', compact('product','comment','reply'));
    }

    public function redirect()
    {

        $usertype=Auth::user()->usertype;

        if($usertype=='1')
        {
            return msg("Admin Home");
            //return view('admin.home');
        }
        else
        {
            $product=Product::paginate(6);

            $comment=comment::orderby('id','desc')->get();

            $reply=reply::all();

            //return view('home.userpage', compact('product','comment','reply'));

            return Product::all();

            //return comment::all();

            //return reply::all();
        }
    }

    public function product_details($id)
    {
        $product=product::find($id);
        //return view('home.product_details',compact('product'));
        return product::find($id);
    }

    public function add_cart(Request $request, $id)

    {
        if(Auth::id())
        {
            $user=Auth::user();

            $product=product::find($id);

            $cart=new cart;

            $cart->name= $user->name;

            $cart->email= $user->email;

            $cart->phone= $user->phone;

            $cart->address= $user->address;

            $cart->user_id= $user->id;

            $cart->Product_title= $product->title;

            if($product->discount_price!=null)
            {
                $cart->price= $product->discount_price * $request->quantity;
            }
           else
           {
            $cart->price= $product->price * $request->quantity;
        }

            $cart->image= $product->image;

            $cart->Product_id= $product->id;

            
            $cart->quantity=$request->quantity;


            $cart->save();

            return "Add to Cart Successfully";
        }

        else
        {
            return "You Have to Login First";
        }
    }


    public function show_cart()
    {
        if(Auth::id())
        {
            $id=Auth::user()->id;

        $cart=cart::where('user_id', '=', $id)->get();
        return view ('home',compact('cart'));
        //return response()->json($cart);
        }

        else
        {
            return "You Have to Login First";
        }
        
    }

    public function remove_cart($id)
    {
        $cart=cart::find($id);
        $cart->delete();
        return "msg";
    }

    public function cash_order()
    {
        $user=Auth::user();

        $userid=$user->id;

        $data=cart::where('user_id','=', $userid)->get();

        foreach($data as $data)
        {
            $order=new order;

            $order->name=$data->name;

            $order->email=$data->email;

            $order->phone=$data->phone;

            $order->address=$data->address;

            $order->user_id=$data->user_id;


            $order->product_title=$data->product_title;


            $order->price=$data->price;


            $order->quantity=$data->quantity;


            $order->image=$data->image;

            $order->product_id=$data->Product_id;

            $order->payment_status='cash on delivery';

            $order->delivery_status='processing';

            $order->save();

            $cart_id=$data->id;

            $cart=cart::find($cart_id);

            $cart->delete();
        }
        return "Order Recevied";
    }

    public function show_order()
    {

        if(Auth::id())
        {
            $user= Auth::user();

            $userid=$user->id;

            $order=order::where('user_id','=',$userid)->get();

            //return view('home.order',compact('order'));

            return order::all();
        }
        else
        {
            return "msg";
        }

    }

    public function cancel_order($id)
    {

        $order=order::find($id);

        $order->delivery_status='Order Cancel';

        $order->save();

        return "msg";

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

            return "Comment added";

        }
        else
        {
            return "Must be login first";
        }

    }

    public function add_reply(Request $request)
    {

        if(Auth::id())
        {

            $reply=new reply;

            $reply->name=Auth::user()->name;

            $reply->user_id=Auth::user()->id;

            $reply->comment_id=$request->commentId;

            $reply->reply=$request->reply;

            $reply->save();

            return "Reply added";

        }
        else
        {
            return "msg";
        }

    }

    public function product_search(Request $request)
    {

        if($request)

        $comment=comment::orderby('id','desc')->get();

        $reply=reply::all();

        $search_text=$request->search;

        $products=product::where('title','LIKE',"%$search_text%")->orWhere('catagory','LIKE',"$search_text")->paginate(6);

        // return $product;

        //return view('home.userpage',compact('product','comment','reply'));

        return response()->json($products);


    }

}

