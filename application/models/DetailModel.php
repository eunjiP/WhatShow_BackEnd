<?php
    namespace application\models;
    use PDO;

    class DetailModel extends Model {
        public function getReviewList(&$param) {
            $sql = 
            "   SELECT * FROM t_review
                WHERE movie_code = :movie_code
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt -> execute([$param['movie_code']]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }