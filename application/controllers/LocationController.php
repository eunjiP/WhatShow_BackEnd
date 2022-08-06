<?php
namespace application\Controllers;

class LocationController extends Controller {

    public function LocationList() {
        $param = [];

        if(isset($_GET["sub_nm"])) {
            $sub_nm = intval($_GET["sub_nm"]);
            if($sub_nm > 0) {
                $param["sub_nm"] = $sub_nm;
            }
        } else {
            if(isset($_GET["region_nm"])) {
                $param["region_nm"] = $_GET["region_nm"];
            }
        }
        return $this->model->LocationList($param);
    }

    public function option1List() {
        return $this->model->option1List();
    }

    public function option2List() {
        return $this->model->option2List();
    }


}