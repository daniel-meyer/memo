<?php
class Etd_View_Helper_HeadBase {

	protected $_request;
	protected $_scheme;
	protected $_host;
	protected $_baseUrl;

	public function headBase()
	{
		return $this;
	}
	
	public function getRequest() {
		if($this->_request === null) {
			if(!class_exists('Zend_Controller_Front', false)) {
				throw new Exception('Could not get request object: frontController does not exist');
			}
		
			$this->_request = Zend_Controller_Front::getInstance()->getRequest();
		}
		
		return $this->_request;
	}
	
	public function setScheme($scheme)
	{
		$this->_scheme = (string) $scheme;
		return $this;
	}
	
	public function getScheme()
	{
		if($this->_scheme === null) {
			$request = $this->getRequest();
			$this->_scheme = ($request === null) ? 'http' : $request->getScheme();
		}
		
		return $this->_scheme;
	}
	
	public function setHost($host)
	{
		$this->_host = (string) $host;
		return $this;
	}

	public function getHost()
	{
		if($this->_host === null) {
			try {
				$this->_host = $this->getRequest()->getHttpHost();
			}
			catch(Exception $e) {
				throw new Exception('Could not determine host: '.$e->getMessage());
			}
		}
		
		return $this->_host;
	}
	
	public function setBaseUrl($baseUrl)
	{
		$this->_baseUrl = (string) $baseUrl;
		return $this;
	}

	public function getBaseUrl()
	{
		if($this->_baseUrl === null) {
			try {
				$this->_baseUrl = $this->getRequest()->getBaseUrl();
			}
			catch(Exception $e) {
				throw new Exception('Could not determine baseUrl: '.$e->getMessage());
			}
		}
		
		return $this->_baseUrl;
	}

	public function getUrl()
	{
		return $this->getScheme().'://'.$this->getHost().$this->getBaseUrl().'/';
	}
	
	public function toString()
	{
		return '<base href="'.$this->getUrl().'" />';
	}
	
	public function __toString()
	{
		return $this->toString();
	}

}
