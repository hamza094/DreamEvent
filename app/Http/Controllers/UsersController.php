<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Validator;
use Storage;
use File;
use Image;
use App\Event;

class UsersController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth',[
            'only'=>[
                'show','avatar','myevents'
            ]
        ]);   
    }
        
    public function index()
    {
         return User::latest()->paginate(30); 
        
    }
    
    public function show($user){
                $events=Event::orderBy('created_at','desc')->paginate(8);

        $user=User::findOrFail($user);
        return view('profile.show',compact('user','events'));
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
    
    public function update(Request $request,$user)
    {
        
        
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
    
    public function avatar(Request $request)
    {
        $this->validate(request(), [
            'avatar'=>['required', 'image']
        ]);
        
    $user = Auth::user();
    $file = $request->file('avatar');
    $filename=uniqid($user->id."_").".".$file->getClientOriginalExtension();  
    Storage::disk('s3')->put($filename,File::get($file),'public');
    $user_path=Storage::disk('s3')->url($filename);
    $user->update(['avatar_path'=>$user_path]);
    
    $thumb=Image::make($file);
    $thumb->fit(500);
    $jpg=(string) $thumb->encode('jpg');
        
    $thumbName=pathinfo($filename,PATHINFO_FILENAME).'-thumb.jpg';
    Storage::disk('s3')->put($thumbName,$jpg,'public');    
        
         return response([], 204);
    }
    
    public function myevents(){
         $events=auth()->user()->events;
        if(request('drafted')) {
            $events=auth()->user()->events()->onlyTrashed()->get();
        }
        return view('profile.events',compact('events'));
    }
    
}