<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct category page
    public function list(){
        $categories =  Category::when(request('key'),
        function($query){
        $query->where('name','like','%'. request('key').'%');
        })
        ->orderBy('id','desc')
        ->paginate(5);
        return view('admin.category.list',compact('categories'));
    }

    //direct create page
    public function createPage(){
        return view('admin.category.create');

    }

    //create category
    public function create(Request $request){
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list')->with(['categorySuccess'=>'Category Created...']);
    }

    //delete category
    public function delete($id){
        Category::where('id',$id)->delete();
        return back()->with(['categoryDelete'=>'Delete Success...']);

    }

    //edit category
    public function edit($id){
        $category = Category::where('id',$id)->first();
        return view('Admin.category.edit',compact('category'));
    }

    //update Category
    public function update($id , Request $request){

        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::where('id',$id)->update($data);
        return redirect()->route('category#list');

    }

    //category validation check
    private function categoryValidationCheck($request){
        Validator::make($request->all(),[
            'categoryName' => 'required|unique:categories,name,' .$request->categoryId
        ])->validate();
    }

    // request category data
    private function requestCategoryData($request){
        return [
            'name'=> $request->categoryName
        ];
    }
}
