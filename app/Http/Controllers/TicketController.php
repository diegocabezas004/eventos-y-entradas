<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function userTickets()
    {
        return auth()->user()->tickets;
    }

    public function userEvents()
    {
        return auth()->user()->tickets()->with('event')->get()->pluck('event');
    }

    public function buy(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'event_id' => $validated['event_id'],
            'quantity' => $validated['quantity'],
            'code' => strtoupper(\Str::random(6)),
        ]);

        return response()->json($ticket, 201);
    }

    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $ticket = Ticket::where('code', $validated['code'])->first();

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        if ($ticket->checked_in_at) {
            return response()->json(['message' => 'Ticket already used'], 400);
        }

        $ticket->checked_in_at = now();
        $ticket->save();

        return response()->json(['message' => 'Check-in successful']);
    }
}

