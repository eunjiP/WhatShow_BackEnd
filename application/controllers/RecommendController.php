<?php
    namespace application\controllers;
    use application\libs\Application;
    
    class RecommendController extends Controller {
        //마이페이지 설정한 태그로 적절한 영화 코드 찾는 함수(결과는 2차 배열로 리턴)
        public function tagRecommend() {
            //마이페이지 태그 리스트 담는 배열($params)
            $params = [
                0 => '액션',
                1 => '박해일'
            ];
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
            for ($i=0; $i < count($params); $i++) { 
                $param = [
                    'tag' => $params[$i]
                ];
                $result = $this->model->selTagList($param);
                $result = json_decode(json_encode($result), true);
                print_r($result);
                for ($j=0; $j < count($movies_code); $j++) { 
                    for ($z=0; $z < count($result); $z++) { 
                        if($movies_code[$j]['movie_code'] === $result[$z]['movie_code']){
                            $movies_code[$j]['score'] += $result[$z]['tagScore'];
                        }
                    }
                }
            }

            //영화의 점수를 기준으로 이중 배열을 정렬한 후에 리턴
            foreach ((array)$movies_code as $key => $value) {
                $sort[$key] = $value['score'];
            }
            array_multisort($sort, SORT_DESC, $movies_code);
            return $movies_code;
        }
    }