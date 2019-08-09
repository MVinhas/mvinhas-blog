<?php

namespace controllers;

use models\Home as Home;

class HomeController extends Controller
{

    protected $path;

    public function __construct()
    {
        parent::__construct();
        $file = pathinfo(__FILE__, PATHINFO_FILENAME);
        $this->path = $this->getDirectory($file);
    }

    public function index()
    {
        $model = new Home();
        if ($model->checkUsers() === false) {
            $this->setup();
        } else if ($model->checkUsers() === '-1'){
            $migrations = new \migrations\Setup();
            $migrations->index();
        } else {            
            $home = $this->getFile($this->path, __FUNCTION__);
            echo $this->callTemplate($home);
        }
    }

    private function setup()
    {
        
        $model = new Home();
        $setup = $this->getFile($this->path, __FUNCTION__);
        echo $this->callTemplate($setup);
        
    }

    public function register()
    {
        //Tratar o $_POST
    }
}
