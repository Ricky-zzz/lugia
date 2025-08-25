<?php

class UserController extends Controller {
    public function dashboard()
    {
        $this->view("user/dashboard");
        exit;
    }
    }
