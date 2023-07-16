<?php

namespace Source\Controllers;

class Web {

    public function index()
    {
        require viewsPath('home');
    }

    public function ajax() 
    {
        require requireItem('resources/ajax.php');
    }
}