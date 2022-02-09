<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DateTime;
use Nette\Utils\Json;

class PosController extends Controller
{
    public function GetProduct($id){
        $product = DB::table('products')->where('catagory_id', $id)->get();
        return response()->json($product);
    }

    public function OrderDone(Request $request){
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'payby' => 'required',
        ]);

        $data = array();
        $data['customer_id'] = $request->customer_id;
        $data['total_quantity'] = $request->qty;
        $data['sub_total'] = $request->sub_total;
        $data['vat'] = $request->vat;
        $data['total'] = $request->total;
        $data['pay'] = $request->pay;
        $data['due'] = $request->due;
        $data['payby'] = $request->payby;
        $data['order_date'] = date('d/m/Y');
        $data['order_month'] = date('F');
        $data['order_year'] = date('Y');
        $order_id = DB::table('orders')->insertGetId($data);

        $contents = DB::table('pos')->get();
        $order_details_data = array();
        foreach ($contents as $key => $content) {
            $order_details_data['order_id'] = $order_id;
            $order_details_data['product_id'] = $content->product_id;
            $order_details_data['product_quantity'] = $content->product_quantity;
            $order_details_data['product_price'] = $content->product_price;
            $order_details_data['sub_total'] = $content->sub_total;
            DB::table('order_details')->insert($order_details_data);

            DB::table('products')->where('id', $content->product_id)
                                ->update(['product_quantity' => DB::raw('product_quantity - ' .$content->product_quantity)]);
        }
        DB::table('pos')->delete();
        return response('Done');
    }

    public function SearchOrderDate(Request $request){
        $orderDate = $request->date;
        $new_date = new DateTime($orderDate);
        $done = $new_date->format('d/m/Y');

        $order = DB::table('orders')
                    ->join('customers','orders.customer_id','customers.id')
                    ->select('customers.name','orders.*')
                    ->where('orders.order_date',$done)
                    ->get();
        return response()->json($order);
    }

    public function TodaySell(){
        $date = date('d/m/Y');
        $sell = DB::table('orders')
                    ->where('order_date',$date)
                    ->sum('total');
        return response()->json($sell);
    }

    public function TodayIncome(){
        $date = date('d/m/Y');
        $income = DB::table('orders')
                    ->where('order_date',$date)
                    ->sum('pay');
        return response()->json($income);
    }

    public function TodayDue(){
        $date = date('d/m/Y');
        $income = DB::table('orders')
                    ->where('order_date',$date)
                    ->sum('due');
        return response()->json($income);
    }

    public function TodayExpense(){
        $date = date('d/m/Y');
        $income = DB::table('expenses')
                    ->where('expense_date',$date)
                    ->sum('amount');
        return response()->json($income);
    }

    public function StockOut(){
        $products = DB::table('products')
                    ->where('product_quantity','<','1')
                    ->get();
        return response()->json($products);
    }
}
