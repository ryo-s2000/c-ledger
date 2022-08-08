<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Construction;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    public function index(Construction $construction, Request $request)
    {
        $query = $construction;

        // fulter
        $year = $request->year;
        if (!empty($year)) $query = $query->where('year', $year);

        $category = $request->category;
        if (!empty($category)) $query = $query->where('number', 'like', $category.'%');

        $orderer = $request->orderer;
        if (!empty($orderer)) $query = $query->where('orderer', 'like', '%'.$orderer.'%');

        $place = $request->place;
        if (!empty($place)) $query = $query->where('place', 'like', '%'.$place.'%');

        $sales = $request->sales;
        if (!empty($sales)) $query = $query->where('sales', 'like', '%'.$sales.'%');

        $supervisor = $request->supervisor;
        if (!empty($supervisor)) $query = $query->where('supervisor', 'like', '%'.$supervisor.'%');

        $agent = $request->agent;
        if (!empty($agent)) $query = $query->where('agent', 'like', '%'.$agent.'%');

        $developer = $request->developer;
        if (!empty($developer)) $query = $query->where('developer', 'like', '%'.$developer.'%');

        // sort
        $query = $query->orderBy('year', 'desc')->orderBy('number', 'asc');

        // limit
        $limit = $request->limit;
        if (is_numeric($limit)) {
            $query = $query->limit($limit);
        } else {
            $query = $query->limit(300);
        }

        $constructions = $query->get();
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
        $construction = Construction::find($id);
        $construction->fill([
            'hidden_at' => now()
        ])->save();
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

    public function numberValidate(string $year, string $number)
    {
        return Construction::where('year', $year)->where('number', $number)->exists();
    }
}
