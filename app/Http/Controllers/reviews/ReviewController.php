<?php

namespace App\Http\Controllers\reviews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Validator;
class ReviewController extends Controller
{
    use GeneralTrait;
    public function index()
    {
       try{
           $msg='all reviews are Right Here';
           $data=Review::with('user','product')->get();
           return $this->successResponse($data,$msg);
       }
       catch (\Exception $ex){
           return $this->errorResponse($ex->getMessage(),500);
       }
    }

    public function store(Request $request)
    {
                $user_id=Auth::id();
              $user=User::find($user_id);
              foreach($user->orders as $order)
              {
                $products= $order->products;
                foreach($products as $product)
                {
                    $prod_ids[]=$product->id;
                }
              }
              
              
            
             

            $validator=Validator::make($request->all(),[
            'product_id'=>'required|numeric',
            'stars'=>'required|numeric',
            'comment'=>'regex:/[a-zA-Z\s]+/'

            ]
        );
                if($validator->fails()){
            return $this->errorResponse($validator->errors(),422);
        }
        if(!in_array($request['product_id'],$prod_ids))
        return $this->errorResponse('you did not buy this product',422);
      try {
         
        $request->merge(['user_id' => $user_id]);    
        $review=Review::create($request->all());
        
           $data=$review;
           $msg='review is created successfully';
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
            $data=Review::find($id);
            if(!$data)
                return $this->errorResponse('No review with such id',404);

            $data->update($request->all());
            $data->save();
            $msg='The review is updated successfully';
            return $this->successResponse($data,$msg);
         
        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }
    }
   
}
