<?php namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model{

    protected $table = "admin";
    protected $primarykey ="email";
    protected $allowedField = [
        'usename','password','nama_lengkap','email','token','last_login'
    ];

    public function getData($param){

        $builder = $this->table('admin')->first();
        $builder->where('username',$param);
        $builder->orwhere('email',$param);
        $query = $builder->get();
        return $query->getRowArray();

    }

    public function updateData($data){

        $builder = $this->table($this->table);
        if($builder->save($data)){
            return true;
        } else {
            return false;
        }

    }

}