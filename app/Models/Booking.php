<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    public function generateToken() {
        $this->code = Str::random(5);
        $this->save();

        return $this->code;
    }

    protected $fillable = [
        'flight_from',
        'flight_back',
        'date_from',
        'date_back',
        'code'
    ];


}