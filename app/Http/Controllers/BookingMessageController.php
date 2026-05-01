<?php

namespace App\Http\Controllers;

use App\Models\BookingMessage;
use App\Models\Request as BookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingMessageController extends Controller
{
    public function store(Request $request, $requestId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $bookingRequest = BookingRequest::findOrFail($requestId);

        // Security check: Ensure user is either the family or the employee for this request
        $userId = Auth::id();
        $isFamily = $bookingRequest->family->user_id === $userId;
        $isEmployee = $bookingRequest->offre->employee->user_id === $userId;

        if (!$isFamily && !$isEmployee) {
            abort(403, 'Unauthorized action.');
        }

        BookingMessage::create([
            'request_id' => $requestId,
            'user_id' => $userId,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent successfully.');
    }
}
