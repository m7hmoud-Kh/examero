<?php

return [
    "required" =>  "يرجي ادخال :attribute",
    "email" => "يرجي ادخال ايميل صحيح",
    "exists" => ":attribute غير موجود ",
    'string' => 'يجب ان يحتوي :attribute علي حروف',
    'unique' => ':attribute مستخدم من قبل',
    'digits' => 'يجب ان يحتوي :attribute علي 10 ارقام',
    'confirmed' => ':attribute غير متطابقه',
    'letters' => 'يحب ان يحتوي :attribute علي حروف',
    'min' => 'يجب ان يحتوي :attribute بحد اقصي علي :value',
    'numbers' => 'يحب ان يحتوي :attribute علي ارقام',
    'date' => 'يرجي ادخال تاريخ صحيح',
    'required_with' => 'يرجي ادخال :attribute في حاله ادخال :value',
    'array' => 'يجب ان يكون :attribute عباره عن مصفوفه',
    'numeric' => 'يجب ان يحتوي :attribute علي رقم',
    'current_password' => 'كلمه المرور الحاليه غير صحيحه',
    'mimes' => 'يرجي ادخال :attribute بصيغه :values',
    'boolean' => 'يجب ان يتضمن :attribute قيمه boolean',
    'integer' => 'يجب ان يتحوي :attribute علي رقم',

    "custom" => [
        "level" => [
            "in" => "يجب ان يتضمن مستوي السؤال رقم من 1 الي 5",
        ],

        "semster" => [
            'in' => "يجب ان يتضمن الفصل الدراسي اما الاول او الثاني"
        ],

        "for" => [
            'in' => 'يرجي اختيار صيغه السؤال بشكل صحيح'
        ],

        'type' => [
            'in' => 'يرجي اختيار نوع المنح رقم من 1 الي 4'
        ]
    ],

    "attributes" => [
        'email'=> "الايميل الالكتروني",
        'password' => 'كلمه المرور',
        'password_confirmation' => 'تاكيد كلمه المرور',
        "first_name" => 'الاسم الاول',
        "last_name" => 'اسم العائله',
        'phone_number' => 'رقم الموبيل',
        'date_of_birth' => 'تاريخ الميلاد',
        "group_id" => 'رقم الصف',
        "subject_id" => 'رقم المبحث',
        "lesson_id" => "رقم الدرس",
        "semster" => "الفصل الدراسي",
        "unit_id" => "رقم الوحده",
        "plan_id" => "رقم الباقه",
        "filters_level" => "مستويات الاسئله",
        "level" => "مستوي السؤال",
        "number_level" => 'عدد الاسئله',
        "answers" => "الاجابات",
        "current_password" => 'كلمه المرور الحاليه',
        "avatar" => 'الصوره الشخصيه',
        "question_type_id" => 'رقم نوع السؤال',
        "teacher_id" => 'رقم المدرس',
        'count' => 'العدد',
        'for' => 'صيغه السؤال',
        'questionIds' => 'ارقام الاسئله',
        'mediaAnswer' => 'مستند الاجابات',
        'mediaQuestion'  => 'مستند الاسئله',
        'user_name' => 'اسم المتخدم',
        'password_site' => 'كلمه مرور الموقع',
        'document' => 'مستند',
        'question_name' => 'اسم السؤال',
        'point' => 'علامه السؤال',
        'has_branch' =>  'له فروع',
        'is_choose' => 'سؤال اختياري',
        'question_image' => 'صوره السؤال',
        'options' => 'الاختيارات',
        'option' => 'اختيار',
        'is_correct' => 'يحتمل الصواب',
        'option_image' => 'صوره الاختيار',
        'address' => 'عنوان',
        'note' => 'ملاحظه',
        'adminIds' => 'ارقام الادمن',
        'message' => 'الرساله',
        'points' => 'النقاط',
        'type' => 'نوع',
        'admin_id' => 'رقم الادمن',
        'token' => 'الرمز',
        'status' => 'الحاله',
        'group_name' => 'اسم الصف',
        'lesson_name' => 'اسم الدرس',
        
    ]
];
