<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class EventController extends Controller
{

    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Event::query();

        $user = $request->user();

        // Si el usuario es admin de organización, solo puede ver sus propios eventos
        if ($user && $user->role_id == 2) {
            $query->where('organization_id', $user->organization_id);
        }

        // Filtros adicionales si vienen del frontend
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has(['start_date', 'end_date'])) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }

        return response()->json($query->get());
    }




    public function show($id)
    {
        return response()->json(Event::findOrFail($id));
    }


    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'capacity' => 'required|integer',
            'category_id' => 'required|exists:event_categories,id',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $event = Event::create($validated);

        return response()->json($event, 201);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return response()->json($event);
    }

    public function destroy($id)
    {
        Event::destroy($id);
        return response()->json(['message' => 'Event deleted']);
    }
}
