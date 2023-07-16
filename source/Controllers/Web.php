<?php

namespace Source\Controllers;

class Web {

    /**
     * @return void
     */
    public function index()
    {
        require viewsPath('home');
    }

    /**
     * @return void
     */
    public function ajax()
    {
        require requireItem('resources/ajax.php');
    }
}