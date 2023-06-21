<?php

namespace App\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use GeneralTrait;
    public function index()
    {
       try{
           $msg='all orders are Right Here';
           $data=Order::with('products')->get();
           return $this->successResponse($data,$msg);
       }
       catch (\Exception $ex){
           return $this->errorResponse($ex->getMessage(),500);
       }
    }

    public function store(Request $request)
    {

      try {
            $order=Order::create(['user_id'=>auth()->user()->id]);
            $products=$request['product_id'];
            $quantities=$request['quantity'];
            for($i=0;$i<count($products);$i++)
            {
                $order->products()->attach($products[$i],['quantity' => $quantities[$i]]);
            }
            $data=$order;
            $msg='order is created successfully';
            return $this->successResponse($data,$msg,201);
          }

        catch (\Exception $ex)
        {
            return $this->errorResponse($ex->getMessage(),500);
        }
    }
    public function update(Request $request, $id)
    {

        try{
            $order=Order::with('products')->find($id);
            if(!$order)
               return $this->errorResponse('No order with such id',404);
            $products=$request['product_id'];
            $quantities=$request['quantity'];
            for($i=0;$i<count($products);$i++)
                {
                    $order->products()->sync($products[$i],['quantity' => $quantities[$i]]);
                }
            $data=$order;
            $msg='order is updated successfully';
            return $this->successResponse($data,$msg,202);    
        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }
    
    }

    public function show($id)
    {

        try{
            $order=Order::with('products')->find($id);
            if(!$order)
                return $this->errorResponse('No order with such id',404);


            $msg='Got you the order you are looking for';
            $data=$order;
            return $this->successResponse($data,$msg);
        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }
    }

    public function destroy($id)
    {
        try{
            $order=Order::find($id);
            if(!$order)
                return $this->errorResponse('No Order with such id',404);
            $order->products()->detach();
             $order->delete();
            $msg='The order is deleted successfully';
            return $this->successResponse($order,$msg);
        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }
    }

}
