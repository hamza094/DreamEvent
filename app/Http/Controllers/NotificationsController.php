<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class NotificationsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index()
    {
        return auth()->user()->unreadNotifications;

    }
    
    public function destroy(User $user,$notificationId){
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        return json_encode(
            $notification->data
        );
    }
    
}
