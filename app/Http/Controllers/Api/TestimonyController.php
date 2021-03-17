<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimony;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    public function index()
    {
        return Testimony::take(6)->with('image')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => 'required|string',
            "job" => 'required|string',
            "detail" => 'required|string',
            "image" => 'required|image'
        ]);

        $image_name = date("his") . ".png";

        $request->file('image')->storeAs('images', $image_name);

        $testimony = Testimony::create($request->all());
        $testimony->image()->create([
            "name" => $image_name,
        ]);

        return [
            "message" => "success"
        ];
    }

    public function show(Testimony $testimony)
    {
        //
    }

    public function update(Request $request, Testimony $testimony)
    {
        //
    }

    public function destroy(Testimony $testimony)
    {
        //
    }
}
