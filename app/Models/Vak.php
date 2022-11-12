<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vak extends Model
{
    use HasFactory;
    
    protected $table = 'vakken';

    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }
}
