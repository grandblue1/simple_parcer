<?php 

namespace Src\Controller;


class HomeController extends Controller {
    public function index()
    {
        $this->render('index');
    }
}