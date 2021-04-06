<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Leagues;
use App\Models\Matches;
use App\Models\Other_values;
use App\Http\Controllers\General;

class MatchController extends Controller
{

    public function __construct() {
        $this->general = new General();
    }

    public function check_and_redirect($route, $data) {
        $user = $data->session()->get("user");
        $matches = $this->general->getMatches();
        $leagues = $this->general->getLeagues();
        $top_leagues = $this->general->getTopLeagues();
        $countries = $this->general->getCountries();
        $content = $this->general->getOther();

        if ($user == "admin" && $route != "login") {
            return view("adm_" . $route, ["leagues"=>$leagues, "top_leagues"=>$top_leagues, "countries"=>$countries, "matches"=>$matches, "content"=>$content]);
        } else {
            return view($route, ["leagues"=>$leagues, "top_leagues"=>$top_leagues, "countries"=>$countries, "matches"=>$matches, "content"=>$content]);
        }

    }

    // už asi není potřeba, pro jistotu nechávám
    //public function search(Request $data) {
    //    return $this->check_and_redirect("search", $data);
    //}


    public function search_match_filter(Request $request)
    {
        $league = request("league");
        $id = request("id");
        $search = request("search");    // při kliku na search hodí na domovskou s touto proměnou
        $now = date("Y-m-d-h");
        $day = date("d");
        $hours = (int) date("h") + (int) request("hours");

        if ($league) {
            $matches = Matches::where("league", $league)->where("date", ">=", $now)->orderBy("priority", "asc")->orderBy("date", "asc")->get();
        } elseif ($id) {
            $matches = Matches::where("id", $id)->get();
        } elseif ($search) {
            $matches = Matches::where('team1','LIKE', $search."%")->orWhere('team1','LIKE','% '.$search."%")->orWhere('team2','LIKE', $search."%")->orWhere('team2','LIKE','% '.$search."%")->get();
        } else {
            $matches = Matches::where("date", ">=", $now)->orderBy("priority", "asc")->orderBy("date", "asc")->take(30)->get();
        }
        return Response($matches);
    }

    // controller pro ajax dotaz
    public function search_match(Request $request)
    {
        if($request->ajax())
        {
            $matches=Matches::where('team1','LIKE', $request->search."%")->orWhere('team2','LIKE','% '.$request->search."%")->orWhere('team2','LIKE', $request->search."%")->orWhere('team2','LIKE','% '.$request->search."%")->get();
            if($matches)
            {
                return Response($matches); // $output
            }
        }
    }

    public function find_countries(Request $data) {
            $countries = Leagues::select("country")->distinct()->get();
            return Response($countries);
    }

    public function find_leagues(Request $data) {
        $leagues = Leagues::select("name_538")->where("country", $data->country)->distinct()->get();
        return Response($leagues);
    }

    public function find_teams(Request $data) {
        $teams = Matches::select("team1", "team2")->where("league", $data->league)->distinct()->get();
        $teams_array = [];
        foreach($teams as $team) {
            array_push($teams_array, $team->team1, $team->team2);
        }

        $teams_unique = array_values(array_unique($teams_array));

        return Response($teams_unique);
    }

    public function home(Request $data) {
        return $this->check_and_redirect('home', $data);
    }


    public function login(Request $data) {
        return $this->check_and_redirect('login', $data);
    }

    public function blog(Request $data) {
        return $this->check_and_redirect('blog', $data);
    }

    public function aboutus(Request $data) {
        return $this->check_and_redirect('aboutus', $data);
    }

    public function adm_blog(Request $data) {
        return $this->check_and_redirect('blog', $data);
    }

    public function adm_aboutus(Request $data) {
        return $this->check_and_redirect('aboutus', $data);
    }

    public function adm_home(Request $data) {
        return $this->check_and_redirect('home', $data);
    }

    public function adm_add(Request $data) {
        return $this->check_and_redirect('add', $data);
    }

}
