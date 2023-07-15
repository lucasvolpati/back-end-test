<?php

namespace Source\Controllers;

class Web {

    public function index()
    {
        require viewsPath('home');
    }
}