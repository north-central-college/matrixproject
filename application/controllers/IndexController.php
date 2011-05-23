<?php

class IndexController extends Zend_Controller_Action
{
	 
   //protected $this->view->$error_flag = FALSE;
	
    public function init()
    {
        /* Initialize action controller here */
    	
    }

    public function indexAction()
    {
        // Retreive the form and assign it to the view
        $this->view->form = $this->getForm();
    }
    
    public function loginAction()
    {
         $this->view->form = $this->getForm();
    }
    
    public function getForm()
    {
    	return new Application_Model_LoginForm(array(
    		'action' => 'login/process',
    		'method' => 'post',
    	));
    }
    
    // If the user is already authenticated, but has not requested to logout,
    // we should redirect to the home page
    // If the user is not authenticated, but has requested to logout, 
    // we should redirect to the login page
    public function preDispatch()
    {
    	if (Zend_Auth::getInstance()->hasIdentity())
    	{
    		// If the user is logged in, we do not want to show the login form;
    		// however, the logout action should be still available
    		if ('logout' != $this->getRequest()->getActionName())
    		{
    			$this->_helper->redirector('index', 'index');
    		}
    		else
    		{
    			// If they aren't they can't logout, so that action should
    			// redirect to the login form
    			if ('logout' == $this->getRequest()->getActionName())
    			{
    				$this->_helper->redirector('index');
    			}
    		}
    	}
    }
    
    public function processAction()
    {
    	$request = $this->getRequest();
    	
        // Check if we have a POST request
        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }
        
        // Get our form and validate it
        $form = $this->getForm();
        
        // Validate username and password for matching criteria
        if (!$form->isValid($request->getPost())) 
        {
            // Invalid entries
            $this->view->form = $form;
            return $this->render('index'); // re-render the login form
        }
        
        
        // Validate against LDAP 
        
        // Validate against matrix database
        $username = $form->getValue('username');
        print_r($username);
        $password = $form->getValue('password');
        
        $userService = new App_UserService();
        $valid = $userService->ValidUserPassword($username, $password);
        
        if ($valid)
        {
        	//$this->view->error_flag = FALSE;
        	$userRole = $userService->GetUserRole($username);
       		
        	if ($userRole == 'U' || $userRole == 'L' || $userRole == 'G')
        	{
        		$this->_helper->redirector('index', 'student');
        	}
        	else if ($userRole == 'F')
        	{
        		$this->_helper->redirector('index', 'faculty');
        	}
        	
        	//$this->_helper->redirector('index', 'index');
        }
        else
        {
        	// Redirect to the login page
        	//$this->view->error_flag = TRUE;
        		
        	$this->_helper->redirector('index', 'user');
        }
        
    }
    
	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		// Go back to the login page
		$this->_helper->redirector('index'); 
	}
}