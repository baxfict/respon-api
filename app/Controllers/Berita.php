<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\MBerita;
use CodeIgniter\RESTful\ResourceController;

class Berita extends ResourceController
{   
    use ResponseTrait;
  
    function __construct(){
        $this->MBerita = new MBerita();
    }

    
    public function index()
    {
        return $this->respond($this->MBerita->findAll());
    }


    public function show($id = null){
        $data = $this->MBerita->where('id',$id)->findAll();
        if($data){
            return $this->respond($data,200);
        }else{
            return $this->failNotFound("Data Tidak Ditemukan");
        }
    }

    public function create(){
        $data = [
            'tanggal' => $this->request->getVar('tanggal'),
            'isi' => $this->request->getVar('isi'),
            'asal' => $this->request->getVar('asal'),
        ];

        // $this->MBerita->save($data);

        if (!$this->MBerita->save($data)){
            return $this->fail($this->MBerita->errors());
        }

        $respon = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil Memasukkan Data'
            ]
        ];

        return $this->respond($respon);
    }

    public function update($id = null){

        $data = $this->request->getRawInput();
        $data['id'] = $id;

        $isExists = $this->MBerita->where('id',$id)->findAll();

        if(!$isExists){
            return $this->failNotFound("Data Tidak Ditemukan");
        }

        //error while save
        if(!$this->MBerita->save($data)){
            $this->fail($this->MBerita->errors());
        }
        
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil update Data'
            ]

        ];

        return $this->respond($response);

    }

    public function delete($id = null){

        $data = $this->MBerita->where('id',$id)->findAll();

        if($data){
            $this->MBerita->delete($id);
            $response =[
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Berhasil menghapus data'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data Tidak ditemukan');
        }
    }
}
