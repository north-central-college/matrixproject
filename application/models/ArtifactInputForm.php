<?php
class Application_Model_LoginForm extends Zend_Form
{
public function __construct($options = null){
                parent::__construct($options);
                $this->setName('artifact_title');
                $this->setMethod('POST');
                $this->setAction('/quickstart/application/controllers/Index2Controller/inputArtifact');

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
	
	        $login = $this->addElement('submit', 'submit', array(
	            'required' => false,
	            'ignore'   => true,
	            'label'    => 'Submit',
	        ));
	
	        $this->addElements(array($artifact_title, $description, $media_extention, $submit));
        }
}