<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Opleiding;
use App\Models\Vak;
use App\Models\Blok;

class Vak extends Model
{
    use HasFactory;
    
    protected $table = 'vakken';

    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }
}