<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamFinancesApiController extends Controller
{
    public function countTeamFinances(int $teamId)
    {
        $debit = $this->matchService->getCashSpentFromMatches($teamId);

        $credit = $this->matchService->getCashEarnedFromPlayers($teamId);

        $response = [
            'debit' => $debit,
            'credit' => $credit,
            'total' => $credit - $debit,
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
