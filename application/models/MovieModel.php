<?php
    namespace application\models;
    use PDO;

class MovieModel extends Model {
    public function selList() {
        $sql = "SELECT * FROM t_movies";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}