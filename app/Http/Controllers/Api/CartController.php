<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id){
        $product = DB::table('products')->where('id', $id)->first();
        
        $check = DB::table('pos')->where('product_id', $id)->first();
        if ($check) {
            DB::table('pos')->where('product_id', $id)->increment('product_quantity');
            $product = DB::table('pos')->where('product_id', $id)->first();
            $sub_total = $product->product_quantity * $product->product_price;
            DB::table('pos')->where('product_id', $id)->update(['sub_total' => $sub_total]);
            return response($product->sub_total);
            
        } else{
            $data = array();
            $data['product_id'] = $id;
            $data['product_name'] = $product->product_name;
            $data['product_quantity'] = 1;
            $data['product_price'] = $product->selling_price;
            $data['sub_total'] = $product->selling_price;
            
            DB::table('pos')->insert($data);
            return response('done');
        }
    }

    public function CartProduct(){
        $cart = DB::table('pos')->get();
        return response()->json($cart);
    }

    public function CartRemove($id){
        DB::table('pos')->where('id', $id)->delete();
        return response('done');
    }

    public function CartIncrement($id){
        DB::table('pos')->where('id', $id)->increment('product_quantity');
        $product = DB::table('pos')->where('id', $id)->first();
        $sub_total = $product->product_quantity * $product->product_price;
        DB::table('pos')->where('id', $id)->update(['sub_total' => $sub_total]);
        return response('done');
    }

    public function CartDecrement($id){
        DB::table('pos')->where('id', $id)->decrement('product_quantity');
        $product = DB::table('pos')->where('id', $id)->first();
        $sub_total = $product->product_quantity * $product->product_price;
        DB::table('pos')->where('id', $id)->update(['sub_total' => $sub_total]);
        return response('done');
    }

    public function Vat(){
        $vat = DB::table('extra')->first();
        return response()->json($vat);
    }
}
