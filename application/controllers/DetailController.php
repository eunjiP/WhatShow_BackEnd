<?php
    namespace application\Controllers;

    class DetailController extends Controller {
        public function movieInfo() { // 영화 정보
            $url = getUrlPaths();
            if(!isset($url[2])) {
                exit();
            }

            $param = ['movie_code' => $url[2]];
            return $this->model->getMovieInfo($param);
        }

        public function insertReview() { // 리뷰작성
            $json = getJson();
            $param = [
                'ctnt' => $json['ctnt'],
                'iuser' => $json['iuser'],
                'movie_code' => $json['movie_code'],
                'movie_score' => $json['movie_score'],
            ];

            return [_RESULT => $this->model->insReview($param)];
        }

        public function reviewList() { //리뷰 리스트
           $getUrl = getUrlPaths();
            
           $param = [
                'movie_code' => $getUrl[2],
                'revlimit' => $getUrl[3]
           ];
           return $this->model->getReviewList($param); 
        }

        //상세페이지 평점 및 추천 관련 백엔드
        public function movieScoreAndRecommend() {
        $param = [
            'movie_code' => $_GET['movie_code'],
            'iuser' => $_GET['iuser']
        ];
        $result = $this->model->selMovieScoreAndRecommend($param);
        return $result;
        }

        //추천 추가 및 삭제 부분
        public function changeRecommend() {
            $getUrl = getUrlPaths();
            $param = [
                'movie_code' => intval($getUrl[2]),
                'iuser' => intval($getUrl[3])
            ];
            switch(getMethod()) {
                case _POST:
                    $param['fn'] = 'add';
                    return [_RESULT => $this->model->changeRecommend($param)];
                case _DELETE:
                    $param['fn'] = 'remove';
                    return [_RESULT => $this->model->changeRecommend($param)];
            }
        }
        //대댓글 리스트
        public function reviewListCmt(){
            $getUrl = getUrlPaths();
            $param = [
                'i_review' => $getUrl[2]
            ];
            return $this->model->reviewListCmt($param);
        }

        //대댓글 작성
        public function insCmt(){
            $getUrl = getUrlPaths();
            $param = [
                'i_review' => $getUrl[2],
                'comment_cnt' => $getUrl[3],
                'iuser' => $getUrl[4]
            ];
            return $this->model->insCmt($param);
        }
    }