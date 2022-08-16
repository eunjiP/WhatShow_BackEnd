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

        //추천 추가 및 삭제 함수
        public function changeRecommend(&$param) {
            if($param['fn'] === 'add') {
                $sql = "INSERT INTO t_recommend
                (movie_code, iuser)
                VALUES
                (:movie_code, :iuser)";
            } else if($param['fn'] === 'remove') {
                $sql = "DELETE FROM t_recommend
                WHERE movie_code = :movie_code
                AND iuser = :iuser";
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":movie_code", $param['movie_code']);
            $stmt->bindValue(":iuser", $param['iuser']);
            $stmt->execute();
            return $stmt->rowCount();
        }

        //대댓글 리스트
        public function reviewListCmt(&$param){
            $sql = "SELECT B.nickname, A.comment_cnt, A.create_at  FROM t_comment A
                    INNER JOIN t_user B
                    ON A.iuser = B.iuser
                    WHERE i_review = :i_review";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":i_review", $param['i_review']);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        //대댓글 작성
        public function insCmt(&$param){
            $sql = "INSERT INTO t_comment
                    (i_review, iuser, comment_cnt)
                    VALUE
                    (:i_review, :iuser, :comment_cnt)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":i_review", $param['i_review']);
            $stmt->bindValue(":iuser", $param['iuser']);
            $stmt->bindValue(":comment_cnt", $param['comment_cnt']);
            $stmt->execute();
            return $stmt->rowCount();
        }
    }