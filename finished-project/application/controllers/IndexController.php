<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function helpAction()
    {
        // action body        
    }
    
    public function feedbackAction()
    {
        $request = $this->getRequest();

        $form = new Application_Form_Feedback();

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($request->getPost())) {

                // save data
                //$this->_saveFeedback1($form);
                $this->_saveFeedback2($form);

                // redirect to home
                //return $this->_helper->redirector('index');
                return $this->_helper->redirector->gotoSimple('thank-you', 'index');

            }
        }

        $this->view->form = $form;
    }

    private function _saveFeedback1($form)
    {
        //error_log(print_r($form->getValues(), true));

        // hard way :(
        $data = array(
            'name' => $form->getValue('name'),
            'email' => $form->getValue('email'),
            'topic' => $form->getValue('topic'),
            'feeling' => $form->getValue('feeling'),
            'feedback' => $form->getValue('feedback'),
        );

        // fast way :)
        $data = $form->getValues();

        $db = Zend_Registry::get('Zend_Db');
        $db->insert('feedback', $data);
    }
    
    private function _saveFeedback2($form)
    {
        //error_log(print_r($form->getValues(), true));

        $table = new Application_Model_Feedback();

        $row = $table->createRow();
        $row->setFromArray($form->getValues());
        $row->save();
    }
    
    public function thankYouAction()
    {
        
    }
    
    public function viewFeedbackAction()
    {
        // get feedback entries
        //$this->view->feedbackEntries = $this->_getFeedback1();
        $this->view->feedbackEntries = $this->_getFeedback2();

    }
    
    private function _getFeedback1() {
        $db = Zend_Registry::get('Zend_Db');

        $sql = 'SELECT * FROM feedback';
        $result = $db->fetchAll($sql);

        //$sql = 'SELECT * FROM feedback WHERE id = ?';
        //$result = $db->fetchAll($sql, 5);

        //$sql = 'SELECT * FROM feedback ORDER BY feeling DESC';
        //$result = $db->fetchAll($sql, 5);        

        //error_log(print_r($result, TRUE));

        return $result;
    }
    
    private function _getFeedback2() {

        $table = new Application_Model_Feedback();

        $db = $table->getDefaultAdapter();

        $select = $table->select();
        $result = $db->fetchAll($select);

        //$select = $table->select();
        //$select->where('id = ?', 5);
        //$result = $db->fetchAll($select);

        //$select = $table->select();
        //$select->order('feeling DESC');
        //$result = $db->fetchAll($select);

        //error_log($select);
        //error_log(print_r($result, TRUE));

        return $result;
    }
    
    public function viewFeedbackPagedAction()
    {
        $table = new Application_Model_Feedback();

        $paginator = Zend_Paginator::factory($table->select());

        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(3);

        $this->view->paginator = $paginator;
    }    
    
    public function switchLanguageAction()
    {
        $defaultNamespace = new Zend_Session_Namespace('Default');

        $nextLocale = ($defaultNamespace->locale == 'en') ? 'fr' : 'en';
        $defaultNamespace->locale = $nextLocale;

        return $this->_helper->redirector('index');
    }
    
    public function crunchDataAction()
    {
        $cacheId = 'crunchData';

        $cache = Zend_Registry::get('cache');


        if (($counter = $cache->load($cacheId)) === false)
        {
            // cache miss
            $cacheStatus = 'Cache Miss :(';

            // do time consuming work here....
            $counter = 0;

            for ($i = 0; $i < 100000000; $i++) {
                $counter += 1;
            }

            // save result to cache
            $cache->save($counter, $cacheId);
        } else {
            $cacheStatus = 'Cache Hit!!!';
        }

        $this->view->cacheStatus = $cacheStatus;
        $this->view->counter = $counter;
    }
    
    public function clearCacheAction()
    {
        $cache = Zend_Registry::get('cache');
        $cache->clean(Zend_Cache::CLEANING_MODE_ALL);
        $this->_redirect('index');
    }

}
