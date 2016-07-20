<?php

class Admin_DashboardController extends Zend_Controller_Action
{
	private $_auth;
	
	private $_session;
	
	public function init()
	{
		$this->_auth = Zend_Auth::getInstance();
		$this->_session = Zend_Registry::get('session');
		
		$this->_helper->_layout->setLayout('admin');
		
		$params = $this->getRequest()->getParams();

		if(isset($params['error'])):
			$this->view->error = $params['error'];
		endif;
	}
	
    public function indexAction ()
    {
    	
   	}

}