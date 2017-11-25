<?php
/**
 * Created by PhpStorm.
 * User: lingjianhua
 * Date: 2017/5/22
 * Time: 下午4:38
 */
namespace App\Http\Controllers\Doc;

use App\Http\Controllers\Controller;

class DocController extends Controller{

    public function index()
    {
        return view('doc.index');
    }

    public function create()
    {
        return view('doc.create');
    }
}