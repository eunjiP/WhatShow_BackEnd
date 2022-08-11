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
}