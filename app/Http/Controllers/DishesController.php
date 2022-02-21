<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishCreateRequest;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Http;

class DishesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishes = Dish::all();
        return view('kitchen.dish', ["dishes" => $dishes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('kitchen.dish_create', ["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DishCreateRequest $request)
    {
        $dish = new Dish();
        $dish->name = $request->name;
        $dish->category_id = $request->category_id;

        $imageName = date('YmdHis') . "." . request()->dish_image->getClientOriginalExtension();
        request()->dish_image->move(public_path('images'), $imageName);

        $dish->image = $imageName;
        $dish->save();
        return redirect('dish')->with('message', 'Dish created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        $categories = Category::all();
        return view("kitchen.dish_edit", ["dish" => $dish, "categories" => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        request()->validate([
            "name" => 'required',
            "category_id" => 'required',
        ]);
        $dish->name = $request->name;
        $dish->category_id = $request->category_id;

        if ($request->dish_image) {
            $imageName = date('YmdHis') . "." . request()->dish_image->getClientOriginalExtension();
            request()->dish_image->move(public_path('images'), $imageName);
            $dish->image = $imageName;
        }

        $dish->save();
        return redirect('dish')->with('message', 'Dish updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return redirect('dish')->with('message', 'Dish removed succesfully');
    }

    public function order()
    {
        $status = array_flip(config('res.order_status'));
        $orders = Order::whereIn('status',[1,2])->get();
        return view('kitchen.order', ['orders'=>$orders, 'status'=>$status]);
    }

    public function approve(Order $order)
    {
        $order->status = config("res.order_status.processing");
        $order->save();
        return redirect('order')->with('message', 'Order Approve');
    }

    public function ready(Order $order)
    {
        $order->status = config("res.order_status.ready");
        $order->save();
        return redirect('order')->with('message', 'Order Ready');
    }

    public function serve(Order $order)
    {
        $order->status = config("res.order_status.done");
        $order->save();
        return redirect('/')->with('message', 'Order Serve');
    }

    public function cancel(Order $order)
    {
        $order->status = config("res.order_status.cancel");
        $order->save();
        return redirect('order')->with('message', 'Order Cancel');
    }
}
