<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Digimon;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DigimonController extends Controller
{
    // Create, modify, view and delete Digimons

    function index(){
        $digimons = Digimon::all();
        return response()->json($digimons->load('skills'), 200);
    }

    function show(Digimon $digimon){
        return response()->json($digimon, 200);
    }

    function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|string',
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $image = null;

            if ($request->hasFile('image_url')){
                $image = time() . '.' . $request->image_url->extension();
                $request->file('image_url')->move(public_path('assets/images/digimons'), $image);
            }

            $digimon = Digimon::create([
                'name' => $request->name,
                'image_url' => $image,
                'description' => $request->description
            ]);

            $skills = Skill::where('id', $request->skills)->get();
            $digimon->skills()->attach($skills);

            return response()->json(['message' => 'Digimon created successfully', 'digimon' => $digimon->load('skills') ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


    }

    public function update(Request $request, Digimon $digimon){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|string',
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {

            if ($request->hasFile('image_url')){
                $image = time() . '.' . $request->image_url->extension();
                $request->file('image_url')->move(public_path('images'), $image);
                $digimon->image_url = $image;
            }

            $digimon->name = $request->name;
            $digimon->description = $request->description;

            $digimon->update();

            $digimon->skills()->sync($request->skills);

            return response()->json(['message' => 'Digimon updated successfully', 'digimon' => $digimon->load('skills'), ], 201);


        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Digimon $digimon){
        $digimon->delete();
        return response()->json(['message' => 'Digimon deleted successfully'], 200);
    }

    // Tenemos que ver el preview digimon, el next digimon y recoger las skills del digimon
    function previous_digimon(Digimon $digimon){
        return response()->json($digimon->evolutions_previous, 200);
    }

    function next_digimon(Digimon $digimon){
        return response()->json($digimon->evolutions_next()->get(), 200);
    }

//    function skills(Digimon $digimon){
//        return response()->json($digimon->skills()->get(), 200);
//    }
}
