<?php

namespace Controller;

use Core\Controller;

class Home extends Controller
{

    public function index()
    {
        $this->data['lang'] = $this->load->language('home');
        $this->load->view('home', $this->data);
    }


    public function sayHello()
    {
        echo 'Hello world';
    }

}