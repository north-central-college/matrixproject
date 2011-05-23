<?php

class App_UserService {
   
	protected $db;
   
   	/** 
    * student Zend table
    * Enter description here ...
    * @var unknown_type
    */
   	protected $user;
   
   	function __construct(){
     	$options = array(
   	 	'host' => 'localhost', 
   		'username' => 'mcdamske', 
   		'password' => 'mcdamske',
   		'dbname' => 'matrix_mcdamske'
   	);
   	
   	$this->db = Zend_Db::factory('PDO_MYSQL', $options);
   	Zend_Db_Table_Abstract::setDefaultAdapter($this->db);
   	$this->user = new App_UserTable();
	
   	}
   	public function NewTestUser(){
     	
		$params = array(
			'user_id' => '10',
			'username' => 'gbluth',
			'last_name' => 'Bluth',
			'first_name' => 'George',
			'middle_initial' => 'O',
			'role' => 'F'
		);
   		$this->user->insert($params);
   	}
   
   	private function PrviateGetAllArtifactsForFacultyID($id)
   	{   	 
   		$select = $this->user->select()    							
   						->from(array('u' => 'user'),'user_id')
   						->from(array('s' => 'user'), array('s.last_name as student_last_name', 's.first_name as student_first_name', '*'))  
   						->from(array('a' => 'artifact'), array('a.filename as artifact_filename', '*'))
   						->from(array('r' => 'reflective_statement'), array('r.filename as reflective_filename', '*'))
   						->from(array('ar' => 'artifact_rating'), '*')
   						->from(array('ais' => 'artifact_indicator_status'), array('DATE_FORMAT(ais.timestamp, \'%m/%d/%Y %h:%i %p\')as submitted_timestamp', '*'))
   						->join(array('c' => 'course'),
   							   'ar.rating_user_id = u.user_id && 
   							   	ais.artifact_id = a.artifact_id &&
   							   	ar.artifact_id = a.artifact_id && 
   							   	ar.indicator_id = ais.indicator_id &&  							   	
   							   	a.artifact_id = r.artifact_id &&
   							   	a.course = c.course_id &&  
   							   	ais.indicator_id = r.indicator_id && 							
  							    a.student_id = s.user_id')
   						->where('u.user_id = ?', $id)
   						->setIntegrityCheck(false); 
   		return $select;				   			
   	}
	public function GetAllArtifactsForFacultyID($id)
   	{   	 
   		$select = $this->PrviateGetAllArtifactsForFacultyID($id)
   						->setIntegrityCheck(false); 				   						
		return $this->user->fetchAll($select); 
   	}
   	
	public function GetArtifactsForFacultyIDWithOrderAndLimitAndStatus($id, $order, $limit, $status)
   	{   	 
   		$select = $this->PrviateGetAllArtifactsForFacultyID($id)
   						->where('ais.status_code = ?', $status)				
   						->order($order)  		
   						->limit($limit, 0)
   						->setIntegrityCheck(false); 				   						
		return $this->user->fetchAll($select); 
   	}
   	
   	public function GetFullNameForId($id)
   	{	   		
   		$select = $this->user->select()   		
   						->from('user', array("last_name", "first_name", "user_id"))
   						->where('user_id = ?', $id);   
   		$rowset = $this->user->fetchAll($select)->toArray();
   		return $rowset[0]["first_name"] . " " . $rowset[0]["last_name"];
   	}
}


