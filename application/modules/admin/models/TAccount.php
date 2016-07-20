<?php

class Admin_Model_TAccount extends Zend_Db_Table_Abstract{

	protected $_name = 'account';
	
	protected $_primary = array('IDACCOUNT');
	
	function getAuthentification($EMAIL,$PASSWORD)
	{
		$select = $this->select()->setIntegrityCheck(false);
		$select->from($this->_name)
				->where('EMAIL = ?',$EMAIL)
				->where('PASSWORD = ?',$PASSWORD)
				->where('ETAT = ?',"A")
				->group('IDACCOUNT');
		
		return $this->fetchRow($select);
	}
	
	function getPassword($EMAIL)
	{
		$select = $this->select()->setIntegrityCheck(false);
		$select->from($this->_name)
		      ->where('EMAIL = ?',$EMAIL)
		      ->where('ETAT = ?',"A")
		      ->group('IDACCOUNT');
	
		return $this->fetchRow($select);
	}
	
}