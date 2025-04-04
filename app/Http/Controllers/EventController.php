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
        $user = $request->user();
        $events = Event::where('organization_id', $user->organization_id)->get();
        return response()->json($events);
    }




    public function show($id)
    {
        return response()->json(Event::findOrFail($id));
    }


    public function store(Request $request)
{
    $this->authorize('create', Event::class);
    $event = Event::create([
        'name' => $request->name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'location' => $request->location,
        'capacity' => $request->capacity,
        'organization_id' => $request->organization_id,
    ]);

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
