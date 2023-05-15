<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    //user home page
    public function home(){
        $pizza = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    //change password page
    public function changePasswordPage(){
        return view('user.password.change');
    }

    //change password
    public function changePassword(Request $request){

        $this->passwordValidationCheck($request);

        $currentUserId = Auth::user()->id;

        $user = User::select('password')->where('id', $currentUserId)->first();
        $dbPassword =$user->password;//hash value

        if(Hash::check($request->oldPassword,$dbPassword)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);

            // Auth::logout();
            // return redirect()->route('auth#loginPage');

            return back()->with(['changeSuccess'=>'Password Changed...']);


        }
        return back()->with(['notMatch' => 'The Old Password Not Match.Try Again!']) ;

    }

    // account change Page
    public function accountChangePage(){
        return view('user.profile.account');
    }

    //update profile
    public function accountChange($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);


        //for image
        if($request->hasFile('image')){

            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/' . $dbImage);
            }


            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public' , $fileName);
            $data['image'] = $fileName;
        }



        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess' => 'User Account Updated...']);
    }

    //filter pizza
    public function filter($categoryId){

        $pizza = Product::where('category_id',$categoryId )->orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();

        return view('user.main.home',compact('pizza','category','cart','history'));

    }

    //cart list
    public function cartList(){
        $cartList =  Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as pizza_image ')
                    ->leftJoin('products','products.id','carts.product_id')
                    ->where('user_id',Auth::user()->id)
                    ->get();
                    // dd($cartList->toArray());



        $totalPrice = 0;
         foreach($cartList as $c){
            $totalPrice += $c->pizza_price * $c->qty;
         }
        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    //pizza details
    public function pizzaDetails($pizzaId){
        $pizza = Product::where('id',$pizzaId)->first();

        return view('user.main.detail',compact('pizza'));
    }

    //history
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate('6');
        return view('user.main.history',compact('order'));
    }


     //direct user list
     public function userList(){
        $users = User::where('role','user')->paginate(3);
        return view("Admin.user.list",compact('users'));
    }

    //change user role
    public function userChangeRole(Request $request){
        logger($request->all());
        $updateSource = [
            'role' => $request->role
        ];

        User::where('id',$request->userId)->update($updateSource);

    }

    //contact section
    public function contactPage(){
        return view('user.contact.userContact');
    }

    //contact
    public function contact(Request $request){
        $data = $this->getMessage($request);
        Contact::create($data);
         $this->contactValidationCheck($request);
        return redirect()->route('user#contactPage');
    }

    // contact list
    public function userContactListPage(){
        $message = Contact::paginate(5);
        return view("Admin.contact.messageList",compact('message'));
    }

    //message delete
    public function deleteMessage($id){
       Contact::where('id',$id)->delete();
       return back();

    }



    //request user data
    private function getUserData($request){
        return [
            'name' => $request-> name,
            'email' => $request-> email,
            'phone' => $request-> phone,
            'gender' => $request-> gender,
            'address' => $request-> address,
            'updated_at' => Carbon::now()
        ];
    }



     //account validation check
     private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required' ,
            'email' => 'required' ,
            'phone' => 'required' ,
            'image' => 'mimes:png,jpg,jpeg| file',
            'gender' => 'required',
            'address' => 'required'
        ])->validate();
    }

    //password Validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' =>'required | min:6 | max:10' ,
            'newPassword' =>'required | min:6 | max:10'  ,
            'confirmPassword' =>'required |min:6  | max:10| same:newPassword'
        ])->validate();
    }

    //contact validation check
    private function contactValidationCheck($request){
        Validator::make($request->all(),[
            'userName' => 'required' ,
            'userEmail' => 'required' ,
            'userMessage' => 'required'
        ])->validate();
    }

    //get message data
    private function getMessage($request){
        return[
            'name' => $request-> userName ,
            'email' => $request-> userEmail ,
            'message' => $request-> userMessage
        ];
    }


}
