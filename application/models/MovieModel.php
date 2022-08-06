<?php
    namespace application\models;
    use PDO;

class MovieModel extends Model {
    // 영화 전체 리스트 가지고 오는 함수
    public function selList() {
        $sql = "SELECT * FROM t_movies";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //일일박스오피스 DB저장 함수
    public function insBoxoffice(&$param) {
        $sql = "INSERT INTO t_boxoffice
            SET boxoffice_date = :date, 1th_nm = :1,
            2th_nm = :2, 3th_nm = :3, 4th_nm = :4, 5th_nm = :5,
            6th_nm = :6, 7th_nm = :7, 8th_nm = :8, 9th_nm = :9, 10th_nm = :10";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":date", $param['date']);
        $stmt->bindValue(":1", $param['1']);
        $stmt->bindValue(":2", $param['2']);
        $stmt->bindValue(":3", $param['3']);
        $stmt->bindValue(":4", $param['4']);
        $stmt->bindValue(":5", $param['5']);
        $stmt->bindValue(":6", $param['6']);
        $stmt->bindValue(":7", $param['7']);
        $stmt->bindValue(":8", $param['8']);
        $stmt->bindValue(":9", $param['9']);
        $stmt->bindValue(":10", $param['10']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    //가지고 온 박스오피스의 영화정보가 DB 안에 있는지 확인하는 함수
    
    
    //tag 들고오는 함수
    public function getTag() {
        $sql = "SELECT movie_genre FROM t_movies
                GROUP BY movie_genre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}