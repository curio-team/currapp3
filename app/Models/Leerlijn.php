<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leerlijn extends Model
{
    use HasFactory;

    protected $table = 'leerlijnen';

    protected function eigenaarId() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? "?",
        );    
    }

    protected function textcolor(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getContrastColor($this->color),
        );
    }

    protected function textcolorsubtle(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($this->getContrastColor($this->color) == 'black') ? $this->adjustBrightness($this->color, -200) : $this->adjustBrightness($this->color, 225)
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

    private function adjustBrightness($hex, $steps) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));
    
        // Normalize into a six character long hex string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
        }
    
        // Split into three parts: R, G and B
        $color_parts = str_split($hex, 2);
        $return = '#';
    
        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = max(0,min(255,$color + $steps)); // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }
    
        return $return;
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
