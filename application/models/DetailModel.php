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

        
        //평점의 평균, 추천 수, 내가 추천했는 여부 확인 하는 함수
        public function selMovieScoreAndRecommend(&$param) {
            $movie_code = $param['movie_code'];
            $sql = "SELECT COUNT(A.movie_code) AS recommend, 
            (SELECT count(movie_code) FROM t_recommend WHERE movie_code = $movie_code AND iuser = :iuser) meRecommend,
            ifnull((SELECT AVG(movie_score) FROM t_review WHERE movie_code = $movie_code
            GROUP BY movie_code), 0) AS avgScore
            FROM t_recommend A
            WHERE movie_code = $movie_code";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":iuser", $param['iuser']);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }