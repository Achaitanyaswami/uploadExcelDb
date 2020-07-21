<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ph_price extends Model
{
    protected $table = 'ph_prices';
    public $fillable = ['ph', 'price'];

    public function ph_ips()
    {
        return $this->hasMany('App\Ph_ip');
    }
}
