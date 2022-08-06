<?php
    namespace application\Controllers;

    class DetailController extends Controller {
        public function reviewList() {
            $json = getJson();
            return $this->model->getReviewList($param); 
        }
    }