<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    // Create, modify, view and delete skills.
    function index(){
        $skills = Skill::all();
        return response()->json($skills, 200);
    }

    function show(Skill $skill){
        return response()->json($skill, 200);
    }

    function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try{
            $this->authorize('create', Skill::class);
            $skill = Skill::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            return response()->json(['message' => 'Skill created successfully', 'skill' => $skill], 201);
        } catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function update(Request $request, Skill $skill){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $this->authorize('update', $skill);
            $skill->name = $request->name;
            $skill->description = $request->description;

            $skill->save();
            return response()->json(['message' => 'Skill updated successfully', 'skill' => $skill], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function destroy(Skill $skill)
    {
        $this->authorize('delete', $skill);
        $skill->delete();
        return response()->json(['message' => 'Skill deleted successfully'], 200);
    }
}
