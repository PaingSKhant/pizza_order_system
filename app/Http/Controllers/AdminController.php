<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
     //change password page
     public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //change password
    public function changePassword(Request $request){
        /*
            1. all field must be fill
            2. new password & confirm password length must be greater than 6
            3. new password & confirm password must same
            4. client old password must be same with dataBase password
            5. password change
        */

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

    //admin list
    public function list(){
        $admin = User::when(request('key'),function($query){
                    $query  ->orWhere('name','like','%'.request('key').'%')
                            ->orWhere('email','like','%'.request('key').'%')
                            ->orWhere('gender','like','%'.request('key').'%')
                            ->orWhere('phone','like','%'.request('key').'%')
                            ->orWhere('address','like','%'.request('key').'%');
        })
                ->where('role','admin')->paginate(3);
        $admin ->appends(request()->all());
        return view('Admin.account.list',compact('admin'));
    }
    //admin delete
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Admin Account Deleted...']);
    }

    //admin profile
    public function details(){
        return view('Admin.account.details');
    }

    //change role
    public function changeRole($id){
        $account = User::where('id',$id)->first();
        return view('Admin.account.changRole',compact('account'));
    }

    //change
    public function change($id,Request $request){
        $data = $this->requestUserData($request);
        User::where('id',$id)->update($data);
        return redirect()->route('admin#list');
    }

    //edit profile
    public function edit(){
        return view('admin.account.edit');
    }

    //update profile
    public function update($id,Request $request){
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
        return redirect()->route('admin#details')->with(['updateSuccess' => 'Admin Account Updated...']);
    }

    //request user data
    private function requestUserData($request){
        return[
            'role'=> $request->role
        ];
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
}
