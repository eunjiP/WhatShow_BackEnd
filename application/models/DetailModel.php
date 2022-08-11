<?php
    namespace application\models;
    use PDO;

    class DetailModel extends Model {
        // 영화 상세정보
        public function getMovieInfo(&$param) {
            $sql = 
            "   SELECT * FROM t_movies
                WHERE movie_code = :movie_code
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt -> execute([$param['movie_code']]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        // 영화 리뷰 저장
        public function insReview(&$param) {
            $sql =
            " INSERT INTO t_review
            (iuser, movie_code, ctnt, movie_score)
            VALUE
            (:iuser, :movie_code, :ctnt, :movie_score)
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt -> execute([$param['iuser'],$param['movie_code'],$param['ctnt'],$param['movie_score']]);
            return intval($this->pdo->lastInsertId());
        }
        
        // 각 영화에 대한 리뷰 리스트
        public function getReviewList(&$param) {
            $sql = 
            "   SELECT A.*, B.nickname FROM t_review A
                INNER JOIN t_user B
                ON A.iuser = B.iuser
                WHERE A.movie_code = :movie_code
                ORDER BY A.created_at DESC
                LIMIT :revlimit
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt -> execute([$param['movie_code'], $param['revlimit']]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }