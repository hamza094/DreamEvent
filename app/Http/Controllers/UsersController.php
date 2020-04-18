<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use Storage;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only'=>[
                'show', 'avatar', 'myevents'
            ]
        ]);
    }

    public function index()
    {
        return User::orderBy('id', 'asc')->with('events')->paginate(15);
    }

    public function show($user)
    {
        $events = Event::orderBy('created_at', 'desc')->paginate(8);

        $user = User::findOrFail($user);

        return view('profile.show', compact('user', 'events'));
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
    }

    public function search()
    {
        if ($search = \Request::get('q')) {
            $users = User::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%");
            })->paginate(15);
        } else {
            $users = User::orderBy('id', 'asc')->paginate(15);
        }

        return $users;
    }

    public function update(Request $request, $user)
    {
        $user = User::findOrFail($user);
        $this->authorize($user);
        $user->update($this->validateRequest());
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->prof = $request->input('prof');
        $user->backimg = $request->input('backimg');
        $user->about = $request->input('about');
        if (! $request->input('password') == '') {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();
    }

    protected function validateRequest()
    {
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
        $filename = uniqid($user->id.'_').'.'.$file->getClientOriginalExtension();
        Storage::disk('s3')->put($filename, File::get($file), 'public');
        //Store Profile Image in s3
        $user_path = Storage::disk('s3')->url($filename);
        $user->update(['avatar_path'=>$user_path]);

        //Resize User Image
        $thumb = Image::make($file);
        $thumb->fit(500);
        $jpg = (string) $thumb->encode('jpg');

        //Save resize image in s3
        $thumbName = pathinfo($filename, PATHINFO_FILENAME).'-thumb.jpg';
        Storage::disk('s3')->put($thumbName, $jpg, 'public');

        return response([], 204);
    }

    public function myevents()
    {
        $events = auth()->user()->events;
        if (request('drafted')) {
            $events = auth()->user()->events()->onlyTrashed()->get();
        }

        return view('profile.events', compact('events'));
    }
}
