<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Publisher; // Assuming Publisher model exists
use App\Models\Developer; // Assuming Developer model exists
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     * Fetches all games with their associated publisher and developers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Game::with('publisher', 'developers')->get());
    }

    /**
     * Store a newly created resource in storage.
     * Validates incoming request data and creates a new Game,
     * then attaches associated developers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5', // Added min/max for rating
            'class' => 'required|string|max:255', // Added max length
            'publisher_id' => 'required|exists:publishers,id',
            'developer_ids' => 'required|array',
            'developer_ids.*' => 'exists:developers,id', // Validate each ID in the array
        ]);

        $game = Game::create($request->only('title', 'genre', 'rating', 'class', 'publisher_id'));
        $game->developers()->attach($request->developer_ids);

        return response()->json(['message' => 'Game created successfully', 'game' => $game->load('publisher', 'developers')], 201);
    }

    /**
     * Display the specified resource.
     * Fetches a single game by ID with its associated publisher and developers.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Game $game)
    {
        // 'load' ensures relationships are eager loaded if not already
        return response()->json($game->load('publisher', 'developers'));
    }

    /**
     * Update the specified resource in storage.
     * Validates incoming request data and updates an existing Game.
     * Handles both direct game attributes and syncing of developers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Game $game)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'genre' => 'sometimes|string|max:255',
            'rating' => 'sometimes|numeric|min:0|max:5',
            'class' => 'sometimes|string|max:255',
            'publisher_id' => 'sometimes|exists:publishers,id',
            'developer_ids' => 'sometimes|array',
            'developer_ids.*' => 'sometimes|exists:developers,id',
        ]);

        // Update basic game attributes
        $game->update($request->only('title', 'genre', 'rating', 'class', 'publisher_id'));

        // Sync developers if developer_ids are provided
        if ($request->has('developer_ids')) {
            $game->developers()->sync($request->developer_ids);
        }

        // Return the updated game with relationships
        return response()->json(['message' => 'Game updated successfully', 'game' => $game->load('publisher', 'developers')], 200);
    }

    /**
     * Remove the specified resource from storage.
     * Detaches developers (important for many-to-many) and then deletes the game.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Game $game)
    {
        // Detach developers to clean up pivot table entries
        $game->developers()->detach();

        // Delete the game itself
        $game->delete(); // <--- Change back to Eloquent's delete()

        return response()->json(['message' => 'Game deleted successfully'], 204); // 204 No Content
    }
}
