<?php

class Admin_AuthController extends Etd_Controller_Action
{   
    public function init() 
    {
        parent::init();
        
        Zend_Layout::getMvcInstance()->setLayout('login');
        
        $this->_adapter = new Etd_Auth_Adapter(Orm::factory('User'), 'email', 'password');
    }

    public function indexAction() 
    {
        $this->_forward('login');
    }
    
    public function loginAction() 
    {
        $rq = $this->getRequest();
        $required = array();
        
        if($rq->getPost('auth')){
            if(!$rq->getPost('username')){
                $required[] = 'login';    
            }
            if(!$rq->getPost('password')){
                $required[] = 'hasło';    
            }
        }
        if($required){
            $this->view->message = 'Podaj ' . join(' i ', $required); 
            
        }elseif ($rq->getPost('auth')) {
            
            $this->_adapter->setCredential(md5($rq->getPost("password")));  
            $this->_adapter->setIdentity($rq->getPost("username"));
            
            $auth = Zend_Auth::getInstance();  
            $result = $auth->authenticate($this->_adapter);  
            if ($result->isValid()) {
                $user = Service::factory('User')->getUser();
                $user->setLastLoginDate(date("Y-m-d G:i:s"));
				$user->save();
				// If "remember" was marked
                if ($rq->getPost('rememberme')) {
                    Zend_Session::rememberMe();
                }
                if (!$rq->isXmlHttpRequest()) {
					$referer = $rq->getPost('referer');
                    if($referer){
                        $this->getResponse()->setRedirect($referer);
                    }else{
                        $this->_redirect( $rq->getModuleName() );
                    }
				}
                return;
                
            } else {  
                //Show the login form with error message...  
                $this->view->message = 'Nieprawidłowy login lub hasło'; 
            }  
        } else {  
            //Show the login form  
        }
        if(Zend_Registry::isRegistered('acl_redirect')){
            $this->view->aclRedirect = $this->view->url();  
            //$this->view->message = 'Sesja wygasła. <br />Zaloguj się ponownie'; 
        }
	}
    
    public function logoutAction() 
    {
        //Log him out!!  
        Zend_Auth::getInstance()->clearIdentity();  
        Zend_Session::forgetMe();
        $this->_redirect('/');
    }

    public function passwordResetAction() 
    {
		if ($this->_request->isPost()) {
            $f = new Zend_Filter_StripTags();
			$email = $f->filter($this->_request->getPost('username'));
            
            $user = Orm::factory('User')->findOneBy(array('email'=>$email));
            
            if (!$user) {
                $this->view->message = 'Nie znaleziono użytkownika '.$email.' w bazie';
            } else {
                
                $code = md5(uniqid(mt_rand(), true));
                $user->setSecretKey($code);
                $user->save();

                $settings = Zend_Registry::get('settings');

                // generowanie maila
                $mail = new Etd_Mail('utf-8');
                $this->view->usr = $user;
        		$this->view->title = 'Nowe hasło';
                $this->view->content = $this->getRequest()->getControllerName().'/@password-reset.tpl';
        		$mail->setBodyHtml( $this->view->render('../../default/views/@mail.tpl') );
        		$mail->setFrom($settings->siteEmail, $settings->siteTitle);
        		$mail->addTo($user->getEmail());
        		$mail->setSubject($this->view->title);
                $mail->send();


				$this->view->message =  'Wiadomość została wysłana na Twój adres e-mail.';
            }
		}
	}

    public function changePasswordAction() 
    {
		$rq = $this->getRequest();
        
        $id = (int)$this->_getParam('id');
        $hash = $this->_getParam('hash');
        
        $user = Orm::factory('User')->findById($id);
        if(empty($hash) || $hash != $user->getSecretKey()) {
            $this->addMessage('Nieprawidłowy link do zmiany hasła');
            $this->redirectToUrl(array('action'=>'index'));	
        }    
        
        $validation = Etd_View_Smarty_Validate::getInstance();
        if($rq->isPost() && $validation->isValid()){
            $user->setPassword(md5($rq->getPost('haslo')));
            $user->save();
            
            $this->addMessage('Zapisano nowe hasło');
            $this->redirectToUrl(array('action'=>'index'));	

		}
	}
}