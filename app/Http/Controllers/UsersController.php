<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UsersController extends Controller
{
    
    public function index()
    {
         return User::latest()->paginate(30); 
        
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
    
}
