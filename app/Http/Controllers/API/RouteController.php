<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class routeController extends Controller
{
    //product api
    public function productList(){
        $products = Product::get();

        $users = User::get();

        $data = [
            'product' => $products ,
            'user' => $users
        ];

        return response()->json($data, 200);
    }

    // category api
    public function categoryList(){
        $categories = Category::get();
        return response()->json($categories, 200);
    }

    //create category with api
    public function categoryCreate(Request $request){
        $data = [
            'name' => $request->name ,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $response = Category::create($data);

        return response()->json($response, 200);

    }

    //create contact with api
    public function contactCreate(Request $request){
       $data = $this->getContactData($request);
      Contact::create($data);

      $contact=Contact::get();
      return response()->json($contact, 200);

    }

    //delete category with api
    public function categoryDelete(Request $request){
       $data = Category::where('id',$request->category_id)->first();
       if(isset($data)){
        Category::where('id',$request->category_id)->delete();
        return response()->json(['Status'=>true,'message'=>"Delete Success",'Delete Data'=>$data], 200);
       }
       return response()->json(['Status'=>false,'message'=>"There is no category id"], 200);
    }


    // category detail with api
    public function categoryDetail(Request $request){
            $data = Category::where('id',$request->category_id)->first();
            if(isset($data)){
                return response()->json(['Status'=>true,'category'=>$data], 200);
            }

            return response()->json(['Status'=>false, 'category'=>"Therer is no category ..."], 404,);
    }

    //category update with api
    public function categoryUpdate(Request $request){
       $categoryId = $request->category_id;
       $dbSource = Category::where('id',$categoryId)->first();
       if(isset( $dbSource)){
            $data = $this->getCategoryData($request);
            $response = Category::where('id',$categoryId)->update($data);
            return response()->json(['status'=>true,'message'=>'update category success..','category'=>$response], 200);
       }
        return response()->json(['status'=>false,'message'=>'there is no category...'], 404);
    }


    private function getContactData($request){
        return [
            'name'=> $request->name ,
            'email' => $request->email ,
            'message' => $request->message ,
            'created_at' => Carbon::now(),
            'updated_at'=> Carbon::now()
        ];
    }

    private function getCategoryData( $request){
        return [
            'name'=>$request->category_name,
            'updated_at'=>Carbon::now()
        ];
    }
}
