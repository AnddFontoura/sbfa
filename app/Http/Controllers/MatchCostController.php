<?php

namespace App\Http\Controllers;

use App\MatchCost;
use App\Matches;
use App\Team;
use Illuminate\Http\Request;

class MatchCostController extends Controller
{
    /**
     * Formulário de incluir custos em uma partida
     *
     * @param int $teamId
     * @param int $matchId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(int $teamId, int $matchId)
    {
        $team = Team::where('id', $teamId)->first();
        $match = Matches::where('id', $matchId)->first();
        $matchCost = MatchCost::where('team_id', $teamId)
            ->where('match_id', $matchId)
            ->first();

        return view('match_cost.form', compact('team', 'match', 'matchCost'));
    }

    /**
     * @param Request $request
     * @param int $teamId
     * @param int $matchId
     * @return string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, int $teamId, int $matchId)
    {
        $this->validate($request, [
            'match_field_cost' => 'required|numeric|between:0.00,9999.99',
            'match_referees_cost' => 'nullable|numeric|between:0.00,9999.99',
            'extra_costs' => 'nullable|numeric|between:0.00,9999.99',
            'extra_costs_description' => 'nullable|string|max:10000',
        ]);

        $data = $request->except('_token');
        $data['team_id'] = $teamId;
        $data['match_id'] = $matchId;
        $data['match_total_cost'] = $data['match_field_cost'] + $data['match_referees_cost'] + $data['extra_costs'];

        $matchCost = MatchCost::where('team_id', $teamId)
            ->where('match_id', $matchId)
            ->first();

        if ($matchCost) {
            MatchCost::where('team_id', $teamId)
                ->where('match_id', $matchId)
                ->update($data);
        } else {
            MatchCost::create($data);
        }

        return redirect('configuration/team/' . $teamId);
    }
}
