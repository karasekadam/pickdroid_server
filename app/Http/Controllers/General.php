<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Matches;
use App\Models\Leagues;
use App\Models\Other_values;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class General extends Controller
{
    public function getMatches(Request $data) {
        $league = request("league");
        $id = request("id");
        $search = request("search");    // při kliku na search hodí na domovskou s touto proměnou
        date_default_timezone_set("Europe/Prague");
        $now = date("Y-m-d");

        $data->session()->put("notification", "0");
        if ($league) {
            $matches = Matches::where("league", $league)->where("date", ">=", $now)->orderBy("priority", "asc")->orderBy("date", "asc")->get();
        } elseif ($id) {
            $matches = Matches::where("id", $id)->get();
        } elseif ($search) {
            $matches = Matches::where('team1','LIKE', "% ".$search."%")->orWhere('team1','LIKE',$search."%")->orWhere('team2','LIKE', "% ".$search."%")->orWhere('team2','LIKE',$search."%")->get();
        } else {
            $data->session()->put("notification", "1");
            $matches = Matches::where("date", ">=", $now)->orderBy("priority", "asc")->orderBy("date", "asc")->take(30)->get();
        }
        return $matches;
    }

    public function getLeagues() {
        // vezme pouze aktuální zápasy z matches a zkombinuje se se státy přes leagues
        // možná není čistej INNER dobře, možná left když nebude zapsaný stát??
        $leagues = DB::select("SELECT country, name_538, our_name FROM (SELECT DISTINCT league, league_id FROM `matches`) AS m INNER JOIN `leagues` ON m.league_id=538_league_id;"); //Leagues::select("country", "name_538")->get();
        return $leagues;
    }

    public function getTopLeagues() {
        // zatím dělá shit, proč to tady je?
        $leagues = DB::table("leagues")->select("country", "name_538", "our_name")->where("id", 15)->orWhere('id',3)->orWhere('id',1)->orWhere('id',7)->orWhere('id',17)->get();

        //DB::select("SELECT country, name_538 FROM (SELECT DISTINCT league FROM `matches`) AS m INNER JOIN `leagues` ON m.league=name_538 LIMIT 5;");
        return $leagues;
    }

    public function getCountries() {
        // vybere z aktuálních zápasů ligy a ty joine se státy z leagues
        $countries = DB::select("SELECT DISTINCT country FROM (SELECT DISTINCT league, league_id FROM `matches`) AS m INNER JOIN `leagues` ON m.league_id=538_league_id WHERE country !='Default';");
        return $countries;
    }

    public function getOther() {
        $content = Other_values::first()->get();
        return $content;
    }
}
