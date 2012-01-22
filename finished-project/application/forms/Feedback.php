<?php
 
class Application_Form_Feedback extends Zend_Form
{
    public function init()
    {
        
        // Set the method for the display form to POST
        $this->setMethod('post');

        
        // Name
        $element = new Zend_Form_Element_Text('name');
        $element->setLabel('Name');
        $element->setDescription('What is your first and last name?');
        $element->setRequired(true);
        $element->addFilter('StringTrim');
        $element->addValidator('Alpha');
        
        $this->addElement($element);
        
        
        // Email
        $element = new Zend_Form_Element_Text('email');
        $element->setLabel('Email');
        $element->setDescription('Please give us your email address so we can spam you!');
        $element->setRequired(true);
        $element->setAttrib('size', 50);
        $element->addFilter('StringTrim');
        $element->addValidator('EmailAddress');
        
        $this->addElement($element);
        
        
        // Topic
        $element = new Zend_Form_Element_Select('topic');
        $element->setLabel('Topic');
        $element->setDescription('Why you are bothering us?');
        $element->setRequired(true);
        $element->addMultiOptions(array(
            'help' => 'Do not understand the help page',
            'board' => 'I am board and have nothing else todo',
            'misc' => 'What is a feedback form?'
        ));

        $this->addElement($element);
        
        
        // How Are You Feeling Today
        $element = new Zend_Form_Element_Radio('feeling');
        $element->setLabel('How Are You Feeling Today?');
        $element->setDescription('Please tell us how you are feeling today so that we can decide if your feedback is worth listening to!');
        $element->setRequired(true);
        $element->addMultiOptions(array(
            '1' => 'Pissed Off At The World',
            '5' => 'Meh',
            '10' => 'Super Happy Fun Time!'
        ));
        
        $this->addElement($element);
        

        // Feedback
        $element = new Zend_Form_Element_TextArea('feedback');
        $element->setLabel('Feedback');
        $element->setDescription('Please comment (Min 5 Character | Max 10 Characters)');
        $element->setRequired(true);
        $element->addValidator(new Zend_Validate_StringLength(array('min' => 5, 'max' => 10)));
        
        $this->addElement($element);
        
        
        // Captcha
        /*
        $element = new Zend_Form_Element_Captcha('foo', array(
            'label' => "You are a human right??",
            'captcha' => 'Figlet',
            'captchaOptions' => array(
                'captcha' => 'Figlet',
                'wordLen' => 6,
                'timeout' => 300,
            ),
        ));
        $this->addElement($element);
        */
 
        
        // Submit
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit Feedback',
        ));
 
    }
}