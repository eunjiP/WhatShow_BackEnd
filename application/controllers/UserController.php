<?php
namespace application\controllers;
use application\libs\Application;

class UserController extends Controller{
    public function signup(){
        $json = getJson();
        $result = $this->model->signup($json);
        if($result){
            $this->flash(_LOGINUSER, $result);
            return [_RESULT => $result];
        }
        return [_RESULT => $result];
    }
}
