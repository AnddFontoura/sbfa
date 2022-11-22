<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamFinancesApiController extends Controller
{
    public function countTeamFinances(Request $request)
    {
        $this->validate($request, [
            'teamId' => 'required|integer'
        ]);

        $data = $request->except('_token');
        $teamId = $data['teamId'];

        $debit = $this->matchService->getCashSpentFromMatches($teamId);

        $credit = $this->matchService->getCashEarnedFromPlayers($teamId);

        $response = [
            'debit' => number_format($debit, 2, ',', '.'),
            'credit' => number_format($credit, 2, ',', '.'),
            'total' => number_format($credit - $debit, 2, ',', '.'),
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
