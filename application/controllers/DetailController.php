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

        public function reviewList() {
            $url = getUrlPaths();
            if(!isset($url[2])) {
                exit();
            }
            $param = [ 'movie_code' => $url[2]];
            return $this->model->getReviewList($param); 
        }
    }