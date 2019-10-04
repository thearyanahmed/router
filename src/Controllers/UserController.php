<?php

namespace Prophecy\Router\Controllers;

class UserController {

    public function index()
    {
        return json_encode('hello i am from index');
    }
}