<!-- Authors: MD and PV-->
<?php
class Application_Model_ApproveArtifactForm extends Zend_Form
{	
	protected $approveArtifactFormService;    
	
	public function __construct($options = null)
	{
		parent::__construct($options);
		$this->setName('approveartifact');
		$this->setMethod('post');
		$this->setAction('/matrixproject/public/facultyapproveartifact/process');
		
		//Talk to the database to get the ratings-- rating_codes and descriptions
		$approveArtifactFormService = new App_UserService();  
		$ratings = $approveArtifactFormService->GetRatingCodes();
		$description = $approveArtifactFormService->GetRatingDescriptions();
		
		//Artifact comment area
		$this->addElement('textarea', 'artifactComments', 
			array('required' => true ));
        
		//Artifact rating dropdown selection
        $this->addElement('select', 'artifactRatingDropDown', 
        	array('required' => true, 'label' => 'Rating: ' ));
		
		//Cover Letter comment area
        $this->addElement('textarea', 'coverLetterComments', 
        	array('required' => true ));
        	        
		//Cover Letter rating dropdown selection
        $this->addElement('select', 'coverLetterRatingDropDown', array('required' => true, 
'label' => 'Rating: '));
        
        //Populate the rating of both the artifacts and cover letters with the rating codes 
and descriptions
        //from the database
        for($i = 0; $i < count($ratings); $i++)
		{
			$this->getElement('artifactRatingDropDown')
				
->addMultiOption($ratings[$i]["rating_code"],$description[$i]["description"] );
			$this->getElement('coverLetterRatingDropDown')
				
->addMultiOption($ratings[$i]["rating_code"],$description[$i]["description"] );
		}	
		
		//Save and Quit button        
        $this->addElement('submit', 'saveAndQuit', 
        	array('required' => false, 'ignore' => true, 'label' => 'Save For Later' ));
        
		//Save and Submit button      
        $this->addElement('submit', 'saveAndSubmit', 
        	array('required' => false, 'ignore' => true, 'label' => 'Save and Submit' 
));
	}
}

