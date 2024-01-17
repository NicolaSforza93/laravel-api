<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function show(Type $type)
    {
        $type->load('projects', 'projects.technologies');

        return response()->json([
            'success' => true,
            'results' => $type
        ]);
    }
}
