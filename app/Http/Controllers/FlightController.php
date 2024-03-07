<?php

namespace App\Http\Controllers;

use App\Http\Resources\FlightResource;
use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    public function search(Request $request)
    {
        $query = [
            'from' => $request->query('from'),
            'to' => $request->query('to'),
            'date1' => $request->query('date1'),
            'date2' => $request->query('date2'),
            'passengers' => $request->query('passengers'),
        ];

        $validator = Validator::make($query, [
            'from' => ['required', 'string', 'exists:airports,iata'],
            'to' => ['required', 'string', 'exists:airports,iata'],
            'date1' => ['required', 'regex:/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[0-1])$/'],
            'date2' => ['nullable', 'regex:/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[0-1])$/'],
            'passengers' => ['required', 'regex:/^[1-8]$/']
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ]);
        }

        $from_id = Airport::where('iata', '=', $query['from'])->first('id')->id;
        $to_id = Airport::where('iata', '=', $query['to'])->first('id')->id;

        $flights_to = Flight::where('from_id', $from_id)
            ->where('to_id', $to_id)
            // ->setDate($query['date1'])
            ->get()
        ;

        $flights_back = Flight::where('to_id', $from_id)
            ->where('from_id', $to_id)
            // ->setDate($query['date2'])
            ->get()
        ;

        return response()->json([
            'data' => [
                'flights_to' => FlightResource::collection($flights_to), 
                'flights_back' => FlightResource::collection($flights_back),
            ]
        ]);
    }
}
