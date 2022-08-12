<?php
namespace application\models;
use PDO;

class RecommendModel extends Model {
    public function selTotalList() {
        $sql = "SELECT movie_code FROM t_movies A";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selMyTag() {
        $sql = "SELECT tag FROM t_user
            WHERE iuser = :iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selTagList(&$param) {
        $tag = $param['tag'];
        $sql = "SELECT movie_code, count(*) as tagScore FROM t_movies A
        WHERE movie_nm LIKE '%$tag%' OR
        movie_genre LIKE '%$tag%' OR
        country LIKE '%$tag%' OR
        director LIKE '%$tag%' OR
        actor LIKE '%$tag%' OR
        movie_summary LIKE '%$tag%'
        GROUP BY movie_code";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // 영화코드로 영화 정보 가져오기
    public function selMovieCodeInfo(&$param) {     
        $sql = "SELECT * FROM t_movies
                WHERE movie_code = :movie_code";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":movie_code", $param["movie_code"]);
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    //장르(체크박스) 체크 후 검색하기
    public function selGenreList(&$param) {
        $genre = $param['tag'];
        $sql = "SELECT movie_code, count(*) as tagScore FROM t_movies
                WHERE movie_genre LIKE '%$genre%'
                GROUP BY movie_code";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}