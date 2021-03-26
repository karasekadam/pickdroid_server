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

}
