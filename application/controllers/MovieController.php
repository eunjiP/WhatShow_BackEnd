<?php
namespace application\controllers;
use application\libs\Application;

class MovieController extends Controller {
    public function index() {        
        $this->addAttribute(_MAIN, $this->getView("movie/index.php"));
        return "template/t1.php";
    }

    public function main() {
        switch(getMethod()) {
            case _GET:
                return $this->model->selList();
            case _POST:

        }
    }

    //영화진흥원의 박스오피스 TOP10
    public function boxOffice() {
        $key = 'de024e41172ba2b7f13cb5d286ad1162';
        $targetDt = '20220806';
        $url = 'http://www.kobis.or.kr/kobisopenapi/webservice/rest/boxoffice/searchDailyBoxOfficeList.json?key=' . $key . '&targetDt=' . $targetDt;
        $is_post = false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $res = curl_exec($ch);
        $stat = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if($stat === 200) {
            $re_res = json_decode($res, true);
            $re_res = $re_res['boxOfficeResult']['dailyBoxOfficeList'];
            // print_r($re_res);
            $param = [
                'date' => $targetDt
            ];

            $movieCd = [];
            for ($i=0; $i < count($re_res); $i++) { 
                $param[$re_res[$i]['rank']] = $re_res[$i]['movieNm'];
                array_push($movieCd, $re_res[$i]['movieCd']);
            }
            print_r($movieCd);
            // return $this->model->insBoxoffice($param);
            // if($this->model->insBoxoffice($param)) {
            if(1) {
                for ($i=1; $i < count($param); $i++) { 
                    $movie_code = $this->naverSearchApi($param[$i]);
                    print($movieCd[($i-1)]);
                    $movie_result = $this->movieDetailApi($movieCd[($i-1)]);
                    print_r($movie_result);
                    $movie_param = [
                        'movie_code' => $movie_code,
                        'movie_nm' => $param[$i],
                        'movie_genre' => $movie_result['genres'],
                        'open_date' => $re_res[$i-1]['openDt'],
                        'country' => $movie_result['nations'],
                        'movie_poster' => 'test',
                        'director' => $movie_result['directors'],
                        'actor' => $movie_result['actors'],
                        'runing_time' => $movie_result['showTm'],
                        'view_level' => $movie_result['watchGradeNm'],
                    ];
                    $result = $this->model->selMovies($movie_param);
                    if($result) {
                        print_r($result);
                    } else {
                        // print_r($movie_param);
                        print $this->model->insMovies($movie_param);
                    }
                } 
            } 
        } else {
            echo "Error 내용 : " . $res;
        }
    }

    //영화 시간 통신하는 api
    public function movieTime() {
        // //영화코드
        // $code = '191634';
        // //지역코드
        $regionRootCode = $_GET['rootCode'];
        $regionSubCode = $_GET['subCode'];
        // //조회하는 시간
        // $reserveDate = '2022-08-06';
        $code = $_GET['code'];
        $reserveDate = $_GET['date'];

        $url = 'https://movie.naver.com/movie/bi/mi/runningJson.naver?code=' . $code . '&regionRootCode=' . $regionRootCode .'&regionSubCode=' . $regionSubCode . '&reserveDate=' . $reserveDate;
        //get방식으로 보내기 위해서
        $is_post = false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $res = curl_exec($ch);
        $stat = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($stat === 200) {
            $res = json_decode($res, true);
            return $res['groupScheduleList'];
        } else {
            echo "Error 내용 : " . $res;
        }
    }

    //영화 태그
    public function getTag() {
        $result = json_decode(json_encode($this->model->getTag()), true);
        $arr = [];
        for ($i=0; $i < count($result); $i++) { 
            $genre = $result[$i]['movie_genre'];
            $genre = explode(',', $genre);
            for ($j=0; $j < count($genre); $j++) { 
                array_push($arr, $genre[$j]);
            }
        }
        $arr = array_unique($arr, SORT_REGULAR);
        return $arr;
    }

    //naver검색 api의 영화코드 받아오는 api
    public function naverSearchApi($keyword) {
        $query = urlencode($keyword);
        $url = "https://openapi.naver.com/v1/search/movie.json?query=" . $query;
        $is_post = false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = "X-Naver-Client-Id: " . "9z7DxXapcxWGFWS0V2Qk";
        $headers[] = "X-Naver-Client-Secret: " . "1Ej9g140Kp";

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $res = curl_exec($ch);
        $stat = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($stat === 200) {
            $re_res = json_decode($res, true);
            if($re_res['total'] > 0) {
                $res_items = $re_res['items'][0];
                // $res_img = $res_items['image'];
                $res_link = explode('=', $res_items['link']);
                $movie_code = end($res_link);
                // $result = [
                //     'movie_code' => $movie_code,
                //     'movie_img' => $res_img
                // ];
                return $movie_code;
            } else {
                print "검색한 결과가 없습니다.";
            }
        } else {
            echo "Error 내용 : " . $res;
        }
    }

    //영화진흥원의 영화 상세 api
    public function movieDetailApi($movieCd) {
        $key = 'de024e41172ba2b7f13cb5d286ad1162';
        $url = "http://www.kobis.or.kr/kobisopenapi/webservice/rest/movie/searchMovieInfo.json?key=" . $key . '&movieCd=' . $movieCd;
        $is_post = false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $res = curl_exec($ch);
        $stat = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($stat === 200) {
            $res = json_decode($res, true)['movieInfoResult']['movieInfo'];
            $genres = '';
            for ($i=0; $i < count($res['genres']); $i++) { 
                $genres .= $res['genres'][$i]['genreNm'] ;
                if($i !== count($res['genres'])-1) {
                    $genres .= '/';
                }
            }
            $res['nations'] = $res['nations'][0]['nationNm'];
            $res['genres'] = $genres;

            $directors = '';
            for ($i=0; $i < count($res['directors']); $i++) { 
                $directors .= $res['directors'][$i]['peopleNm'] ;
                if($i !== count($res['directors'])-1) {
                    $directors .= ',';
                }
            }
            $res['directors'] = $directors;

            $actors = '';
            for ($i=0; $i < count($res['actors']); $i++) { 
                $actors .= $res['actors'][$i]['peopleNm'] ;
                if($i !== count($res['actors'])-1) {
                    $actors .= ',';
                }
            }
            $res['actors'] = $actors;
            $res['watchGradeNm'] = $res['audits'][0]['watchGradeNm'];

            return $res;
        } else {
            echo "Error 내용 : " . $res;
        }
    }
}