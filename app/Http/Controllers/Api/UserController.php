<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Gate::allows('isAdmin')) {
            return User::all();
        }
        return User::find(Auth::user()->id)->programs()->paginate(6);
    }

    public function store(Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $this->validate($request, [
                "name" => "required|string",
                "email" => "required|unique:users",
                "password" => "required|min:6|confirmed"
            ]);

            return User::create($request->all());
        }

        return abort(404);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
