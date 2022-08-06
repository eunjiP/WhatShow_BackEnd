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
        $sql = "INSERT INTO t_user
        (uuid, nickname)
        VALUES
        (:uuid, :nickname)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":uuid", $param["uuid"]);
        $stmt->bindValue(":nickname", $param["nickname"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }
}