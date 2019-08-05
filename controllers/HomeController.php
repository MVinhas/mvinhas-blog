<?php

namespace controllers;

use models\Home as Home;

class HomeController extends Controller
{

    public function index()
    {
        $model = new Home();
        if ($model->checkUsers() == false) {
            $this->setup();
        } else {
            $this->path = 'home/'.__FUNCTION__;
            $this->callTemplate($this->path);
        }
    }

    public function setup()
    {
        $model = new Home();
        echo $this->template->render('main/setup.html');
    }

    public function register()
    {
        echo "Dados recebidos:<br>" . "<pre>" , print_r($_POST) , "</pre>";
    }
}
