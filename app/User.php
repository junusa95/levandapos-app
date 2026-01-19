<?php

namespace App;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;
    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

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

    public function company() {
        return $this->belongsTo('App\Company','company_id');
    }
    
    public function roles() {
        return $this->belongsToMany('App\Role','user_roles','user_id','role_id');
    }

    public function stores() {
        return $this->belongsToMany('App\Store','user_stores','user_id','store_id');
    }
    
    public function agentAccounts() {
        return $this->belongsToMany('App\Company','agent_companies','user_id','company_id');
    }

    public function isActive() {
        if ($this->status == "active") {
            return true;
        } else {
            return false;
        }
    }

    public function isAdmin() {
        return $this->roles()->where('roles.name','Admin')->first();
    }
    
    public function isAgent() {
        return $this->roles()->where('roles.name','Agent')->first();
    }

    public function isBusinessOwner() {
        return $this->roles()->where('roles.name','Business Owner')->first();
    }

    public function isCEOorAdmin() {
        $check = $this->roles()->whereIn('roles.name',['Admin','CEO'])->get();
        if(!$check->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }

    public function isCEOorAdminorBusinessOwner() {
        $check = $this->roles()->whereIn('roles.name',['Admin','CEO','Business Owner'])->get();
        if(!$check->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }

    public function isCEOorAdminorSmaster() {
        $check = $this->roles()->whereIn('roles.name',['Admin','CEO','Store Master'])->get();
        if(!$check->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }

    public function isCEOorAdminorCashier() { //changed to CEO, BO or Cashier
        $check = $this->roles()->whereIn('roles.name',['Business Owner','CEO','Cashier'])->get();
        if(!$check->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }

    public function hasCashierRole() {
        return \DB::table('user_roles')->where('user_id',$this->id)->where('role_id',6)->first();
    }
    public function isCashier() {
        return \DB::connection('tenant')->table('user_shops')->where('user_id',$this->id)->where('who','cashier')->first();
    }
    public function cashierShops() {
        return \DB::connection('tenant')->table('user_shops')->where('user_id',$this->id)->where('who','cashier')->get();
    }

    public function hasSalePersonRole() {
        return \DB::table('user_roles')->where('user_id',$this->id)->where('role_id',7)->first();
    }
    public function isSalePerson() {
        return \DB::connection('tenant')->table('user_shops')->where('user_id',$this->id)->where('who','sale person')->first();
    }
    public function salePersonShops() {
        return \DB::connection('tenant')->table('user_shops')->where('user_id',$this->id)->where('who','sale person')->get();
    }

    public function isStoreMaster() {
        return \DB::connection('tenant')->table('user_stores')->where('user_id',$this->id)->where('who','store master')->first();
    }
    public function storeMasterStores() {
        return \DB::connection('tenant')->table('user_stores')->where('user_id',$this->id)->where('who','store master')->get();
    }

    public function isBusinessOwnerorAdmin() {
        $check = $this->roles()->whereIn('roles.name',['Admin','Business Owner'])->get();
        if(!$check->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function userNotifications() { 
        return $this->belongsToMany('App\Notification','user_notifications','user_id','notification_id');
    }

}
 