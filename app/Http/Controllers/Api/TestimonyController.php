<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonyController extends Controller
{
    public function index()
    {
        return Testimony::take(6)->with('image')->paginate(10);
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
        return $testimony;
    }

    public function update(Request $request, Testimony $testimony)
    {
        $this->validate($request, [
            "name" => 'required|string',
            "job" => 'required|string',
            "detail" => 'required|string',
            "image" => 'sometimes|image'
        ]);

        $image_name = date("his") . ".png";

        if ($request->file('image')) {
            $request->file('image')->storeAs('images', $image_name);

            $last_image = $testimony->image->name;

            $testimony->image->update([
                "name" => $image_name,
            ]);

            Storage::delete('images/' . $last_image);
        }

        $testimony->update($request->all());

        return [
            "message" => "success"
        ];
    }

    public function destroy(Testimony $testimony)
    {
        Storage::delete('images/' . $testimony->image->name);

        $testimony->delete();

        return [
            "message" => "success"
        ];
    }
}
