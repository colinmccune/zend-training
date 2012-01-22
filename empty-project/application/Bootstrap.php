<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initTimezone()
    {
        date_default_timezone_set("America/Toronto");
    }
    
    protected function _initAutoloader()
    {
        // init resource
        $autoloader = Zend_Loader_Autoloader::getInstance();
        
        $autoloader->registerNamespace('Application_');

        // return resource
        return $autoloader;
    }
    
    protected function  _initAutoloaderResources()
    {
        // init dependencies
        $this->bootstrap('Autoloader');

        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath'  => APPLICATION_PATH,
            'namespace' => 'Application',
        ));        

        $resourceLoader->addResourceType('form', 'forms/', 'Form');
        $resourceLoader->addResourceType('model', 'models/', 'Model');

        return $resourceLoader;
    }

    protected function _initFrontController()
    {
        // init dependencies
        $this->bootstrap('Autoloader');

        // init resource
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->setRequest(new Zend_Controller_Request_Http());
        $frontController->setControllerDirectory(APPLICATION_PATH . '/controllers');
        $frontController->setParam('displayExceptions', TRUE);
        
        // return resource
        return $frontController;
    }
    
}
