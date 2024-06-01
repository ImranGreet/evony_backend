<?php

namespace App\Http\Controllers;

use App\Models\Qusetion;
use Illuminate\Http\Request;

class QusetionController extends Controller
{

    public function index()
    {
        $questions = Qusetion::with('user')->get();

        return response()->json([
            'questions' => $questions
        ], 200);
    }

    public function store(Request $request)
    {
        $question = new Qusetion();

        $question->user_id = $request->user_id;
        $question->primary_motivations_weight = $request->primary_motivations_weight;
        $question->have_target_weight = $request->have_target_weight;
        $question->target_weight = $request->target_weight;
        $question->how_struggled_weight = $request->how_struggled_weight;
        $question->approaches_methods = $request->approaches_methods;
        $question->your_main_challenges = $request->your_main_challenges;
        $question->suffer_following = $request->suffer_following;
        $question->pregnant_lactic = $request->pregnant_lactic;
        $question->diagnosed_conditions = $request->diagnosed_conditions;
        $question->taking_medications = $request->taking_medications;
        $question->taking_Ozempic = $request->taking_Ozempic;
        $question->twentyFive_starting_dose = $request->twentyFive_starting_dose;
        $question->list_current_medications = $request->list_current_medications;
        $question->allergic_to_these = $request->allergic_to_these;
        $question->allergies_none = $request->allergies_none;
        $question->current_weight_height = $request->current_weight_height;
        $question->BMI_range = $request->BMI_range;

        $question->save();

        return response()->json([
            'message' => 'Question created successfully',
            'question' => $question
        ], 201);
    }
}
