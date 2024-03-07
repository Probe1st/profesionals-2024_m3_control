<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function booking(Request $request) {
        $validator = Validator::make($request->all(), [
            'flight_from' => ['required', 'array'],
            'flight_from.id' => ['required', 'exists:flights,id'],
            'flight_from.date' => ['required', 'regex:/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[0-1])$/'],
            'flight_back' => ['required', 'array'],
            'flight_back.id' => ['required', 'exists:flights,id'],
            'flight_back.date' => ['required', 'regex:/^20[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[0-1])$/'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }

        $book = Booking::create([
            'flight_from' => $request->get('flight_from')['id'],
            'flight_back' => $request->get('flight_back')['id'],
            'date_from' => '2024-07-03',
            'date_back' => '2024-07-03',
            'code' => ''
        ]);

        return response()->json([
            'data' => [
                'code' => $book->generateToken(),
            ]
        ]);
    }
}
