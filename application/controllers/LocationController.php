<?php
namespace application\Controllers;

class LocationController extends Controller {
    public function LocalList() {
        return $this->model->getLocalList();
    }

    public function LocalList1() {
        return $this->model->LocalList1();
    }



}