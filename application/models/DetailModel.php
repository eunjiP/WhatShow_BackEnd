<?php
    namespace application\models;
    use PDO;

    class DetailModel extends Model {
        // 영화 상세정보
        public function getMovieInfo($param) {
            $sql = 
            "   SELECT * FROM t_movies
                WHERE movie_code = :movie_code
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt -> execute([$param['movie_code']]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        
        // 각 영화에 대한 리뷰 리스트
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