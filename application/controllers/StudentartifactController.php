<?php

/**
 * Students
 *
 * @author cstclair
 * @version
 */

require_once 'Zend/Db/Table/Abstract.php';
require_once 'Zend/Controller/Action.php';
require_once 'Zend/Form.php';

class UserTable extends Zend_Db_Table_Abstract {
        /**
         * User Table
         */
        protected $_name = 'user';

}

class ArtifactTable extends Zend_Db_Table_Abstract {
        /**
         * Artifact Table
         */
        protected $_name = 'artifact';

}

class ArtifactInputForm extends Zend_Form
{
		protected $_name = 'artForm';
	
		public function __construct($options = null){
                parent::__construct($options);
                $this->setName('artifact_title');
                $this->setMethod('POST');
                $this->setAction('/matrixproject/application/controllers/StudentartifactController/inputArtifact');

                $artifact_title = $this->addElement('text', 'artifact_title', array(
	            'filters'    => array('StringTrim'),
	            'validators' => array(
	                'Alnum',
	                array('StringLength', false, array(0, 49)),
	            ),
	            'required'   => true,
	            'label'      => 'Title:',
	        ));
	        
	        $description = $this->addElement('text', 'description', array(
	            'filters'    => array('StringTrim'),
	            'validators' => array(
	                'Alnum',
	                array('StringLength', false, array(0, 499)),
	            ),
	            'required'   => true,
	            'label'      => 'Description:',
	        ));
	        
	        $media_extention = $this->addElement('text', 'media_extention', array(
	            'filters'    => array('StringTrim'),
	            'validators' => array(
	                'Alnum',
	                array('StringLength', false, array(0, 4)),
	            ),
	            'required'   => true,
	            'label'      => 'Extention:',
	        ));
	
	        $submit = $this->addElement('submit', 'submit', array(
	            'required' => false,
	            'ignore'   => true,
	            'label'    => 'Submit',
	        ));
	
	        $this->addElements(array($artifact_title, $description, $media_extention, $submit));
        }
}

class UserService {
   protected $db;

   /**
    * student Zend table
    * Enter description here ...
    * @var unknown_type
    */
   protected $user;
   protected $artifact;

   function __construct(){
        $options = array(
            	'host' => 'localhost',
                'username' => 'jrdinkelman',
                'password' => 'Subm3rge',
                'dbname' => 'matrix_jrdinkelman'

        );

        $this->db = Zend_Db::factory('PDO_MYSQL', $options);
        Zend_Db_Table_Abstract::setDefaultAdapter($this->db);
        $this->user = new UserTable();
        $this->artifact = new ArtifactTable();

   }
   
   public function NewTestStudent(){
        $params = array(
        				'username' => 'jrdinkelman',
                		'last_name' => 'Dinkle',
            			'first_name' => 'Jeff3',
                		'middle_initial' => 'R',
                		'role' => 'S'
        				);

                $this->user->insert($params);
   }
   public function GetAllUsers()
   {
   		$select = $this->user->select();
   		$select->order('user_id');
   		return $this->user->fetchAll($select);
   }
   public function GetAllArtifacts($id)
   {
   		$select = $this->db->select()
   			->from(array('a' => 'artifact'), array('artifact_id', 'artifact_title', 'description', 'timestamp'))
   			->join(array('u'=>'user'), 'a.student_id = u.user_id')
   			->where('u.user_id = ?', $id);
   		return $this->db->fetchAll($select);
   }
   
   public function NewArtifact($artifact_title, $description, $media_extention)
   {
   		$params = array(
   					'artifact_title' => $artifact_title,
   					'description' => $description,
   					'media_extension' => $media_extention,
   					'student_id' => 1,
   					'course_id' => 1);
   		   					
   		$this->artifact->insert($params);
   }
   
   public function GetArtifact($id)
   {
   		$row = $this->artifact->find($artifact_id);
   		return $row;
   }

}

class StudentartifactController extends Zend_Controller_Action
{

	protected $userService;
	
    public function init()
    {
        /* Initialize action controller here */
    }
    
    public function preDispatch()
    {    	
        $this->userService = new UserService();
    }
    
    public function indexAction()
    {
        //$this->userService->NewTestStudent();
        //$rowset = $this->userService->GetAllUsers();
        $this->view->form = $this->getForm();
        
		$rowset = $this->userService->GetAllArtifacts(1);        
        $this->view->user = $rowset;
    }
    
    
    
    public function inputArtifactAction()
    {
    	print"nono";
	    $request = $this->getRequest();
       

        // Check if we have a POST request
        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }
        else{
        }
       
       
        // Validate username and password for matching criteria
        if (!$form->isValid($request->getPost()))
        {
            // Invalid entries
            $this->view->form = $form;
            return $this->render('index'); // re-render the login form
        }     
       
        // Validate against matrix database
        $artifact_title = $form->getValue('artifact_title');
        $description = $form->getValue('description');
        $media_extention = $form->getValue('media_extention');
        $this->userService->NewArtifact($artifact_title, $description, $media_extention);
        print"blahblah";
    }
    
    public function lookUpArtifact()
    {
    	$this->view->user = $this->userService->GetArtifact(_getParam('artifact_id'));
    }
    
    public function getForm()
    {
        /*return new Application_Model_LoginForm(array(
                'action' => 'login/process',
                'method' => 'post',
        ));*/    	
    }
    

}

