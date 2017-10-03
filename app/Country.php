<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
	protected $table = 'oc_country';
	
	public static function rules()
    {
        return [
            'cardno'         =>    'required',
            'expireyear'     =>    'required|integer',
            'expiremonth'    =>    'required|integer',
            'country'        =>    'required',
            'postalcode'     =>    'required'
        ];
    }
	
	
}
