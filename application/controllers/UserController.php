<?php

class UserController extends Zend_Controller_Action
{
	 
   //protected static $error_flag = FALSE;
	
    public function init()
    {
        /* Initialize action controller here */
    	
    }

    public function indexAction()
    {
        // Retreive the form and assign it to the view
        $this->view->form = $this->getForm();
        
        // Test insert to table
        //$userService = new App_UserService();
      	//$userService->NewTestUser();
      	
        /*$queryResult = $userService->SelectUser('bmjones', 'bobjones');
        print_r($queryResult);*/
        
        
        /*$valid = $userService->ValidUserPassword('bmjones','bobjones');
        
        if ($valid)
        {
        	echo 'This is a valid user'; 
        	
        	$userRole = $userService->GetUserRole('bmjones');
        	
        	if ($userRole == 'U' || $userRole == 'L' || $userRole == 'G')
        	{
        		echo 'Go to STUDENT landing page';
        	}
        	else if ($userRole == 'F')
        	{
        		echo 'Go to FACULTY landing page';
        	}
        }
        else
        {
        	echo 'Invalid username or password. Please try again.';
        }*/
        
       

    }
    
    public function loginAction()
    {
        // action body
        //if form was submitted then {
        //
        //
        //else {
         $this->view->form = $this->getForm();
    	//}
    }
    
    public function getForm()
    {
    	return new Application_Model_LoginForm(array(
    		'action' => 'login/process',
    		'method' => 'post',
    	));
    }
    
    /*public function getAuthAdapter(array $params)
    {
    	// This will take an array of parameters which it then
    	// uses as credetials to verify identity.
    	// Our form should only pass
    }*/
    
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
        echo "valid";

        // Get our authentication adapter and check credentials
        
        /*$adapter = $this->getAuthAdapter($form->getValues());
        $auth    = Zend_Auth::getInstance();
        $result  = $auth->authenticate($adapter);
        
        if (!$result->isValid()) 
        {
            // Invalid credentials
            $form->setDescription('Invalid credentials provided');
            $this->view->form = $form;
            return $this->render('index'); // re-render the login form
        }*/
        
        // Validate against LDAP 
        
        // Validate against matrix database
        $username = $form->getValue('username');
        print_r($username);
        $password = $form->getValue('password');
        
        $userService = new App_UserService();
        $valid = $userService->ValidUserPassword($username, $password);
        
        if ($valid)
        {
        	//$this->error_flag = FALSE;
        	//$this->view->error_flag = $this->error_flag;
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
        	//$this->view->error_flag = $this->error_flag;
        	
        	$this->_helper->redirector('index', 'user');
        }
        
        /*
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        /*$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        
        $authAdapter->setTableName('user');
        $authAdapter->setIdentityColumn('username');
		$authAdapter->setCredentialColumn('password');
        $authAdapter->setCredentialTreatment('MDS(?');
        
        // Pass to the adapter the submitted username and password
        $authAdapter->setIdentity($username);
        $authAdapter->setCredential($password);*/
        
        // We're authenticated! Redirect to the home page
        //$this->_helper->redirector('index', 'index');	
        //echo 'hi';
    }
    
	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		// Go back to the login page
		$this->_helper->redirector('index'); 
	}
}