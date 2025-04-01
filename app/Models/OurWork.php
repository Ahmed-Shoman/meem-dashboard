<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurWork extends Model
{
    use HasFactory;

    protected $table = 'our_works'; // تأكيد اسم الجدول في قاعدة البيانات

    protected $fillable = [
        'main_title',
        'subtitle',
        //'cta_button_text',
        'client_logos',
        'description_text',
        'listeners_stat',
        'listeners_stat_description',
         'listeners_stat_subtitle' ,
         'episodes_stat_subtitle',
         'programs_stat_subtitle',
        'episodes_stat',
        'episodes_stat_description',
        'programs_stat',
        'programs_stat_description',
        // 'program_list',
        'banner_text',
    ];

        protected $casts = [
        'client_logos' => 'array', // شريط العملاء (اللوجوهات)
        // 'program_list' => 'array', // قائمة البرامج
    ];
}
