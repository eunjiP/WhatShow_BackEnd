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

    public function boxOffice() {
        $key = '9327301d882811904d8caa4ab3d63bb6';
        $targetDt = '20220805';
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
            $param = [
                'date' => $targetDt
            ];
            for ($i=0; $i < count($re_res); $i++) { 
                $param[$re_res[$i]['rank']] = $re_res[$i]['movieNm'];
            }
            return $this->model->insBoxoffice($param);
        } else {
            echo "Error 내용 : " . $res;
        }
    }

}