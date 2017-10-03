<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //
	protected $table = 'bank';
	
	public static function rules()
    {
        return [
            'amount'         =>   'required|integer',
            'full_name'      =>    'required',
            'bank_name'      =>    'required',
            'time'           =>    'required',
            'date'           =>    'required'
        ];
    }
	
}
