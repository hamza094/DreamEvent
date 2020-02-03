<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar_path'
    ];
    
    protected $appends = ['isAdmin','profile'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function me($user){
        return $this->id === $user->id;
    }
    
    public function accounts(){
        return $this->hasMany('App\SocialAccount');
    }
    public function events(){
        return $this->hasMany(Event::class);
    }
    public function replies(){
        return $this->hasMany(Reply::class);
    }
    public function tickets(){
        return $this->hasMany(PurchaseTicket::class);
    }
    
    public function ticket(){
    return $this->belongsTo(PurchaseTicket::class);
    }

    public function discussionreplies(){
        return $this->hasMany(DiscussionReply::class);
    }
     public function followers(){
        return $this->hasMany(Follow::class);
    }
    
    
     public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }
    
      public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->events->each->forceDelete();
        });
    }
    
    //User avatar path
   public function getProfileAttribute()
   {
       if($this->avatar_path!=null){
        $path=pathinfo($this->avatar_path);
        return $path['dirname'].'/'.$path['filename']."-thumb.jpg";    
       }else{
           $path="https://i.pinimg.com/originals/53/54/f7/5354f750a2816333f42efbeeacb4e244.jpg";
           return $path;
       }
         
   }
    
      public function isAdmin()
    {
        return in_array($this->email, config('dream.adminstrators'));
    }
    
    public function getisAdminAttribute(){
        return $this->isAdmin();
    }

    
}
