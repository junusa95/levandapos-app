<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'mysql';

    public function users() {
        return $this->belongsToMany('App\User','user_roles','role_id','user_id');
    }

    public function isUserHasThisRole($user) {
        $check = $this->users()->where('users.id',$user)->first();
        if($check) {
            return true;
        } else {
            return false;
        }
    }
}
