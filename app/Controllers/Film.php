<?php

namespace App\Controllers;

use App\Controllers\BaseController;

//step 1
use App\Models\FilmModel;

class Film extends BaseController
{

    //step 2
    protected $film;
    //step 3 buat fungsi construct untuk inisiasislass model
    public function __construct()
    {
        //step 4
        $this->film = new FilmModel();
    }


    public function index()
    {
        $data['data_film'] = $this->film->getAllDataJoin();
        return view("film/index", $data);
    }

    public function all(){
        $data['semuafilm'] = $this->film->getAllDataJoin();
        return view("film/semuafilm", $data);
    }

    public function find_by_id(){
        dd($this->film->getDataByID(10));
    }

    public function film_by_genre(){
        dd($this->film->getDataBy('comedy'));
    }

    public function orderBy_created(){
        dd($this->film->getOrderBy());
    }

    public function limit_5(){
        dd($this->film->getLimit());
    }
}
