<?php
namespace application\models;
use PDO;

class LocationModel extends Model {

    public function LocationList(&$param) {
        $sql = 
        "   SELECT t1.*, t2.sub_nm
            FROM region_code t1, subregion_code t2
            WHERE t1.root_code = t2.root_code   
        ";
        if(isset($param["sub_nm"])) {
            $sub_nm = $param["sub_nm"];
            $sql .= "AND t2.root_code = ${$sub_nm}";
        } else {
            if(isset($param["region_nm"])) {
                $region_nm = $param["region_nm"];
                $sql .= " AND t1.region_nm = ${$region_nm}";
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // 카테고리 optionList 설정
    public function optionList1() {
        $sql =
        "   SELECT *  FROM region_code ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function optionList2(&$param) {
        $sql = 
        "   SELECT A.* FROM subregion_code A
            INNER JOIN region_code B 
            ON A.root_code = B.root_code
            WHERE A.root_code = :root_code 
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt-> bindValue(":root_code", $param["root_code"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}