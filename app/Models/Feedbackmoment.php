<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedbackmoment extends Model
{
    use HasFactory;

    public function modules()
    {
        return $this->belongsToMany(ModuleVersie::class);
    }

    public static function generateCode()
    {
        $characters = "2345679ABCDEFGHJKMNPQRSTUVWXYZ";

        do{
            $code = "F" . substr(str_shuffle($characters), 0, 3);
        } while(Feedbackmoment::where('code', $code)->count());

        return $code;
    }
}
