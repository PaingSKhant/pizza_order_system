<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //product list
    public function list(){

        $pizzas = Product::select('products.*','categories.name as category_name')
            ->when(request('key'),function($query){
            $query->where('products.name', 'like' , '%'.request('key').'%');
        })
            ->leftJoin('categories','products.category_id','categories.id')
            ->orderBy('products.created_at','desc')
            ->paginate(3);
        $pizzas->appends(request()->all());
        return view('admin.product.pizzaList' , compact('pizzas'));
    }

    //direct pizza create page
    public function createPage(){
        $categories = Category::select('id','name')->get();
        return view('Admin.product.create',compact('categories'));
    }

    //delete product
    public function delete($id){
        Product::where('id',$id)->delete();
        return redirect()->route('product#list')->with(['deleteSuccess'=>'Product Delete Success...']);
    }

    //edit product
    public function edit($id){
        $pizza = Product::select('products.*','categories.name as category_name')
                ->leftJoin('categories','products.category_id','categories.id')
                ->where('products.id',$id)->first();
        return view('Admin.product.edit',compact('pizza'));
    }

    //update pizza
    public function updatePage($id){
        $pizza = Product::where('id',$id)->first();
        $category = Category::get();
        return view('Admin.product.update',compact('pizza' ,'category'));
    }

    //create product
    public function create(Request $request){
        $this->productValidationCheck($request, "create");
        $data = $this->requestProductInfo($request);
        $fileName = uniqid() .$request->file('pizzaImage')->getClientOriginalName();

        // dd($fileName);
        $request->file('pizzaImage')->storeAs('public',$fileName);
        $data['image'] = $fileName;
        Product::create($data);
        return redirect()->route('product#list');
    }

    //update product
    public function update(Request $request){
        $this->productValidationCheck($request, "update");
        $data = $this->requestProductInfo($request);


        if($request->hasFile('Image')){
            $oldImageName =Product::where('id' , $request->pizzaId)->first();
            $oldImageName = $oldImageName->image;

            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }

            $fileName = uniqid().$request->file('Image')->getClientOriginalName();
            $request->file('Image')->storeAs('public',$fileName);
            $data['image']= $fileName;
        }

        Product::where('id',$request->pizzaId)->update($data);
        return redirect()->route('product#list');


      }


    //request product info
    private function requestProductInfo($request){

        return [
            'category_id' => $request->pizzaCategory ,
            'name' => $request->pizzaName ,
            'description' => $request->pizzaDescription ,
            'waiting_time' => $request->waitingTime ,
            'price' => $request->pizzaPrice,
        ];
    }


    //product validation check
    private function productValidationCheck($request, $action){

        $validationRules = [
            'pizzaName' => 'required|min:5|unique:products,name,'.$request->pizzaId ,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required|min:10',
            'pizzaPrice' => 'required',
            'waitingTime' => 'required',
        ];

        $validationRules['pizzaImage'] = $action == "create" ? 'required|mimes:jpg,jpeg,png,file,webp': 'mimes:jpg,jpeg,png,file,webp';
        // dd($validationRules);

        Validator::make($request->all(),$validationRules)->validate();
    }
}
