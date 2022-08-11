<?php
namespace application\controllers;
use application\libs\Application;

class UserController extends Controller{
    //유저정보 가져오기
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
    //유저 닉네임 변경
    public function upd_nick(){
        $url = getUrlPaths();
        $param = [
            'nickname' => $url[2],
            'uuid' => $url[3]
        ];
        $result = $this->model->upd_nick($param);
        return [_RESULT => $result];
    }
    //유저 favtag 셀렉트
    public function sel_fav(){
        $url = getUrlPaths();
        $param = [
            'uuid' => $url[2]
        ];
        $result = $this->model->sel_fav($param);
        return [_RESULT => $result];
    }

    //유저 favtag 추가 및 업데이트
    public function ins_fav(){
        $url = getUrlPaths();
        $param = [
            'uuid' => $url[2],
            'tag' => $url[3]
        ];
        $result = $this->model->ins_fav($param);
        return [_RESULT => $result];
    }
    
    //유저 rootcode 업데이트
    public function ins_rootcode(){
        $url = getUrlPaths();
        $param = [
            'uuid' => $url[2],
            'rootcode' => $url[3]
        ];
        $result = $this->model->ins_rootcode($param);
        return [_RESULT => $result];
    }

    //유저 이미지 업데이트
    public function upd_img(){
        $urlPaths = getUrlPaths();
        if(!isset($urlPaths[2])) {
            exit();
        }
        $productId = intval($urlPaths[2]);
        $type = intval($urlPaths[3]);
        $json = getJson(); //배열형
        $image_parts = explode(";base64,", $json["image"]); //[0]파일명 및 타입 ;base 65 [1]이미지 로 나눔
        $image_type_aux = explode("image/", $image_parts[0]);  //[0]데이터 [1]파일확장자 로 나눔
        $image_type = $image_type_aux[1];      
        $image_base64 = base64_decode($image_parts[1]); //$image_parts[1] 이미지를 디코딩
        $dirPath = _IMG_PATH . "/" . $productId . "/" . $type;
        $filePath = $dirPath . "/" . uniqid() . "." . $image_type; 
        if(!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        $filename = explode("/", $filePath);
        //$file = _IMG_PATH . "/" . $productId . "/" . $type . "/" . uniqid() . "." . $image_type;
        //$file = "static/" . uniqid() . "." . $image_type;
        $result = file_put_contents($filePath, $image_base64);
        if($result){
            $param = [
                'uuid' => $productId,
                'user_img' => $filename[4],
            ];
            return $this->model->upd_img($param);
        }
        return [_RESULT => $result ? 1 : 0];
    }
    
}