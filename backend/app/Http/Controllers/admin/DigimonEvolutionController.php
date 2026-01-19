<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DigimonEvolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DigimonEvolutionController extends Controller
{
    // Create, modify, display and delete digievolutions

    // Aqui es donde se establecen las evoluciones escogiendo dos digimons creados anteriormente y su evolutionT

    function index(){
        $digievolutions = DigimonEvolution::all();
        return response()->json($digievolutions, 200);
    }

    function show($prev, $next){
        $digievolution = DigimonEvolution::where('id_digimon_previous', $prev)->where('id_digimon_next', $next)->firstOrFail();
        return response()->json($digievolution, 200);
    }

    function create(Request $request){
        $validator = Validator::make($request->all(), [
            'id_digimon_previous' => 'required|integer',
            'id_digimon_next' => 'required|integer',
            'id_evolutionT' => 'required|integer',
            'condition' => 'required|string'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try{
            $this->authorize('create', DigimonEvolution::class);
            $digievolution = DigimonEvolution::create([
                'id_digimon_previous' => $request->id_digimon_previous,
                'id_digimon_next' => $request->id_digimon_next,
                'id_evolutionT' => $request->id_evolutionT,
                'condition' => $request->condition
            ]);

            return response()->json(['message' => 'Digimon evolution created successfully', 'digievolution' => $digievolution], 201);
        } catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    function update(Request $request, $prev, $next)
    {
        $validator = Validator::make($request->all(), [
            'id_digimon_previous' => 'required|integer',
            'id_digimon_next' => 'required|integer',
            'id_evolutionT' => 'required|integer',
            'condition' => 'required|string'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $this->authorize('update', DigimonEvolution::class);
            $digievolution = DigimonEvolution::where('id_digimon_previous', $prev)->where('id_digimon_next', $next)->update([
                'id_digimon_previous' => $request->id_digimon_previous,
                'id_digimon_next' => $request->id_digimon_next,
                'id_evolutionT' => $request->id_evolutionT,
                'condition' => $request->condition
            ]);

            if (!$digievolution) return response()->json(['message' => 'Digimon evolution not found'], 404);


            return response()->json(['message' => 'Digimon evolution updated successfully', 'digievolution' => $digievolution], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function destroy($prev, $next){
        $this->authorize('delete', DigimonEvolution::class);
        $digievolution = DigimonEvolution::where('id_digimon_previous', $prev)->where('id_digimon_next', $next)->delete();
        return response()->json(['message' => 'Digimon evolution deleted successfully'], 200);
    }
}
