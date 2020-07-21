<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ph_ip extends Model
{
    protected $table = 'ph_ips';
    public $fillable = ['ph', 'ip'];
    public function ph_prices()
    {
        return $this->hasMany('App\Ph_price');
    }
}
