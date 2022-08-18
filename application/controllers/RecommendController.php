<?php
    namespace application\controllers;
    use application\libs\Application;
    
    class RecommendController extends Controller {
        //마이페이지 설정한 태그로 적절한 영화 코드 찾는 함수(결과는 2차 배열로 리턴)
        public function tagRecommend() {
            $iuser = $_GET['iuser'];
            // $tags = $_GET['tags'];
            $params = [];
            //마이페이지 태그 리스트 담는 배열($params)
            if($iuser) {
                $param = [
                    'iuser' => $iuser
                ];
                $tags = json_decode(json_encode($this->model->selMyTag($param)), true);
                if(!$tags) {
                    return [_RESULT => 0];
                }
                if(strpos($tags[0]['tag'], ',') == false) {
                    $params[0] = $tags[0]['tag'];
                } else {
                    $tags = explode(',', $tags[0]['tag']);
                    for ($i=0; $i < count($tags); $i++) { 
                        $params[$i] = $tags[$i];
                    }
                }
            }

            //전체 영화 코드
            $movie_total = $this->model->selTotalList();
            //strArray를 객체 배열로 변환하는 방법
            $movie_total = json_decode(json_encode($movie_total), true);
            //영화 코드와 점수를 담을 빈 배열 생성
            $movies_code = [];
            for ($i=0; $i < count($movie_total); $i++) { 
                //빈 배열에 영화코드와 점수로 이차원 배열 생성
                $movie_code = $movie_total[$i]['movie_code'];
                $val = [
                    'movie_code' => $movie_code,
                    'score' => 0
                ];
                array_push($movies_code, $val);
            }
            $movies_code = json_decode(json_encode($movies_code), true);
            
            //제목, 나라, 배우, 감독, 줄거리 등에 태그 키워드가 포함되어 있는 수를 점수로 영화 코드 별로 더 해준다
            // print_r($params);
            for ($i=0; $i < count($params); $i++) { 
                $p = [
                    'tag' => $params[$i]
                ];
                if(!empty($iuser)) {
                    $result = json_decode(json_encode($this->model->selTagList($p)), true);
                } else {
                    $result = json_decode(json_encode($this->model->selGenreList($p)), true);
                }
                
                // print_r($result);
                if(empty($result[0]['tagScore'])) {
                    return [_RESULT => 0];
                }
                for ($j=0; $j < count($movies_code); $j++) { 
                    for ($z=0; $z < count($result); $z++) { 
                        if($movies_code[$j]['movie_code'] === $result[$z]['movie_code']){
                            $movies_code[$j]['score'] += $result[$z]['tagScore'];
                        }
                    }
                }
                // print_r($movies_code);
            }
            
            //영화의 점수를 기준으로 이중 배열을 정렬한 후에 리턴
            foreach ((array)$movies_code as $key => $value) {
                $sort[$key] = $value['score'];
            }
            array_multisort($sort, SORT_DESC, $movies_code);

            //찾은 결과를 정렬해서 순서대로 영화 정보를 객체 배열화하여 리턴
            $movie_info = [];
            for ($i=0; $i < 4; $i++) { 
                $param = [
                    'movie_code' => $movies_code[$i]['movie_code']
                ];
                array_push($movie_info, $this->model->selMovieCodeInfo($param));
            }
            $movie_info = json_decode(json_encode($movie_info), true);
            return $movie_info;
            // print_r($movie_info);
        }

        //키워드 검색 결과 백엔드
        public function movieSearch() {
            $param = [
                'tag' => $_GET['keyword'],
                'iuser' => $_GET['iuser']
            ];
            $result = [];
            $this->model->insSearch($param);
            $movie = json_decode(json_encode($this->model->selTagList($param)), true);
            for ($i=0; $i < count($movie); $i++) { 
                $p = [
                    'movie_code' => $movie[$i]['movie_code']
                ];
                $r = json_decode(json_encode($this->model->selMovieCodeInfo($p)), true);
                array_push($result, $r);
            }
           
            return $result;
        }

        public function movieTagSearch() {
            $param = [
                'tag' => $_GET['keyword']
            ];
            $result = [];
            $movie_genre = [];
            $movie = json_decode(json_encode($this->model->selTagList($param)), true);
            for ($i=0; $i < count($movie); $i++) { 
                $p = [
                    'movie_code' => $movie[$i]['movie_code']
                ];
                $r = json_decode(json_encode($this->model->selMovieCodeInfo($p)), true);
                array_push($result, $r);
                array_push($movie_genre, $r['movie_genre']);
            }
            // print_r($result_code);
            $genre = [];
            for ($i=0; $i < count($movie_genre); $i++) { 
                if(strpos($movie_genre[$i], ',') != false) {
                    $selgenre = explode(',', $movie_genre[$i]);
                    for ($j=0; $j < count($selgenre); $j++) { 
                        array_push($genre, $selgenre[$j]);
                    }
                } 
            }

            $movie_total = $this->model->selTotalList();
            //strArray를 객체 배열로 변환하는 방법
            $movie_total = json_decode(json_encode($movie_total), true);
            //영화 코드와 점수를 담을 빈 배열 생성
            $movies_code = [];
            for ($i=0; $i < count($movie_total); $i++) { 
                //빈 배열에 영화코드와 점수로 이차원 배열 생성
                $movie_code = $movie_total[$i]['movie_code'];
                if($movie_code)
                $val = [
                    'movie_code' => $movie_code,
                    'score' => 0
                ];
                array_push($movies_code, $val);
            }
            $movies_code = json_decode(json_encode($movies_code), true);
            
            for ($i=0; $i < count($genre); $i++) { 
                $p = [
                    'genre' => $genre[$i]
                ];
               
                $result = json_decode(json_encode($this->model->selGenreList($p)), true);
                
                for ($j=0; $j < count($movies_code); $j++) { 
                    for ($z=0; $z < count($result); $z++) { 
                        if($movies_code[$j]['movie_code'] === $result[$z]['movie_code']){
                            $movies_code[$j]['score'] += $result[$z]['tagScore'];
                        }
                    }
                }
            }
            foreach ((array)$movies_code as $key => $value) {
                $sort[$key] = $value['score'];
            }
            array_multisort($sort, SORT_DESC, $movies_code);

            //찾은 결과를 정렬해서 순서대로 영화 정보를 객체 배열화하여 리턴
            $movie_info = [];
            $movie_info = json_decode(json_encode($movie_info), true);
            // print_r($movies_code);
            for ($j=0; $j < count($movies_code); $j++) { 
                for ($i=0; $i < count($result); $i++) { 
                    $str = $result[$i]['movie_code'];
                    // print $str;
                    array_splice($movies_code[$i], $str, 1);
                }
            }
            for ($i=0; $i < 4; $i++) {
                if($movies_code[$i]['score'] > 0) {
                    $param = [
                        'movie_code' => $movies_code[$i]['movie_code']
                    ];
                    array_push($movie_info, $this->model->selMovieCodeInfo($param));
                }
            }
            return $movie_info;
        }
    }