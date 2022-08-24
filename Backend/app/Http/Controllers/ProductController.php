<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    function addproduct(Request $req)
    {
        $product = new Product();
        $product -> title=$req->input('title');
        $product -> price=$req->input('price');
        $product -> discount_price=$req->input('discount_price');
        $product -> description=$req->input('description');
        $product -> catagory=$req->input('catagory');
        $product -> quantity=$req->input('quantity');
        $product -> file_path=$req->file('file')->store('products');
        $product -> save();
        return $product;
    }
}
