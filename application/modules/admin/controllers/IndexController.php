<?php

class Admin_IndexController extends Etd_Controller_Action
{
    private $dashIcons = array(
 
        'article',
        'backup',
        'basket',
        'batch',
        'bell',
        'book_addresses',
        'browse',
        'calendar',
        'chart_bar',
        'chip',
        'clear_cache',
        'clock',
        'coins',
        'comment',
        'comments',
        'db',
        'excel',
        'flash',
        'folder',
        'gallery',
        'globe',
        'home',
        'key',
        'layout',
        'light',
        'menu',
        'movies',
        
        'palette',
        'rss',
        'search',
        'task',
        'tools',
        'user',
        'windows',
        'xml',
    );
    
    
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        //visit stats 
        $this->view->jsonStatystykaWejsc = json_encode(Service::factory('Stat')->getDataFromLastTime());
        
        $this->view->dashboard = array(
            //array('name'=>'', 'link'=>'', 'icon'=>'', 'comments'=>'', 'amount'=>''),
             /*
            array(
                'name'=>'Struktura', 
                'link'=>'admin/pages', 
                'icon'=>'menu', 
                'comments'=>'Zmień strukturę menu strony', 
                'amount'=>''
            ),
           
            array(
                'name'=>'Str. niezależne', 
                'link'=>'admin/articles', 
                'icon'=>'page_link', 
                'comments'=>'Dodaj stronę niezależna - dostępną poprzez link', 
                'amount'=>''
            ),
   */
            array(
                'name'=>'Słówka', 
                'link'=>'admin/memo', 
                'icon'=>'comment', 
                'comments'=>'Baza słówek', 
                'amount'=>Orm::factory('Memo')->count(array('active=?'=>1))
            ),

            array(
                'name'=>'Filmy',
                'link'=>'admin/movie',
                'icon'=>'movies',
                'comments'=>'Zarządzaj filmami',
                'amount'=>''
            ),
   /*
            array(
                'name'=>'Klienci', 
                'link'=>'admin/clients', 
                'icon'=>'reseller_programm', 
                'comments'=>'Edytuj klientów', 
                'amount'=>''
            ),
            */
            array(
                'name'=>'Użytkownicy', 
                'link'=>'admin/users', 
                'icon'=>'user', 
                'comments'=>'Zarządzaj kontami użytkowników', 
                'amount'=>''
            ),
            
            array(
                'name'=>'Ustawienia', 
                'link'=>'admin/settings', 
                'icon'=>'tools', 
                'comments'=>'Zmień ustawienia serwisu', 
                'amount'=>''
            ),
            
            array(
                'name'=>'SEO', 
                'link'=>'admin/settings#tab3', 
                'icon'=>'globe', 
                'comments'=>'Edytuj metatagi', 
                'amount'=>''
            ),
            
            array(
                'name'=>'Cache', 
                'link'=>'admin/cache/clear', 
                'icon'=>'clear_cache', 
                'comments'=>'Wyczyść pamięć tymczasową serwisu', 
                'amount'=>''
            ),
            
            
            array(
                'name'=>'Pliki', 
                'link'=>'admin/file-browser', 
                'icon'=>'folder', 
                'comments'=>'Przeglądaj pliki na serwerze', 
                'amount'=>''
            ),

                    
            array(
                'name'=>'', 
                'link'=>'#', 
                'icon'=>'', 
                'comments'=>'', 
                'amount'=>''
            ),
            array(
                'name'=>'', 
                'link'=>'#', 
                'icon'=>'', 
                'comments'=>'', 
                'amount'=>''
            ),

        );
    }


}

