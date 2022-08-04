<?php
namespace application\controllers;
use application\libs\Application;

class MovieController extends Controller {

    function main() {
        switch(getMethod()) {
            case _GET:
                return [_RESULT => $this->model->selList()];
            case _POST:

        }
    }

}