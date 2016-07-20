<?php

class Admin_IndexController extends Zend_Controller_Action
{
	private $_auth;
	
	private $_session;
	
	private $_salt = "demo";
	
	private $_passwordCrypt = "";
	
	public function init()
	{
		$this->_auth = Zend_Auth::getInstance();
		$this->_session = Zend_Registry::get('session');
		
		$this->_helper->_layout->setLayout('auth');
		
		$params = $this->getRequest()->getParams();

		if(isset($params['error'])):
			$this->view->error = $params['error'];
		endif;
	}
	
    public function indexAction ()
    {
    	$params = $this->getRequest()->getParams();
    	
    	if($this->getRequest()->isPost()):
    		// STOCKAHE MOT DE PASSE CRYPTE
    		$this->_passwordCrypt = sha1(sha1($this->_request->getParam('PASSWORD')).$this->_salt);
    		
    		//INIT CONNEXION TABLE
    		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
    		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
    		$authAdapter->setTableName('account')
    					->setIdentityColumn('EMAIL')
    					->setCredentialColumn('PASSWORD')
    					->setIdentity($params['EMAIL'])
    					->setCredential($this->_passwordCrypt);
    		
    		// VERIFICATION IDENTITE
    		$result = $this->_auth->authenticate($authAdapter);
    		if($result->isValid()):
	    		$this->_auth->getStorage()->write($res = $authAdapter->getResultRowObject(null,'PASSWORD'));
	    		Zend_Session::regenerateId();
	    		// STOCKAGE VARIABLE
	    		$this->_session->IDACCOUNT = $this->_auth->getIdentity()->IDACCOUNT;
	    		$this->_session->GROUPE = $this->_auth->getIdentity()->GROUPE;
	    		$this->_session->EMAIL = $this->_auth->getIdentity()->EMAIL;
	    		$this->_session->ACOUNT_NAME = $this->_auth->getIdentity()->ACOUNT_NAME;
	    		$this->_helper->redirector('index','dashboard','admin');
    		else:
    			// REDIRECTION SI FAUX
    			$this->_helper->redirector('index','index','admin',array('error'=>'true'));
    		endif;
    	endif;
   	}

}