<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Validator;

class UsersController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth',[
            'only'=>[
                'show','avatar'
            ]
        ]);   
    }
        
    public function index()
    {
         return User::latest()->paginate(30); 
        
    }
    
    public function show($user){
        $user=User::findOrFail($user);
        return view('profile.show',compact('user'));
    }
    
    public function destroy($id)
    {
          $users = User::findOrFail($id);
           $users->delete();
    }
    
    public function search(){
             if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
            })->paginate(30);
        }else{
            $users = User::latest()->paginate(30);
        }
        return $users;
    }
    
    public function update(Request $request,$user){
        
        
        $user=User::findOrFail($user);
        $this->authorize($user);
        $user->update($this->validateRequest());
        $user->name = Request::input('name');
        $user->email = Request::input('email');
        $user->prof = Request::input('prof');
        $user->backimg = Request::input('backimg');
        $user->about = Request::input('about');
        if ( ! Request::input('password') == '')
    {
        $user->password = Hash::make(Request::input('password'));
    }
        
   $user->save();
    }
    
  
    
       protected function validateRequest(){
        return request()->validate([
        'name'=>'required|min:6',
        'email'=>'required',
        //'prof'=>'required',
        'backimg'=>'required',
        //'about'=>'required'    
    ]);
        
    }
    
    public function avatar()
    {
         $this->validate(request(), [
            'avatar'=>'required|image'
        ]);
         auth()->user()->update([
            'avatar_path'=>request()->file('avatar')->store('avatars', 'public')
        ]);
        
         return response([], 204);
    }
    
}