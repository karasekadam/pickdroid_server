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

    // controller pro ajax dotaz
    public function search_match(Request $request)
    {
        if($request->ajax())
        {
            $output="";
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
        $teams = Clubs::select("538_name", "our_name")->where("league", $data->league)->distinct()->get();
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

}
