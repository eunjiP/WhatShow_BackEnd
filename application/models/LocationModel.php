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
        "   SELECT region_nm AS optionList1 FROM region_code ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function optionList2(&$param) {
        $sql = 
        "  SELECT t1.sub_nm AS optionList2
            FROM subregion_code t1
            INNER JOIN region_code t2 
            WHERE t1.root_code = :t1.root_code
            AND t2.root_code = t1.root_code       
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt-> bindValue(":t1.root_code", $param["t1.root_code"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}