<?php

class IndexController extends Etd_Controller_Action
{
    function init()
    {
        parent::init();
        $this->view->movies = Orm::factory('Movie')->fetchAll();
    }

    public function indexAction()
    {
    }
}
