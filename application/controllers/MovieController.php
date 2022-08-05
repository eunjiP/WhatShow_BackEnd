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

    public function boxOffiece() {
        
    }

}