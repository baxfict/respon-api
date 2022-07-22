<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class MBerita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul','isi','date'];
}