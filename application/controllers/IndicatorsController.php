<?php
class IndicatorsController extends Zend_Controller_Action
{
 	
	protected $userService;
	protected $userID = 2;
		
	
	
	public function preDispatch()
	{
		$this->userService = new App_StudentService();
		
	}
	
    public function init()
    {
        /* Initialize action controller here */
    	
    }

    public function indexAction()
    {
    	$this->view->standard_id = $this->_getParam('standard');
    	
    	$indicators = $this->userService->GetIndicatorsbyStandard($this->view->standard_id);
    	$this->view->ind = $indicators;
    	    	

    	
    	    	    	  	    	
    	
    }
}

