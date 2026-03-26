<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feedbackmoment extends Model
{
    use HasFactory;

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(ModuleVersie::class);
    }

    public static function generateCode($batchCodes = [])
    {
        $characters = '2345679ABCDEFGHJKMNPQRSTUVWXYZ';

        do {
            $code = 'F'.substr(str_shuffle($characters), 0, 3);
        } while (Feedbackmoment::where('code', $code)->count() || in_array($code, $batchCodes));

        return $code;
    }
}
