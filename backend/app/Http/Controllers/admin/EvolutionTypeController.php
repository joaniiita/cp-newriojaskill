<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\EvolutionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EvolutionTypeController extends Controller
{
    // Create, modify, display and delete evolution types
    function index()
    {
        $evolution_types = EvolutionType::all();
        return response()->json($evolution_types, 200);
    }

    function show(EvolutionType $evolution_type){
        return response()->json($evolution_type, 200);
    }

    function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'ranking' => 'required|integer'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $evolution_types = EvolutionType::create([
               'name' => $request->name,
               'description' => $request->description,
               'ranking' => $request->ranking
            ]);

            return response()->json(['message' => 'Evolution type created successfully', 'evolution_type' => $evolution_types], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function update(Request $request, EvolutionType $evolution_type){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'ranking' => 'required|integer'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $evolution_type->name = $request->name;
            $evolution_type->description = $request->description;
            $evolution_type->ranking = $request->ranking;
            $evolution_type->save();

            return response()->json(['message' => 'Evolution type updated successfully', 'evolution_type' => $evolution_type], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function destroy(EvolutionType $evolution_type)
    {
        $evolution_type->delete();
        return response()->json(['message' => 'Evolution type deleted successfully'], 200);
    }
}
