<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
	protected $table = 'setting';
	public static function rules()
    {
        return [
            'name'     =>    'required|unique:setting|max:255',
        ];
    }
	public static function getValue($key){
        $val = null;
        $setting = Setting::where('name', $key)->first();
        if(isset($setting))
            return $setting[$key];
	}
}
