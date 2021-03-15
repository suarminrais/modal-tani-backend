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
        if (Gate::allows('isAdmin') || $id == Auth::user()->id) {
            return User::findOrFail($id);
        }

        return abort(404);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "sometimes|string",
            "email" => "sometimes|unique:users",
            "password" => "sometimes|min:6|confirmed"
        ]);

        if (Gate::allows('isAdmin') || $id == Auth::user()->id) {
            $user = User::findOrFail($id);
            $user->update($request->all());

            return $user;
        }

        return abort(404);
    }

    public function destroy($id)
    {
        //
    }
}
