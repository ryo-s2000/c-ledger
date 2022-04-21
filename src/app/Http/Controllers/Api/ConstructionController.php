<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Construction;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    public function index(Request $request, Construction $construction)
    {
        // TODO filter and limit
        $constructions = $construction->limit(10)->get();

        return response()->json($constructions);
    }
}
