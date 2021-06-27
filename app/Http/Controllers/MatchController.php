<?php // udělat: ajax dotaz na ligy změnit, aby byl podobnej jak na týmy
// vymazat null hodnoty z hledání ajaxu

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Leagues;
use App\Models\Matches;
use App\Models\Clubs;
use App\Models\Other_values;
use App\Http\Controllers\General;

class MatchController extends Controller
{

    public function __construct() {
        $this->general = new General();
    }

    public function check_and_redirect($route, $data) {
        $user = $data->session()->get("user");
        $matches = $this->general->getMatches($data);
        $leagues = $this->general->getLeagues($data);
        $top_leagues = $this->general->getTopLeagues($data);
        $countries = $this->general->getCountries($data);
        $content = $this->general->getOther($data);

        if ($user == "admin" && $route != "login") {
            if ($route == "add") {
                $team_country = $data->session()->get("team_country");
                $leag_country = $data->session()->get("leag_country");
                $league = $data->session()->get("league");

                return view("adm_" . $route, ["leagues"=>$leagues, "top_leagues"=>$top_leagues, "countries"=>$countries, "matches"=>$matches, "content"=>$content, "team_country"=>$team_country, "leag_country"=>$leag_country, "league"=>$league]);
                
            } else if ($route == "logo") {
                $team_logo = $data->session()->get("team_logo");
                $league_logo = $data->session()->get("league_logo");
                $country_logo = $data->session()->get("country_logo");

                return view("adm_logo", ["leagues"=>$leagues, "top_leagues"=>$top_leagues, "countries"=>$countries, "matches"=>$matches, "content"=>$content, "country"=>$country_logo, "league"=>$league_logo, "team"=>$team_logo]);
            }

            if ($data->session()->get("notification") == "1") {
                $empty_countries = Leagues::where("country", "Default")->get();
            } else {
                $empty_countries = [];
            }

            return view("adm_" . $route, ["leagues"=>$leagues, "top_leagues"=>$top_leagues, "countries"=>$countries, "matches"=>$matches, "content"=>$content, "empty_countries"=>$empty_countries]);
        } else {
            return view($route, ["leagues"=>$leagues, "top_leagues"=>$top_leagues, "countries"=>$countries, "matches"=>$matches, "content"=>$content, "user"=>$user]);
        }
    }

    // ajax dotaz pro filter
    public function search_match_filter(Request $request)
    {
        $league = request("league");
        $id = request("id");
        $search = request("search");    // při kliku na search hodí na domovskou s touto proměnou
        date_default_timezone_set("Europe/Prague");
        $now = date("Y-m-d");
        $day = date("d");
        $hours = (int) date("h") + (int) request("hours");

        if ($league) {
            $matches = Matches::where("league", $league)->where("date", ">=", $now)->orderBy("priority", "asc")->orderBy("date", "asc")->get();
        } elseif ($id) {
            $matches = Matches::where("id", $id)->get();
        } elseif ($search) {
            $matches = Matches::where('team1','LIKE', "% ".$search."%")->orWhere('team1','LIKE',$search."%")->orWhere('team2','LIKE', "% ".$search."%")->orWhere('team2','LIKE',$search."%")->get();
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
            $output="";
            $matches=Matches::where('team1','LIKE', "% ".$request->search."%")->orWhere('team1','LIKE',$request->search."%")->orWhere('team2','LIKE', $request->search."%")->orWhere('team2','LIKE','% '.$request->search."%")->get();
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
        $leagues = Leagues::select("name_538", "our_name")->where("country", $data->country)->distinct()->get();
        $leagues_array = [];
        foreach($leagues as $league) {
            if (!is_null($league->our_name)) {
                array_push($leagues_array, $league->our_name);
            }
            else {
                array_push($leagues_array, $league->{'name_538'});
            }
        }

        $leagues_unique = array_values(array_unique($leagues_array));

        return Response($leagues_unique);
    }

    public function find_teams(Request $data) {
        $leagues = Leagues::where("name_538", $data->league)->select("name_538")->get();

        if (count($leagues) == 0) {
            $leagues = Leagues::where("our_name", $data->league)->select("name_538", "our_name")->get();
        }

        if (is_null($leagues[0]->name_538)) {
            $final = $leagues[0]->our_name;
        } else {
            $final = $leagues[0]->name_538;
        }

        $teams = Clubs::select("538_name", "our_name")->where("league", $final)->distinct()->get();
        $teams_array = [];
        foreach($teams as $team) {
            if(!is_null($team->our_name)) {
                array_push($teams_array, $team->our_name);
            }
            else {
                array_push($teams_array, $team->{'538_name'});
            }

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

    public function adm_add_country(Request $data) {
        return $this->check_and_redirect('add_country', $data);
    }

    public function adm_logo(Request $data) {
        return $this->check_and_redirect('logo', $data);
    }

    public function adm_fill(Request $data) {
        return $this->check_and_redirect('fill', $data);
    }
}
