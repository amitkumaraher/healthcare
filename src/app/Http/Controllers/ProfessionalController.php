<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\HealthcareProfessional;

class ProfessionalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $professionals = HealthcareProfessional::query()
            ->orderBy('name')
            ->get();

        return response()->json($professionals);
    }
}
