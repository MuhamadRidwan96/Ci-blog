<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ModelAdmin;
use Exception;

class Admin extends BaseController{


    function __construct()
    {
        $this->model = new ModelAdmin();
        $this->validation = \Config\Services::validation();
        helper("cookie");

    }

    public function login(){
        $data = [];

        //session()->destroy();
        //exit();
        //cek cookie
        if(get_cookie('cookie_username') && get_cookie('cookie_password')){
            $username = get_cookie('cookie_username');
            $password = get_cookie('cookie_password');

            $data_admin = $this->model->getData($username);
            if($password != $data_admin['password']){
                $err[] = 'akun yang anda masukan tidak sesuai';
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);

                delete_cookie('cookie_username');
                delete_cookie('cookie_password');

                return redirect()->to("admin/login");
            }

            $akun = [
                'akun_username' => $username,
                'akun_nama_lengkap' => $data_admin['nama_lengkap'],
                'akun_email' => $data_admin['email']
            ];

            session()->set($akun);
            return redirect()->to("admin/success");
        }

        if($this->request->getMethod()=='post'){
           
            $rules = [
                'username' => [
                    'rules' => 'required',
                    'error' => [
                        'required' => 'silahkan masukan username'
                    ]
                    ],
                    'password' => [
                        'rules' => 'required',
                        'error' => [
                            'required' => 'silahkan masukan password'
                        ]
                    
                    ]
                 ];

                 if(!$this->validate($rules)){
                     session()->setFlashdata("warning",$this->validation->getErrors());
                     return redirect()->to("admin/login");
                 }

                 $username = $this->request->getVar('username');
                 $password = $this->request->getVar('password');
                 $remember_me =$this->request->getVar('remember_me');

                $data_admin = $this->model->getData($username);

                 if(!password_verify($password,$data_admin['password'])){
                     $arr[] = "akun yang anda masukan tidak sesuai.";
                     session()->setFlashdata('username',$username);
                     session()->setFlashdata('warning',$arr);
                     return redirect()->to("admin/login");
                 }

                 if($remember_me=='1'){
                     set_cookie("cookie_username", $username, 3600 * 24 * 30);
                     set_cookie("cookie_password", $data_admin['password'], 3600 * 24 *30);
                 }

                 $akun = [
                     'akun_username' => $data_admin['username'],
                     'akun_nama_lengkap' => $data_admin['nama_lengkap'],
                     'akun_email'=> $data_admin['email']
                 ];

                 session()->set($akun);
                 return redirect()->to("admin/success")->withCookies();
        }
       echo view('admin/v_login',$data);

    }

    function success(){

       print_r(session()->get());
       echo "isi cookie username ".get_cookie("cookie_username ") . 
       "dan password " . get_cookie("cookie_password");
    }

    function logout(){

        delete_cookie('cookie_username');
        delete_cookie('cookie_password');
        session()->destroy();
        if(session()->get('akun_username') != ''){
            session()->setFlashdata("success", "anda berhasil logout");
        }
        echo view("admin/v_login");
    }
    function lupapassword(){
        $err = [];
        echo view("admin/v_lupapassword");
    }




}