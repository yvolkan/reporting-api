<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\HttpStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Get api status
     */
    public function index()
    {
        return response()->json([
            'status' => HttpStatusEnum::STATUS_OK,
            'date' => date(DATE_ISO8601), 
        ]);
    }
}
