<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\GenreModel;

class Genre extends BaseController
{
    protected $genre;

    public function __construct()
    {
        $this->genre = new GenreModel();
    }
    public function index()
    {
        $data['data_genre'] = $this->genre->getAllGenre();
        return view("genre/genre", $data);
    }
    public function all()
    {
        $data['genre'] = $this->genre->getAllData();
        return view("genre/genre", $data);
    }
}
