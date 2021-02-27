<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches;
use Carbon\Carbon;

class MatchController extends Controller
{
    public function home() {
        $sport = request("sport");   //nešlo mi to použít jako parametr místo Matches, tak buď na to přijdu, nebo tam budou ify, když nebude moc sportů
        $league = request("league");
        if ($league) {
            $matches = Matches::where("league", $league)->where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->get();
        }
        else {
            $matches = Matches::where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->take(30)->get();
        }
        $leagues = Matches::where("date", ">=", Carbon::now())->select("league")->distinct()->take(10)->get();
        return view('home', ["matches"=>$matches, "leagues"=>$leagues]);
    }
    public function login() {
        $leagues = Matches::where("date", ">=", Carbon::now())->select("league")->distinct()->take(10)->get();
        return view('login', ["leagues"=>$leagues]);
    }
    public function blog() {
        $leagues = Matches::where("date", ">=", Carbon::now())->select("league")->distinct()->take(10)->get();
        return view('blog', ["leagues"=>$leagues]);
    }
    public function aboutus() {
        $leagues = Matches::where("date", ">=", Carbon::now())->select("league")->distinct()->take(10)->get();
        return view('aboutus', ["leagues"=>$leagues]);
    }
    public function welcome() {
        return view('welcome');
    }
}
