<?php
namespace application\controllers;
use application\libs\Application;

class UserController extends Controller{
    public function sel_user(){
        $url = getUrlPaths();
        $param = [
            'uuid' => $url[2]
        ];
        $result = $this->model->sel_user($param);
        return [_RESULT => $result];
    }

    public function signup(){
        $json = getJson();
        $param = [
            'uuid' => $json[0],
            'nickname'=> $json[1]
        ];
        $result = $this->model->signup($param);
        if($result){
            $this->flash(_LOGINUSER, $result);
            return [_RESULT => $result];
        }
        return [_RESULT => $result];
    }
}
