<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StressInteraction;

class StressInteractionController extends Controller
{
    /**
     * Log a stress interaction including the motivational message sent
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stress_score' => 'required|numeric|min:0|max:1',
            'is_stressed' => 'required|boolean',
            'message' => 'required|string|max:500',
            'timestamp' => 'required|date',
            'user_id' => 'sometimes|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $data = $validator->validated();
        
        // If user_id isn't provided, default to user 1 (for testing)
        if (!isset($data['user_id'])) {
            $data['user_id'] = 1;
        }

        $interaction = StressInteraction::create([
            'user_id' => $data['user_id'],
            'stress_score' => $data['stress_score'],
            'is_stressed' => $data['is_stressed'],
            'message' => $data['message'],
            'timestamp' => $data['timestamp'],
            'was_helpful' => null, // User hasn't provided feedback yet
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Stress interaction logged successfully',
            'interaction_id' => $interaction->id,
        ], 201);
    }
    
    /**
     * Update an interaction with user feedback on helpfulness
     */
    public function feedback(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'was_helpful' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $interaction = StressInteraction::findOrFail($id);
        $interaction->update([
            'was_helpful' => $request->was_helpful,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Feedback recorded successfully',
        ]);
    }
}