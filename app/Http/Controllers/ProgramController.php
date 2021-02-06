<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramRequest;
use App\Models\Program;
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
        return $program->update($request->all());
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return response()->json([
            "message" => "Program Deleted!"
        ]);
    }
}
