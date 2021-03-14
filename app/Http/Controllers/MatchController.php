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

    public function home() {
        $matches = $this->general->getMatches();
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        return view('home', ["matches"=>$matches, "leagues"=>$leagues, "countries"=>$countries]);
    }

    public function login() {
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        return view('login', ["leagues"=>$leagues, "countries"=>$countries]);
    }

    public function blog() {
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        $content = $this->general->getOther();
        return view('blog', ["leagues"=>$leagues, "countries"=>$countries, "content"=>$content]);
    }

    public function aboutus() {
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        return view('aboutus', ["leagues"=>$leagues, "countries"=>$countries]);
    }

    public function adm_blog() {
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        $content = $this->general->getOther();
        return view('adm_blog', ["leagues"=>$leagues, "countries"=>$countries, "content"=>$content]);
    }

    public function adm_matches() {
        $matches = Matches::where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->take(30)->get();
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        return view('adm_matches', ["leagues"=>$leagues, "countries"=>$countries, "matches"=>$matches]);
    }

}
