<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Construction;

class UtilController extends Controller
{
    public function getUniqueNames(Construction $construction, string $columnName)
    {
        return $construction->whereNotNull($columnName)->orderBy($columnName, 'desc')->distinct()->pluck($columnName);
    }
}
