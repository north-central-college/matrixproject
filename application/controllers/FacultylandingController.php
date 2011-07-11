<?php

class FacultylandingController extends Zend_Controller_Action
{
	protected $facultylandingService;    
    
	public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {    	
		//Get an instance of the User Servicen and the sort parameter out of the url
		$facultylandingService = new App_UserService();   		
    	$this->view->sortParameter = $this->getRequest()->getParam('sort');  
    	
    	//If no sort is specified default to ascending order by date submitted
    	if($this->view->sortParameter == NULL) 
    	{
			$rowset = $facultylandingService->GetArtifactsForFacultyIDWithOrderAndStatus(1, 'submitted_timestamp', 2);       
			$this->view->user = $rowset->toArray(); 
    	}
    	else 
    	{
    		//Parse the sort string parameter
    		$sortTokens = explode('&', $this->view->sortParameter);
    		$orderToken = explode('=', $sortTokens[0]);
    		$sortbyToken = explode('=', $sortTokens[1]);
    		
    		//Note for now: ignoring the sort by asc/desc, sort is always done in ascending order
			$rowset = $facultylandingService->GetArtifactsForFacultyIDWithOrderAndStatus(1, $sortbyToken[1], 2);       
			$this->view->user = $rowset->toArray(); 
    	}	

    	//get the faculty member's to display on the page    	
		$name = $facultylandingService->GetFullNameForId(1);
		$this->view->currentUser = $name;     
    }

//	public function pendingAction()
//	{		
//		$this->_redirect("module/controller/pending");
//		//http://robertbasic.com/blog/grouping-zend-framework-controllers-in-subdirectories/
//	}
}

