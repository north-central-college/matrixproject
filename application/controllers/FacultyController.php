<?php

class FacultyController extends Zend_Controller_Action
{
	protected $facultylandingService;    
    
	public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {    	
		$facultylandingService = new App_UserService();                           
		
		$rowset = $facultylandingService->GetArtifactsForFacultyIDWithOrderAndLimitAndStatus(1, 'submitted_timestamp', 4, 2);              
		$this->view->user = $rowset->toArray();   	

		$name = $facultylandingService->GetFullNameForId(1);
		$this->view->currentUser = $name;
    }

//	public function pendingAction()
//	{		
//		$this->_redirect("module/controller/pending");
//		//http://robertbasic.com/blog/grouping-zend-framework-controllers-in-subdirectories/
//	}
}

