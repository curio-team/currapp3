<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leerlijn extends Model
{
    use HasFactory;

    protected $table = 'leerlijnen';

    protected function textcolor(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getContrastColor($this->color),
        );
    }

    private function getContrastColor($hexcolor) 
    {               
        $r = hexdec(substr($hexcolor, 1, 2));
        $g = hexdec(substr($hexcolor, 3, 2));
        $b = hexdec(substr($hexcolor, 5, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq >= 128) ? 'black' : 'white';
    }    

    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function leerdoelen()
    {
        return $this->hasMany(Leerdoel::class);
    }

    public function acceptatiecriteria()
    {
        return $this->belongsToMany(Acceptatiecriterium::class, 'acceptatiecriterium_leerlijn');
    }
}
