<?php

class Etd_Controller_Default extends Etd_Controller_Action {

    protected $_page;

    public function init() {
        parent::init();

        $this->view->pages = Service::factory('Page')->getTree(array('active=?' => 1));


        // Metatagi
        $this->view->headTitle()->set($this->_settings->siteTitle);
        $this->view->headMeta()->appendName('keywords', $this->_settings->siteTitle);
        $this->view->headMeta()->appendName('description', $this->_settings->siteTitle);

    
    }

    public function postDispatch() {
        parent::postDispatch();

        if (null == $this->_page) {
            return;
        }


        // Metatagi
        if ($this->_page->getTitle()) {
            $this->view->headTitle()->set($this->_page->getTitle());
        }
        if ($this->_page->getMetaTitle()) {
            $this->view->headTitle()->set($this->_page->getMetaTitle());
        }
        if ($this->_page->getMetaKeywords()) {
            $this->view->headMeta()->setName('keywords', $this->_page->getMetaKeywords());
        }
        if ($this->_page->getMetaDescription()) {
            $this->view->headMeta()->appendName('description', $this->_page->getMetaDescription());
        }
    }

}