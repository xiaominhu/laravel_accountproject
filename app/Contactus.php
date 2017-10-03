<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    //
	protected $table = 'contactus';
	
	public static function rules()
    {
        return [
            'type'         =>   'required|integer',
            'content'      =>    'required',
        ];
    }
}
