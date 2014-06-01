<?php


class Etd_Auth_Rest_Adapter implements Zend_Auth_Adapter_Interface
{
    /**
     * $_rest - REST location
     *
     * @var string
     */
    protected $_rest = null;
    protected $_authKey = null;
    protected $_client = null;
    protected $_body = null;

    /**
     * $_identityColumn - the column to use as the identity
     *
     * @var string
     */
    protected $_identityColumn = null;

    /**
     * $_credentialColumn - columns to be used as the credentials
     *
     * @var string
     */
    protected $_credentialColumn = null;

    /**
     * $_identity - Identity value
     *
     * @var string
     */
    protected $_identity = null;

    /**
     * $_credential - Credential values
     *
     * @var string
     */
    protected $_credential = null;

    /**
     * $_authenticateResultInfo
     *
     * @var array
     */
    protected $_authenticateResultInfo = null;
    
    /**
     * __construct() - Sets configuration options
     *
     * @param  Zend_Db_Table_Row_Abstract $table
     * @param  string                   $identityColumn
     * @param  string                   $credentialColumn
     * @param  string                   $credentialTreatment
     * @return void
     */
    public function __construct($rest = null, $authKey = null,  $identityColumn = null, $credentialColumn = null)
    {
        if (null !== $rest) {
            $this->setRest($rest);
        }
        
        if (null !== $authKey) {
            $this->setAuthKey($authKey);
        }

        if (null !== $identityColumn) {
            $this->setIdentityColumn($identityColumn);
        }

        if (null !== $credentialColumn) {
            $this->setCredentialColumn($credentialColumn);
        }
    }
    
    /**
     * 
     * setRest() - set the rest location
     * @param string $rest
     */
    public function setRest($rest)
    {
        $this->_rest = $rest;
        return $this;
    }
    
    public function setAuthKey($authKey)
    {
        $this->_authKey = $authKey;
        return $this;
    }
    
    public function getClient()
    {
        
        return $this->_client;
    }
    
    public function getBody()
    {
        return $this->_body;
    }
    

    /**
     * setIdentityColumn() - set the column name to be used as the identity column
     *
     * @param  string $identityColumn
     * @return My_Auth_Adapter_Doctrine2 Provides a fluent interface
     */
    public function setIdentityColumn($identityColumn)
    {
        $this->_identityColumn = $identityColumn;
        return $this;
    }

    /**
     * setCredentialColumn() - set the column name to be used as the credential column
     *
     * @param  string $credentialColumn
     * @return My_Auth_Adapter_Doctrine2 Provides a fluent interface
     */
    public function setCredentialColumn($credentialColumn)
    {
        $this->_credentialColumn = $credentialColumn;
        return $this;
    }

    /**
     * setIdentity() - set the value to be used as the identity
     *
     * @param  string $value
     * @return My_Auth_Adapter_Doctrine2 Provides a fluent interface
     */
    public function setIdentity($value)
    {
        $this->_identity = $value;
        return $this;
    }
    
    public function getIdentity()
    {
        return $this->_identity;
    }

    /**
     * setCredential() - set the credential value to be used
     *
     * @param  string $credential
     * @return My_Auth_Adapter_Doctrine2 Provides a fluent interface
     */
    public function setCredential($credential)
    {
        $this->_credential = $credential;
        return $this;
    }

    /**
     * authenticate() - defined by Zend_Auth_Adapter_Interface.  This method is called to 
     * attempt an authentication.  Previous to this call, this adapter would have already
     * been configured with all necessary information to successfully connect to a database
     * table and attempt to find a record matching the provided identity.
     *
     * @throws Zend_Auth_Adapter_Exception if answering the authentication query is impossible
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        $this->_authenticateSetup();
        $result = $this->_execute();
        $authResult = $this->_validateResult($result);
        return $authResult;
    }

    /**
     * _authenticateSetup() - This method abstracts the steps involved with making sure
     * that this adapter was indeed setup properly with all required peices of information.
     *
     * @throws Zend_Auth_Adapter_Exception - in the event that setup was not done properly
     * @return true
     */
    protected function _authenticateSetup()
    {
        $exception = null;
        
        if ($this->_rest === null) {
            $exception = 'A REST location was not set.';
        } elseif ($this->_identityColumn == '') {
            $exception = 'An identity column must be supplied for the Etd_Auth_Adapter authentication adapter.';
        } elseif ($this->_credentialColumn == '') {
            $exception = 'A credential column must be supplied for the Etd_Auth_Adapter authentication adapter.';
        } elseif ($this->_identity == '') {
            $exception = 'A value for the identity was not provided prior to authentication with Etd_Auth_Adapter.';
        } elseif ($this->_credential === null) {
            $exception = 'A credential value was not provided prior to authentication with Etd_Auth_Adapter.';
        }

        if (null !== $exception) {
            /**
             * @see Zend_Auth_Adapter_Exception
             */
            require_once 'Zend/Auth/Adapter/Exception.php';
            throw new Zend_Auth_Adapter_Exception($exception);
        }
        
        $this->_authenticateResultInfo = array(
            'code'     => Zend_Auth_Result::FAILURE,
            'identity' => $this->_identity,
            'messages' => array()
            );
            
        return true;
    }

