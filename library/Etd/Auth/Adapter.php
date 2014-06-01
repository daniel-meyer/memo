<?php


class Etd_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    /**
     * Zend_DbTable
     *
     * @var $_table - the table
     */
    protected $_table = null;

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
    public function __construct($table = null,  $identityColumn = null, $credentialColumn = null)
    {
        if (null !== $table) {
            $this->setTable($table);
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
     * setTable() - set the db table
     * @param Zend_Db_Table_Row_Abstract $table
     */
    public function setTable($table)
    {
        $this->_table = $table;
        return $this;
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
        $resultIdentities = $this->_execute();
        $authResult = $this->_validateResult($resultIdentities);
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
        
        if ($this->_table === null) {
            $exception = 'A database connection was not set, nor could one be created.';
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
     * _execute() - This method creates a Zend_Db_Table_Row_Abstract object that
     * is completely configured to be queried against the database.
     *
     * @return Zend_Db_Table_Row_Abstract
     */
    protected function _execute()
    {                            
        return $this->_table->fetchAll(array(
            $this->_identityColumn . '=?' => $this->_identity
        ));
    }


    /**
     * _validateResult() - This method attempts to validate that the record in the 
     * result set is indeed a record that matched the identity provided to this adapter.
     *
     * @param array $resultIdentities
     * @return Zend_Auth_Result
     */
    protected function _validateResult($resultIdentities)
    {
        if (count($resultIdentities) < 1) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
            $this->_authenticateResultInfo['messages'][] = 'A record with the supplied identity could not be found.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) > 1) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS;
            $this->_authenticateResultInfo['messages'][] = 'More than one record matches the supplied identity.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) == 1) {
        	$resultIdentity = $resultIdentities[0];

            $credentialColumn = 'get' . ucfirst($this->_credentialColumn);
            if ($resultIdentity->$credentialColumn() != $this->_credential) {
            	$this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
                $this->_authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            } else {
            	$this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
                $this->_authenticateResultInfo['identity'] = $this->_identity;
                $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';
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