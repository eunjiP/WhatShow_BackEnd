<?php
    namespace application\Controllers;

    class DetailController extends Controller {
        public function movieInfo() {
            $url = getUrlPaths();
            if(!isset($url[2])) {
                exit();
            }

            $param = ['movie_code' => $url[2]];
            return $this->model->getMovieInfo($param);
        }

        public function insertReview() {
            $json = getJson();
            $param = [
                'ctnt' => $json['ctnt'],
                'iuser' => $json['iuser'],
                'movie_code' => $json['movie_code'],
                'movie_score' => $json['movie_score'],
            ];

            return [_RESULT => $this->model->insReview($param)];
        }

        public function reviewList() {
           $getUrl = getUrlPaths();
            
           $param = [
                'movie_code' => $getUrl[2],
                'revlimit' => $getUrl[3]
           ];
           return $this->model->getReviewList($param); 
        }

    }