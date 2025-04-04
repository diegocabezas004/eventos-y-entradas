<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;

class TicketController extends Controller
{
    // Obtener los eventos comprados por el usuario autenticado
    public function getPurchasedEvents(Request $request)
    {
        // Obtener el usuario autenticado
        $user = $request->user();

        // Obtener los tickets comprados por el usuario
        $tickets = Ticket::where('user_id', $user->id)->with('event')->get();

        // Devolver los eventos asociados a esos tickets
        return response()->json($tickets->pluck('event'));
    }

    // Obtener los tickets del usuario autenticado
    public function userTickets()
    {
        return auth()->user()->tickets;
    }

    // Obtener los eventos asociados a los tickets del usuario autenticado
    public function userEvents()
    {
        return auth()->user()->tickets()->with('event')->get()->pluck('event');
    }

    // Comprar un ticket
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

    // Check-in de un ticket
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
