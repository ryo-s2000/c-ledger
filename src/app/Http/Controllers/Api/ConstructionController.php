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
        $construction->fill($request->all());
        $construction->fill([
            'progress' => $this->createProgressColumn($request->progress_value)
        ]);
        $construction->save();
    }

    public function show(int $id)
    {
        return Construction::find($id);
    }

    public function update(Request $request, int $id)
    {
        $construction = Construction::find($id);
        $construction->fill($request->all());

        if($construction->progress_value !== $request->progress_value) {
            $construction->fill([
                'progress' => array_merge($construction->progress, $this->createProgressColumn($request->progress_value))
            ]);
        }

        $construction->save();
    }

    public function destroy(int $id)
    {
        Construction::destroy($id);
    }

    private function createProgressColumn($progressValue)
    {
        return [
            [
                'value' => $progressValue,
                'datetime' => now()
            ]
        ];
    }
}
