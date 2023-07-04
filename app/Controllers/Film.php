<?php

namespace App\Controllers;

use App\Controllers\BaseController;

//step 1
use App\Models\FilmModel;
use App\Models\GenreModel;

class Film extends BaseController
{

    //step 2
    protected $film;
    protected $genre;
    //step 3 buat fungsi construct untuk inisiasislass model
    public function __construct()
    {
        //step 4
        $this->film = new FilmModel();
        $this->genre = new GenreModel();
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
    public function add(){
        $data["genre"] = $this->genre->getAlldata();
        $data["errors"] = session('errors');
        return view("film/add", $data);
    }
    
    public function store(){
        $validation = $this->validate([
            'nama_film' => [
                'rules' => 'required',
                'errors'=> [
                    'required' => 'Kolom Nama Film Harus Diisi'
                ]
            ],
            'id_genre' => [
                'rules' => 'required',
                'errors'=> [
                    'required' => 'Kolom Genre Harus Diisi'
                ]
            ],
            'duration' => [
                'rules' => 'required',
                'errors'=> [
                    'required' => 'Kolom Durasi Harus Diisi'
                ]
            ],
            'cover' => [
                'rules' => 'uploaded[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]|max_size[cover,2048] ',
                'errors'=> [
                    'uploaded' => 'Kolom Cover Harus berisi File',
                    'mime_in' => 'Tipe file pada kolom cover harus berupa jpg, jpeg atau png',
                    'max_size' => 'Ukuran file pada kolom cover melebihi batas maksimum'
                ]
            ]
        ]);
        if (!$validation){
            $errors = \Config\Services::validation()->getErrors();
            return redirect()->back()->withInput()->with('errors',$errors);
        }
        $image = $this->request->getFile('cover');

        //Generate nama File unik
        $imageName = $image->getRandomName();
        //Pindahkan file ke direktori penyimpanan
        $image->move(ROOTPATH . 'public/assets/cover/', $imageName);

        $data = [
            'nama_film' => $this->request->getPost('nama_film'),
            'id_genre' => $this->request->getPost('id_genre'),
            'duration' => $this->request->getPost('duration'),
            'cover' => $imageName,
        ];
        $this->film->save($data);
        session()->setFlashData('success', 'Data berhasil disimpan');
        return redirect()->to('/film');
    }
    public function update($id)
    {
        $decryptedId = decryptUrl($id);
        $data["genre"] = $this->genre->getAllData();
        $data["errors"] = session('errors');
        $data["dataFilm"] = $this->film->getDataByID($decryptedId);
        return view("film/edit", $data);
    }
    public function edit(){
        $validation = $this->validate([
            'nama_film' => [
                'rules' => 'required',
                'errors'=> [
                    'required' => 'Kolom Nama Film Harus Diisi'
                ]
            ],
            'id_genre' => [
                'rules' => 'required',
                'errors'=> [
                    'required' => 'Kolom Genre Harus Diisi'
                ]
            ],
            'duration' => [
                'rules' => 'required',
                'errors'=> [
                    'required' => 'Kolom Durasi Harus Diisi'
                ]
            ],
            'cover' => [
                'rules' => 'mime_in[cover,image/jpg,image/jpeg,image/png]|max_size[cover,2048] ',
                'errors'=> [
                    'mime_in' => 'Tipe file pada kolom cover harus berupa jpg, jpeg atau png',
                    'max_size' => 'Ukuran file pada kolom cover melebihi batas maksimum'
                ]
            ]
        ]);
        if (!$validation){
            $errors = \Config\Services::validation()->getErrors();
            return redirect()->back()->withInput()->with('errors',$errors);
        }
        $image = $this->request->getFile('cover');

        //Ambil data lama
        $film =$this->film->find($this->request->getPost('id'));
        //tambah request ID
        $data=[
            'id' => $this->request->getPost('id'),
            'nama_film' => $this->request->getPost('nama_film'),
            'id_genre' => $this->request->getPost('id_genre'),
            'duration' => $this->request->getPost('duration'),
        ];
        $cover = $this->request->getFile('cover');
        if ($cover->isValid() && !$cover->hasMoved()){
            //Generate nama unik
            $imageName = $cover->getRandomName();
            //Pindahkan file ke direktori penyimpanan
            $cover->move(ROOTPATH . 'public/assets/cover', $imageName);
            //Hapus file lama jika ada
            if ($film['cover']){
                unlink(ROOTPATH . 'public/assets/cover' . $film['cover']);
            }
            $data['cover'] = $imageName;
        }

        $this->film->save($data);
        session()->setFlashData('success', 'Data berhasil diperbarui');
        return redirect()->to('/film');
    }
    public function destroy($id)
    {
        $decryptedId = decryptUrl($id);
        $this->film->delete($decryptedId);
        session()->setFlashdata('success', 'Data Berhasil Dihapus.');
        return redirect()->to('/film');
    }
}
