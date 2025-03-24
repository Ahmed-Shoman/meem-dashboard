<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

   protected $fillable = [
    'presenter',
    'image',
    'seasons',
    'episodes',
    'links',
    'program_name',
    'audio',
    'audio_time',
    'is_active', // ✅ تمت الإضافة
];
}