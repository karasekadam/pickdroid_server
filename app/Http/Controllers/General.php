<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Matches;
use App\Models\Leagues;
use App\Models\Other_values;
use Carbon\Carbon;

class General extends Controller
{
	/* vkládání lig do tabulky
        $ligy = Matches::select("league")->get();
        foreach ($ligy as $liga) {
            $check = Leagues::where("name_538", $liga->league)->get();
            if (!($check->first())) {

                $league = new Leagues();
                $league->sport = "Football";
                $league->country = "Default";
                $league->name_538 = $liga->league;
                $league->name_fortuna = "-";
                $league->save();

            }

        }*/


    public function getMatches() {
    	$sport = request("sport");   //nešlo mi to použít jako parametr místo Matches, tak buď na to přijdu, nebo tam budou ify, když nebude moc sportů
        $league = request("league");
        $match = request("id");     // pro vyhledávání, aby se dal zobrazit jednotlivý zápas, pozděj to stejně bude asi potřeba pro všechny
        if ($league) {
            $matches = Matches::where("league", $league)->where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->get();
        }

        else if ($match) {
            $matches = Matches::where("id", $match)->get();
        }

        else {
            $matches = Matches::where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->take(30)->get();
        }

        return $matches;
    }

    public function getLeagues() {
    	$leagues = Leagues::select("country", "name_538")->take(6)->get();
        return $leagues;
    }

    public function getCountries() {
   		$countries = Leagues::select("country")->distinct()->get();
   		return $countries;
    }

    public function getOther() {
    	$content = Other_values::first()->get();
    	return $content;
    }
}
