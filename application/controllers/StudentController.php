<?php
 
class StudentController extends Zend_Controller_Action
{

	protected $studentService;
	protected $userID = 2; //using a test value of '2' for user id
	
	public function preDispatch()
	{
		$this->studentService = new App_StudentService();
	}
	
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
    	$uploadrows = $this->studentService->GetUploads($this->userID);
    	$this->view->uploads = $uploadrows;
    	
    	$linkedrows = $this->studentService->GetLinkedArtifacts($this->userID);
    	$this->view->links = $linkedrows;
    	
    	$submittedrows = $this->studentService->GetSubmittedArtifacts($this->userID);
    	$this->view->submit = $submittedrows;
    	
    	$username = $this->studentService->GetUserName($this->userID);
    	$this->view->name = $username;
    	
    	$userprogram = $this->studentService->GetRoleName($this->userID);
    	$this->view->roledesc = $userprogram;
    	
    	$evalrows = $this->studentService->GetEvaluatedArtifacts($this->userID);
    	$this->view->evaluated = $evalrows;
    }
}