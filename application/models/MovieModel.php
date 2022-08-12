<?php
    namespace application\models;
    use PDO;

class MovieModel extends Model {
    // 영화 TOP10 리스트 가지고 오는 함수
    public function selList(&$param) {
        $sql = "SELECT * FROM t_movies A
        INNER JOIN t_boxoffice B
        ON A.movie_nm = B.movie_nm
        WHERE boxoffice_date = :date
        ORDER BY rank";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":date", $param['targetDt']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // 영화 리스트 가져옴
    public function get_movie(){
        $sql = "SELECT * FROM t_movies";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //박스오피스에 자료가 있는지 유무를 확인하는 함수
    public function selBoxoffice(&$param) {
        $sql = "SELECT * FROM t_boxoffice
            WHERE boxoffice_date = :date";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":date", $param['targetDt']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    //일일박스오피스 DB저장 함수
    public function insBoxoffice(&$param) {
        $sql = "INSERT INTO t_boxoffice
            SET boxoffice_date = :date, rank = :rank,
            movie_nm = :movie_nm";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":date", $param['date']);
        $stmt->bindValue(":rank", $param['rank']);
        $stmt->bindValue(":movie_nm", $param['movie_nm']);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    //tag 들고오는 함수
    public function getTag() {
        $sql = "SELECT movie_genre FROM t_movies
                GROUP BY movie_genre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    //가지고 온 박스오피스의 영화정보가 DB 안에 있는지 확인하는 함수
    public function selMovies(&$param) {
        $sql = "SELECT movie_code FROM t_movies
        WHERE movie_nm = :movie_nm";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":movie_nm", $param['movie_nm']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    //영화 정보 입력 함수
    public function insMovies(&$param) {
        $sql = "INSERT INTO t_movies
        SET movie_code = :movie_code, movie_nm = :movie_nm, movie_genre = :movie_genre, open_date = :open_date, country = :country, director = :director, actor = :actor, movie_poster = :movie_poster, runing_time = :runing_time, view_level = :view_level, movie_summary = :movie_summary";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":movie_code", $param['movie_code']);
        $stmt->bindValue(":movie_nm", $param['movie_nm']);
        $stmt->bindValue(":movie_genre", $param['movie_genre']);
        $stmt->bindValue(":open_date", $param['open_date']);
        $stmt->bindValue(":country", $param['country']);
        $stmt->bindValue(":director", $param['director']);
        $stmt->bindValue(":actor", $param['actor']);
        $stmt->bindValue(":movie_poster", $param['movie_poster']);
        $stmt->bindValue(":runing_time", $param['runing_time']);
        $stmt->bindValue(":view_level", $param['view_level']);
        $stmt->bindValue(":movie_summary", $param['movie_summary']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    //포스터, 줄거리 업데이브 함수
    public function updateMovies(&$param) {
        $sql = "INSERT INTO t_movies SET movie_code = :movie_code, movie_nm = :movie_nm
        ON DUPLICATE KEY UPDATE movie_poster = :movie_poster,
        movie_summary = :movie_summary";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":movie_code", $param['movie_code']);
        $stmt->bindValue(":movie_nm", $param['movie_nm']);
        $stmt->bindValue(":movie_poster", $param['movie_poster']);
        $stmt->bindValue(":movie_summary", $param['movie_summary']);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    //키워드 입력시 영화 정보를 검색하는 함수
    public function selSearch(&$param) {
        $search = $param['keyword'];
        $sql = "SELECT * FROM t_movies
                WHERE movie_nm LIKE '%$search%' 
                OR movie_genre LIKE '%$search%' 
                OR director LIKE '%$search%' 
                OR actor LIKE '%$search%'
                LIMIT :movielimit
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":movielimit", $param['movielimit']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //영화키워드 디비저장하는 백엔드
    public function insSearch($param) {
        $sql ="INSERT INTO t_search
               (search, iuser)
               VALUE
               (:search, :iuser)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":search", $param["keyword"]);
        $stmt->bindValue(":iuser", $param["iuser"]);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // 최근 검색어 
    public function selTopSearch() {
        $sql = "SELECT search, COUNT(*) AS sCount FROM t_search
            GROUP BY search
            ORDER BY sCount DESC, search_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //추천부분과 겹치는 함수 나중에 합치기!!
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