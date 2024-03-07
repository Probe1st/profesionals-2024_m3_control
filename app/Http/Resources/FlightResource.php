<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $airportFrom = DB::table('airports')->where('id', $this->from_id)->first();
        $airportTo = DB::table('airports')->where('id', $this->to_id)->first();


        return [
            'flight_id' => $this->id,
            'flight_code' => $this->flight_code,
            'from' => [
                'city' => $airportFrom->city,
                'airport' => $airportFrom->name,
                'iata' => $airportFrom->iata,
                'date' => $this->date,
                'time' => $this->time_from,
            ],
            'to' => [
                'city' => $airportTo->city,
                'airport' => $airportTo->name,
                'iata' => $airportTo->iata,
                'date' => $this->date,
                'time' => $this->time_to,
            ],
            'cost' => $this->cost,
            'availability' => 156
        ];
    }
}
