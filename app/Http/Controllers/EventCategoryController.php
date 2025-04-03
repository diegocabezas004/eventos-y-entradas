<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Event;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        return EventCategory::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories',
        ]);

        $category = EventCategory::create($validated);

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = EventCategory::findOrFail($id);
        $category->update($request->all());
        return response()->json($category);
    }

    public function destroy($id)
    {
        EventCategory::destroy($id);
        return response()->json(['message' => 'Category deleted']);
    }
}
