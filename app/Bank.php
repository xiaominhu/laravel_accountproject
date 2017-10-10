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
            'amount'         =>    'required|numeric',
            'full_name'      =>    'required',
            'bank_name'      =>    'required',
            'time'           =>    'required',
			'attachment'     =>    'image|mimes:jpeg,bmp,png',
            'date'           =>    'required',
         
        ];
    }
	
}
