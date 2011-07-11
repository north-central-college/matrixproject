<!-- Authors: MD and PV-->
<?php
require_once 'Zend/Db/Table/Abstract.php';

class FacultyapproveartifactController extends Zend_Controller_Action
{
	protected $facultyapproveartifactService;
    
	public function init()
    {
    }

    public function indexAction()
    {    	
    	//Get the artifact ID from the url
    	$this->view->artifactId = $this->getRequest()->getParam('artifactid');  
    	
    	//Get and instance of the UserService and query the database for info on this 
artifact
		$facultyapproveartifactService = new App_UserService();      	    	
		$artifactDetail = $facultyapproveartifactService->GetArtifactByID(1, 
$this->view->artifactId)->toArray();
		$this->view->artifactDetail = $artifactDetail;
		
		//If the user tries to access an invalid artifact, redirect them to the 
error page
		if($artifactDetail == NULL)
		{			
       		$this->_redirect("error");
		}		
				
        $this->view->form = $this->getForm();
        
        //If any previous comments or ratings exist in the database, reload them by 
populating the form
        $data = array('artifactComments' => $artifactDetail[0]["artifact_comments"], 
        			  'coverLetterComments' => 
$artifactDetail[0]["reflective_comments"],
        			  'artifactRatingDropDown' => 
$artifactDetail[0]["artifact_rating_code"], 
        			  'coverLetterRatingDropDown' => 
$artifactDetail[0]["reflective_rating_code"]);        
        $this->view->form->populate($data);
        
//    	$registry = Zend_Registry::getInstance();
//    	var_dump($registry);        
//        $test = 
$facultyapproveartifactService->SaveArtifactApproveFormWithStatus($artifactDetail[0]["artifact_rating_id"], 
//        	$artifactDetail[0]["reflective_statement_id"], "THIS AC WORKED", "B", "THIS 
RC WORKED", "C", 3, false);
//        
//        var_dump($test);
    }
    
    /**
     * 
     * Gets an instance of the Zend_Form ApproveArtifactForm     *
     */
    public function getForm()
    {		
    	return new Application_Model_ApproveArtifactForm(    	
    		array('action' => 'login/process', 'method' => 'post',));
    }
    
    /**
     * 
     * Updates the database with the comments and ratings from the form when a button is 
clicked     * 
     */    
 	public function processAction()
    {     	
    	
//        $request = $this->getRequest();
//    	
//        // Check if we have a POST request
//        if (!$request->isPost()) {
//            return $this->_helper->redirector('index');
//        }
//                
//        $form = $this->getForm();

    	//Not working

    	//Get the values from the form    
//      $artifactComments = $form->getValue('artifactComments');
//      $coverLetterComments = $form->getValue('coverLetterComments');
//      $artifactRatingDropDown = $form->getValue('artifactRatingDropDown');
//      $coverLetterRatingDropDown = $form->getValue('coverLetterRatingDropDown');	

    	//Update the database with the new values from the form
//      $facultyapproveartifactService = new App_UserService();     
//		$artifactratingid = $this->_artifactratingid;
//		$reflectiveratingid = $this->_reflectiveratingid;        
//		$valid = 
$facultyapproveartifactService->SaveArtifactApproveFormWithStatus($artifactratingid, 
//      $reflectiveratingid, $artifactComments, $artifactRatingDropDown,
//   	$coverLetterComments, $coverLetterRatingDropDown, false);
   		
    	//Redirect the user to the facultylanding page	
		$this->_helper->redirector('index', 'facultylanding');           

	}
}

