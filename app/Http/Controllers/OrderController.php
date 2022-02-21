<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\MagicConst\Dir;

class OrderController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $dishes = Dish::orderBy('id', 'desc')->get();
        $tables = Table::all();
        $status = array_flip(config('res.order_status'));
        $orders = Order::where('status', 4)->get();
        return view('order_form', ["dishes" => $dishes, "tables" => $tables, 'orders'=>$orders, 'status'=>$status]);
    }
    public function search(Request $request)
    {
        $dishes = Dish::where('name','LIKE','%'.$request->search.'%')->get();
        $tables = Table::all();
        $status = array_flip(config('res.order_status'));
        $orders = Order::where('status', 4)->get();
        return view('order_form', ["dishes" => $dishes, "tables" => $tables, 'orders'=>$orders, 'status'=>$status]);
    }
    public function submit(Request $request)
    {
        $data = array_filter($request->except('_token','table_id'));
        $order_id = rand(100, 500);

        foreach ($data as $id => $qty) {
            if ($qty > 1) {
                for ($i = 0; $i <= $qty; $i++) {
                    $this->saveOrder($order_id, $id, $request->table_id);
                }
            } else {
                $this->saveOrder($order_id, $id, $request->table_id);
            }
        }

        return redirect('/')->with('message', 'Order Submitted');
    }
    public function saveOrder($order_id, $dish_id, $table_id)
    {
        $order = new Order;
        $order->order_id = $order_id;
        $order->dish_id = $dish_id;
        $order->table_id = $table_id;
        $order->status = config('res.order_status.new');

        $order->save();
    }
    public function orderList()
    {
        $status = array_flip(config('res.order_status'));
        $orders = Order::where('status', 4)->get();
        return view('order_list', ['orders'=>$orders, 'status'=>$status]);
    }
}
