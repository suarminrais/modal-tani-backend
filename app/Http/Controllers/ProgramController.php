<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramRequest;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        if($page = $request->get('perPage'))
        {
            return Program::latest()->paginate($page);
        }

        return Program::latest()->take(3)->get();
    }

    public function store(ProgramRequest $request)
    {
        $request->merge([
            "user_id" => Auth::user()->id,
        ]);

        return Program::make($request->all());
    }

    public function show(Program $program)
    {
        return $program;
    }

    public function update(ProgramRequest $request, Program $program)
    {
        $program->update($request->all());

        return response()->json([
            "message" => "Program Updated!"
        ]);
    }

    public function destroy(Program $program)
    {
        if($program->user_id === Auth::user()->id)
        {
            $program->delete();

            return response()->json([
                "message" => "Program Deleted!"
            ]);
        }

        return response()->json([
            "message" => "Program Not Found!"
        ],404);
    }
}
