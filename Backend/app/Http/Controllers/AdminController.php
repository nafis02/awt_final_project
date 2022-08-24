<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Catagory;

use App\Models\Product;

use App\Models\Order;

use PDF;

use Notification;

use App\Notifications\SendEmailNotification;

class AdminController extends Controller
{
   public function view_catagory()
   {
    $data=catagory::all();

    //return view('admin.catagory',compact('data'));
    return response()->json($data);
   }

   public function add_catagory(Request $request)
   {
     $data=new catagory;

     $data->catagory_name=$request->catagory;

     $data->save();

     //return redirect()->back()->with('message','Catagory Added Successfully');
     return "Catagory Added Successfully";
   }
   public function delete_catagory($id)
   {
    
    $data=catagory::find($id);

    $data->delete();

    //return redirect()->back()->with('message','Catagory Deleted Successfully');
    return "Catagory Deleted Successfully";

   }

   public function view_product()
   {
    $catagory=catagory::all();
    //return view('admin.product',compact('catagory'));
    return response()->json($catagory);
   }

   public function add_product(Request $request)
   {

    $product=new product;

    $product->title=$request->title;

    $product->description=$request->description;

    $product->price=$request->price;

    $product->quantity=$request->quantity;

    $product->discount_price=$request->discount_price;

    $product->catagory=$request->catagory;

    //$product->image=$request->file('file')->store('products');

    $product->image="";

    $product->save();

    return $product;


    //return redirect()->back()->with('message','Product Added Successfully');
    
    //return "Product Added Successfully";

   }

   public function show_product()
   {
    $product=product::all();
    //return view('admin.show_product',compact('product'));
    return response()->json($product);
   }
   public function delete_product($id)
   {

      $product=product::find($id);

      $product->delete();

      //return redirect()->back();
      return "Product Deleted Successfully";

   }
   
   public function update_product($id)

   {

      $product=product::find($id);

      $catagory=catagory::all();

      //return view('admin.update_product',compact('product','catagory'));
      return response()->json($product);

   }

   public function update_product_confirm(Request $request,$id)

   {

      $product=product::find($id);

      $product->title=$request->title;

      $product->description=$request->description;

      $product->price=$request->price;

      $product->discount_price=$request->dis_price;

      $product->catagory=$request->catagory;

      $product->quantity=$request->quantity;

      $image=$request->image;

      $imagename=time().'.'.$image->getClientOriginalExtension();

      $request->image->move('product',$imagename);

      $product->image=$imagename;

      $product->save();

      return "Product Updated Successfully";



   }

   public function order()
   {
      $order=order::aLL();
      //return view('admin.order', compact('order'));
      return response()->json($order);
   }

   public function delivered($id)
   {
      $order=order::find($id);
      $order->delivery_status="delivered";
      $order->payment_status="paid";

      $order->save();
      //return redirect()->back();
      return response()->json($order);
   }

   public function print_pdf($id)
   {
      $order=order::find($id);
      $pdf=PDF::loadView('admin.pdf',compact('order'));
      //return $pdf->download("order_details.pdf");
      return response()->json($pdf);

   }

   public function searchdata(Request $request)
   {
      $searchText=$request->search;
      $order=order::where('name','LIKE',"%$searchText%")->orWhere('phone','LIKE',"%$searchText%")->orWhere('product_title','LIKE',"%$searchText%")->get();
      //return view('admin.order',compact('order'));
      return response()->json($order);
   }

   public function send_email($id)
   {
      $order=order::find($id);

      //return view('admin.email_info',compact('order'));
      return response()->json($order);
   }

   public function send_user_email(Request $request , $id)
   {

      $order=order::find($id);

      $details = [

         'greeting'=>$request->greeting,

         'firstline'=>$request->firstline,

         'body'=>$request->body,

         'button'=>$request->button,

         'url'=>$request->url,

         'lastline'=>$request->lastline,


      ];

      Notification::send($order,new SendEmailNotification($details));

   }

}
