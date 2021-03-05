<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Leagues;
use App\Models\Matches;

class MatchController extends Controller
{

    public function home() {
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


        /*$sport = request("sport");   //nešlo mi to použít jako parametr místo Matches, tak buď na to přijdu, nebo tam budou ify, když nebude moc sportů
        $league = request("league");
        if ($league) {
            $matches = Matches::where("league", $league)->where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->get();
        }
        else {
            $matches = Matches::where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->take(30)->get();
        }
        $leagues = Leagues::select("name_538")->take(5)->get();
        $countries = Leagues::select("country", "name_538")->distinct()->get();
        return view('home', ["matches"=>$matches, "main_leagues"=>$leagues, "countries"=>$countries]);*/

        $sport = request("sport");   //nešlo mi to použít jako parametr místo Matches, tak buď na to přijdu, nebo tam budou ify, když nebude moc sportů
        $league = request("league");
        if ($league) {
            $matches = Matches::where("league", $league)->where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->get();
        }
        else {
            $matches = Matches::where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->take(30)->get();
        }
        $leagues = Leagues::select("country", "name_538")->take(6)->get();
        $countries = Leagues::select("country")->distinct()->get();
        return view('home', ["matches"=>$matches, "leagues"=>$leagues, "countries"=>$countries]);
    }


    public function login() {
        $leagues = Matches::where("date", ">=", Carbon::now())->select("league")->distinct()->take(4)->get();
        return view('login', ["leagues"=>$leagues]);
    }
    public function blog() {
        $leagues = Matches::where("date", ">=", Carbon::now())->select("league")->distinct()->take(4)->get();
        return view('blog', ["leagues"=>$leagues]);
    }
    public function aboutus() {
        $leagues = Matches::where("date", ">=", Carbon::now())->select("league")->distinct()->take(4)->get();
        return view('aboutus', ["leagues"=>$leagues]);
    }
    public function welcome() {
        return view('welcome');
    }
}