    /**
     * _execute() - This method creates a Zend_Rest_Client object that
     * is completely configured to be queried against the database.
     *
     * @return Zend_Rest_Client
     */
    /*protected function _execute()
    {                                   

        $password = $this->szyfrowanie($this->_credential);

        try {
            $this->_client = new Zend_Rest_Client($this->_rest, array('adapter'=>'Zend_Http_Client_Adapter_Curl'));
            //$this->_client->getHttpClient()->setConfig(array("timeout" => 5));
            //$this->_client->setHeaders('Connection: close'); 
            $response = $this->_client->restGet('/otw/teacherenh/name/' . $this->_identity . '/' . $password);
            if(200 == $response->getStatus()){
                return Zend_Json::decode($response->getBody());
            }

            return false;
        } catch (Exception $e) {
            //Log exception here
            return false;
        }
    }*/
    
    protected function _execute()
    {                                   

        $password = $this->szyfrowanie($this->_credential);

        try {
            $url = $this->_rest . '/otw/teacherenh/name/' . $this->_identity . '/' . $password;
            
            $curl = curl_init();
             curl_setopt($curl, CURLOPT_URL, $url);
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($curl, CURLOPT_TIMEOUT, 15);
             $wynik = curl_exec($curl);
             curl_close($curl);
            
             return Zend_Json::decode($wynik);

        } catch (Exception $e) {
            //Log exception here
            return false;
        }
    }
    
    public function szyfrowanie($pass)
    {
    	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
    	if($cipher === false) return 'can not open mcrypt module';
    	$iv_size = mcrypt_enc_get_iv_size($cipher);
    	$iv = mcrypt_create_iv($iv_size,MCRYPT_DEV_RANDOM);
    	
    	$init = mcrypt_generic_init($cipher, $this->_authKey, $iv);
    	if($init === false) return 'mcrypt module init error: incorrect parameters';
    	elseif($init >= 0) {
    		$encrypted = mcrypt_generic($cipher, $pass);
    		mcrypt_generic_deinit($cipher);
    		mcrypt_module_close($cipher);
    		$unpacked = '';
    		$ivu = '';
    		for ($i = 0; $i < strlen($iv); $i++) {
    			$hex = dechex(ord($iv[$i]));
    			if(strlen($hex) == 1) $hex = '0'.$hex;
    			$ivu .= $hex;
    		}
    		for ($i = 0; $i < strlen($encrypted); $i++) {
    			$hex = dechex(ord($encrypted[$i]));
    			if(strlen($hex) == 1) $hex = '0'.$hex;
    			$unpacked .= $hex;
    		}
    	}
    	elseif($init == -3) 'mcrypt module init error: key length is incorrect';
    	elseif($init == -4) return 'mcrypt module init error: memory allocation problem';
    	else return 'mcrypt module init error: unknown error';
    	return $ivu.$unpacked;
    }
    
    public function deszyfrowanie($key)
    {
    	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
    	if($cipher === false) return 'can not open mcrypt module';
    	$iv_size = mcrypt_enc_get_iv_size($cipher);
    	$binPass = pack('H*', $key);
    	$iv = substr($binPass, 0, $iv_size);
    	$pass = substr($binPass, $iv_size);
    
    	$init = mcrypt_generic_init($cipher, $this->_authKey, $iv);
    	if($init === false) return 'mcrypt module init error: incorrect parameters';
    	elseif($init >= 0) {
    		$plainPass = rtrim(mdecrypt_generic($cipher, $pass));
    		mcrypt_generic_deinit($cipher);
    		mcrypt_module_close($cipher);
    	}
    	elseif($init == -3) 'mcrypt module init error: key length is incorrect';
    	elseif($init == -4) return 'mcrypt module init error: memory allocation problem';
    	else return 'mcrypt module init error: unknown error';
    
    	return $plainPass;
    }


    /**
     * _validateResult() - This method attempts to validate that the record in the 
     * result set is indeed a record that matched the identity provided to this adapter.
     *
     * @param array $resultIdentities
     * @return Zend_Auth_Result
     */
    protected function _validateResult($result)
    {
        
        if (false == $result) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
            $this->_authenticateResultInfo['messages'][] = 'A record with the supplied identity could not be found.';
        } elseif(is_array($result)) {
            $this->_body = $result;
            if(isset($result['error'])){
                $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE;
                $this->_authenticateResultInfo['messages'][] = $result['hrInfo'];
            }
            elseif(isset($result['teacher'])){
                if(isset($result['teacher']['blocked']) && $result['teacher']['blocked'] == true){
                    $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE;
                    $this->_authenticateResultInfo['messages'][] = 'Blocked reason: ' . $result['teacher']['blockedReason'];
                }
                else{
                    $this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
                    $this->_authenticateResultInfo['identity'] = $this->_identity;
                    $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';    
                }
                
            }
        	
        } else {
        	$this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_UNCATEGORIZED;
        }

        return $this->_authenticateCreateAuthResult();
    }
    
    /**
     * _authenticateCreateAuthResult() - This method creates a Zend_Auth_Result object
     * from the information that has been collected during the authenticate() attempt.
     *
     * @return Zend_Auth_Result
     */
    protected function _authenticateCreateAuthResult()
    {
        return new Zend_Auth_Result(
            $this->_authenticateResultInfo['code'],
            $this->_authenticateResultInfo['identity'],
            $this->_authenticateResultInfo['messages']
            );
    }

}