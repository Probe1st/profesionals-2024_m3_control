<?php

namespace App\Http\Controllers;

use App\Http\Resources\AirportResource;
use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AirportController extends Controller
{
    public function search(Request $request)
    {
        $query = '%'. $request->query("query") .'%';

        $airports = AirportResource::collection(Airport::where('city', 'LIKE', $query)
            ->orWhere('name', 'LIKE', $query)
            ->orWhere('iata', 'LIKE', $query)
            ->get()
        );

        return response()->json([
            'data' => [
                'items' => $airports
            ]
        ]);
    }
}
