<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $title="Data Mahasiswa";
        $data['mahasiswa']=array(
                'nim'=>'1905021021',
                'nama'=>'Made Andika Ary Wiguna',
                'alamat'=>'Desa Jinengdalem',
                'nohp'=>'089697338542',
                'email'=>'andikawiguna82@gmail.com'
        );
        return view('admin.beranda', compact('title','data'));
    }
    public function dashboard(){
        $title="Data Dashboard";

        return view('admin.dashboard', compact('title'));
    }
}