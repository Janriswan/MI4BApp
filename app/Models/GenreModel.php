<?php

namespace App\Models;

use CodeIgniter\Model;

class GenreModel extends Model
{
    protected $table            = 'genre';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['genre'];

    public function getAllGenre()
    {
        return $this->findAll();
    }

    public function getAllData()
    {
        return $this->findAll();
    }
}
