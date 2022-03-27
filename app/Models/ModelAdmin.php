<?php namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model{

    protected $table = "admin";
    protected $primarykey ="email";
    protected $allowedField = [
        'username','password','nama_lengkap','email','token','last_login'
    ];

    public function getData($parameter){

        $builder = $this->table($this->table);
        $builder->where('username',$parameter);
        $builder->orwhere('email',$parameter);
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