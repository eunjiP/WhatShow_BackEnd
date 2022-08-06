<?php
namespace application\models;
use PDO;

class LocationModel extends Model {
    public function getLocalList() {
        $sql =
        "   SELECT * FROM region_code
            INNER JOIN subregion_code
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function LocalList1(&$param) {
        $sql = 
        "   SELECT t1.*, t2.sub_nm
            FROM region_code t1
            INNER JOIN subregion_code t2
            ON t1.root_code = t2.root_code
            WHERE t1.root_code = t2.root_code        
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}