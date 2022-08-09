<?php
namespace application\models;
use PDO;

class UserModel extends Model{
    //유저정보 가져오기
    public function sel_user(&$param){
        $sql = "SELECT * FROM t_user
                WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$param['uuid']]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function signup(&$param){
        $sql = "INSERT IGNORE INTO t_user
        (uuid, nickname)
        VALUES
        (:uuid, :nickname)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":uuid", $param["uuid"]);
        $stmt->bindValue(":nickname", $param["nickname"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }
    //유저 닉네임 변경
    public function upd_nick(&$param){
        $sql = "UPDATE t_user SET nickname=:nickname 
                WHERE uuid=:uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nickname", $param["nickname"]);
        $stmt->bindValue(":uuid", $param["uuid"]);

        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }

    //유저 favtag 셀렉트
    public function sel_fav(&$param){
        $sql = "SELECT tag FROM t_user
                WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$param['uuid']]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    //유저 favtag 추가 및 업데이트
    public function ins_fav(&$param){
        $sql = "UPDATE t_user SET tag=:tag WHERE uuid=:uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":tag", $param["tag"]);
        $stmt->bindValue(":uuid", $param["uuid"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    //유저 rootcode 저장
    public function ins_rootcode(&$param){
        $sql = "UPDATE t_user SET root_code=:rootcode WHERE uuid=:uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":rootcode", $param["rootcode"]);
        $stmt->bindValue(":uuid", $param["uuid"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    //유저 프로필 사진 업데이트
    public function upd_img(&$param){
        $sql = "UPDATE t_user
                SET user_img = :user_img
                WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":user_img", $param["user_img"]);
        $stmt->bindValue(":uuid", $param["uuid"]);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
}