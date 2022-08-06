<?php
namespace application\models;
use PDO;

class UserModel extends Model{
    public function signup(&$param){
        $sql = "INSERT INTO t_user
        (uuid, nickname)
        VALUES
        (':uuid', ':nickname')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":uuid", $param["uuid"]);
        $stmt->bindValue(":nickname", $param["nickname"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }
}