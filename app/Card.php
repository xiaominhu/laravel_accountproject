<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
	protected $table = 'card';
	
	public static function rules()
    {
        return [
            'cardno'         =>    'required',
            'expireyear'     =>    'required|integer',
            'expiremonth'    =>    'required|integer',
            'country'        =>    'required',
            'postalcode'     =>    'required',
            'holdername'     =>    'required',
            'amount'         =>    'required|integer'
        ];
    }
	
}
