<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Leerdoel extends Model
{
    protected $table = 'leerdoelen';

    protected function naam(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->leerlijn->naam . '.' . str_pad($this->nummer, 2, 0, STR_PAD_LEFT)
        );
    }

    public function leerlijn()
    {
        return $this->belongsTo(Leerlijn::class);
    }
}
