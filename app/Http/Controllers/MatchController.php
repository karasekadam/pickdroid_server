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
        $countries = $this->general->getCountries();
        $content = $this->general->getOther();

        if ($user == "admin") {
            return redirect()->route("adm_" . $route);
        } else {
            return view($route, ["leagues"=>$leagues, "countries"=>$countries, "matches"=>$matches, "content"=>$content]);
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
        /*
        $user = $data->session()->get("user");
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        
        return view('blog', ["leagues"=>$leagues, "countries"=>$countries, "content"=>$content]);*/
    }

    public function aboutus(Request $data) {
        return $this->check_and_redirect('aboutus', $data);
    }

    public function adm_blog() {
        $matches = $this->general->getMatches();
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        $content = $this->general->getOther();
        return view('adm_blog', ["leagues"=>$leagues, "countries"=>$countries, "content"=>$content]);
    }

    public function adm_home() {
        $matches = $this->general->getMatches();
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        return view('adm_home', ["leagues"=>$leagues, "countries"=>$countries, "matches"=>$matches]);
    }

}
