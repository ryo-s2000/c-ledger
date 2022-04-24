<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Construction;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    public function index(Construction $construction)
    {
        // TODO filter and limit
        $constructions = $construction->limit(10)->get();

        return response()->json($constructions);
    }

    public function store(Request $request, Construction $construction)
    {
        $construction->fill($request->all())->save();
    }

    public function show(int $id)
    {
        return Construction::find($id);
    }

    public function update(Request $request, int $id)
    {
        Construction::find($id)->fill($request->all())->save();
    }
}
