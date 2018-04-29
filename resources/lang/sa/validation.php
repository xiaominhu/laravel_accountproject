<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ' :attribute يجب الموافقة عليه',
    'active_url'           => ' :attribute ليس رابط صحيح.',
    'after'                => ' :attribute يجب أن يكون التاريخ بعد :date.',
    'after_or_equal'       => ' :attribute يجب أن يكون التاريخ بعد أو يساوي :date.',
    'alpha'                => ' :attribute يجب احتواؤه على حروف فقط.',
    'alpha_dash'           => ' :attribute يجب احتواؤه على حروف، ارقام، وشرطات فقط.',
    'alpha_num'            => ' :attribute يجب احتواؤهعلى حروف وارقام فقط.',
    'array'                => ' :attribute يجب أن يكون مرتب',
    'before'               => ' :attribute يجب ان يكون التاريخ قبل :date.',
    'before_or_equal'      => ' :attribute يجب ان يكون التاريخ قبل او يساوي :date.',
    'between'              => [
        'numeric' => ' :attribute يجب ان يكون بين :min و :max.',
        'file'    => ' :attribute يجب ان يكون بين :min و :max كيلوبايت.',
        'string'  => ' :attribute يجب ان يكون بين :min و :max رموز.',
        'array'   => ' :attribute يجب ان يكون بين :min و :max عناصر.',
    ],
    'boolean'              => ' :attribute الحقل يجب ان يكون صحيح او خاطئ.',
    'confirmed'            => ' :attribute التأكيد لا يطابق المدخل.',
    'date'                 => ' :attribute ليس تاريخ صحيح.',
    'date_format'          => ' :attribute لا يطابق الصيغة الصحيحة :format.',
    'different'            => ' :attribute و :other يجب ان تكون مختلفة.',
    'digits'               => ' :attribute يجب ان تكون :digits ارقام.',
    'digits_between'       => ' :attribute يجب ان تكون بين :min و :max ارقام.',
    'dimensions'           => ' :attribute ابعاد الصورة غير صحيحة.',
    'distinct'             => ' :attribute الحقل فيه مدخلات متكررة.',
    'email'                => ' :attribute يجب أن يكون عنوان البريد الإلكتروني صحيح.',
    'exists'               => ' الذي تم اختياره :attribute غير صحيح.',
    'file'                 => ' :attribute يجب ان يكون ملف.',
    'filled'               => ' :attribute الحقل يجب ان يحتوي على قيمة.',
    'image'                => ' :attribute يجب ان يكون صورة.',
    'in'                   => ' الذي تم اختياره :attribute غير صحيح.',
    'in_array'             => ' :attribute الحقل غير موجود في :other.',
    'integer'              => ' :attribute يجب ان يكون رقم صحيح.',
    'ip'                   => ' :attribute يجب ان يكون عنوان الاي بي صحيح.',
    'json'                 => ' :attribute يجب ان يكون صحيح JSON string.',
    'max'                  => [
        'numeric' => ' :attribute يجب ان لا يكون اكبر من :max.',
        'file'    => ' :attribute يجب ان لا يكون اكبر من :max كيلوبايت.',
        'string'  => ' :attribute يجب ان لا يكون اكبر من :max رموز.',
        'array'   => ' :attribute يجب ان لا يكون اكبر من :max عناصر.',
    ],
    'mimes'                => ' :attribute يجب ان يكون ملف type: :values.',
    'mimetypes'            => ' :attribute يجب ان يكون ملف of type: :values.',
    'min'                  => [
        'numeric' => ' :attribute يجب ان يكون على الاقل :min.',
        'file'    => ' :attribute يجب ان يكون على الاقل :min كيلوبايت.',
        'string'  => ' :attribute يجب ان يكون على الاقل :min رموز.',
        'array'   => ' :attribute يجب ان يكون على الاقل :min عناصر.',
    ],
    'not_in'               => ' الذي تم اختياره :attribute غير صحيح.',
    'numeric'              => ' :attribute يجب ان يكون رقم.',
    'present'              => ' :attribute يجب ان يكون الحقل موجود.',
    'regex'                => ' :attribute طريقة الادخال غير صحيحة.',
    'required'             => ' :attribute الحقل الزامي.',
    'required_if'          => ' :attribute الحقل الزامي عندما :other يكون :value.',
    'required_unless'      => ' :attribute الحقل الزامي الا اذا :other كان فيه :values.',
    'required_with'        => ' :attribute الحقل الزامي عندما :values يكون موجود.',
    'required_with_all'    => ' :attribute الحقل الزامي عندما :values يكون موجود.',
    'required_without'     => ' :attribute الحقل الزامي عندما :values لا يكون موجود.',
    'required_without_all' => ' :attribute الحقل الزامي عندما لا :values يكون موجود.',
    'same'                 => ' :attribute و :other يجب تطابقهما.',
    'size'                 => [
        'numeric' => ' :attribute يجب ان يكون :size.',
        'file'    => ' :attribute يجب ان يكون :size كيلوبايت.',
        'string'  => ' :attribute يجب ان يكون :size رموز.',
        'array'   => ' :attribute يجب ان يحتوي على :size عناصر.',
    ],
    'string'               => ' :attribute يجب ان يكون مرتب.',
    'timezone'             => ' :attribute يجب ان يكون توقيت صحيح.',
    'unique'               => ' :attribute تم تسجيله مسبقا.',
    'uploaded'             => ' :attribute خطأ في الرفع.',
    'url'                  => ' :attribute صيغة المدخل غير صحيح.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
