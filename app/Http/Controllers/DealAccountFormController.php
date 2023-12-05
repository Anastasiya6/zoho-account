<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealAccountRequest;
use App\Services\DealAccount\DealAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealAccountFormController extends Controller
{
    public function createDealAndAccount(Request $request, DealAccountService $dealAccountService): \Illuminate\Http\JsonResponse
    {
        Log::info(print_r($request,1));

        $messages = $dealAccountService->store($request);

        return response()->json(['message' => $messages], 200);
    }
}
