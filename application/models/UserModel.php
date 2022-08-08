<?php
namespace application\models;
use PDO;

class UserModel extends Model{
    public function sel_user(&$param){
        $sql = "SELECT uuid FROM t_user
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
        $sql = "UPDATE t_user SET nickname=:nickname";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nickname", $param["nickname"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }

    public function ins_fav(&$param){
        $sql = "UPDATE t_user SET tag=:tag WHERE uuid=:uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":tag", $param["tag"]);
        $stmt->bindValue(":uuid", $param["uuid"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}