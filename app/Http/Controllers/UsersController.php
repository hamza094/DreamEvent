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
}
