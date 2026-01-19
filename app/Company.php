<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'mysql';

    public function contactPerson() {
        return $this->belongsTo('App\User','contact_person');
    }

    public function country() {
        return $this->belongsTo('App\Country','country_id');
    }

    public function currency() {
        return $this->belongsTo('App\Currency','currency_id');
    }

    public function companyOwners() {
        return \DB::table('users')->join('user_roles','user_roles.user_id','users.id')->where('users.company_id',$this->id)->where('users.status','active')->where('user_roles.role_id',2)->select('*','users.id as uid')->get();
    }

    public function companyCEOs() {
        return \DB::table('users')->join('user_roles','user_roles.user_id','users.id')->where('users.company_id',$this->id)->where('users.status','active')->where('user_roles.role_id',3)->get();
    }

    public function users() {
        return $this->hasMany('App\User','company_id');
    }

    public function shops() {
        return $this->hasMany('App\Shop','company_id');
    }
    
    public function stores() {
        return $this->hasMany('App\Store','company_id');
    }

    public function sales() {
        return $this->hasMany('App\Sale','company_id');
    }
    
    public function settings() { 
        return $this->belongsToMany('App\Setting','company_settings','company_id','setting_id')->where('company_settings.status','yes')->where('company_settings.company_id',$this->id);
    }
    
    public function isCheckingStockLevel() { 
        return \DB::table('company_settings')->where('company_id',$this->id)->where('status','yes')->where('setting_id',2)->first();
    }

    public function defaultStockLevel() { 
        return \DB::table('company_settings')->where('company_id',$this->id)->where('setting_id',2)->first();
    }
    
    public function isImportingProducts() { 
        return \DB::table('company_settings')->where('company_id',$this->id)->where('status','yes')->where('setting_id',5)->first();
    }

}
