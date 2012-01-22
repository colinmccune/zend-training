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

    protected function _initDb()
    {
        // init resource
        $db = Zend_Db::factory('Pdo_Mysql', array(
            'host' => '192.168.1.64',
            'username' => 'zend_training',
            'password' => 'zend_training',
            'dbname' => "zend_training",
            'charset' => 'utf8',
        ));

        // set default table adapter
        Zend_Db_Table_Abstract::setDefaultAdapter($db);

        // register resource
        Zend_Registry::set('db', $db);
        Zend_Registry::set('Zend_Db', $db);

        // return resource
        return $db;
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
    
    protected function _initRoutes()
    {
        // init dependencies
        $this->bootstrap('FrontController');

        // init resource
        $router = $this->frontController->getRouter();

        // default
        $router->addRoute('default', new Zend_Controller_Router_Route(
            ':controller/:action/*',
            array(
                'controller' => 'index',
                'action' => 'index'
            )
        ));
        
        // help
        $router->addRoute('help', new Zend_Controller_Router_Route(
            'help',
            array(
                'controller' => 'index',
                'action'     => 'help'
            )
        ));

        // feedback
        $router->addRoute('feedback', new Zend_Controller_Router_Route(
            'feedback',
            array(
                'controller' => 'index',
                'action'     => 'feedback'
            )
        ));
        
        // view feedback
        $router->addRoute('view-feedback', new Zend_Controller_Router_Route(
            'view-feedback',
            array(
                'controller' => 'index',
                'action'     => 'view-feedback'
            )
        ));
        
        // view feedback paged
        $router->addRoute('view-feedback-paged', new Zend_Controller_Router_Route(
            'view-feedback-paged/:page',
            array(
                'controller' => 'index',
                'action'     => 'view-feedback-paged',
                'page'       => 1
            )
        ));        

        // thank-you
        $router->addRoute('thank-you', new Zend_Controller_Router_Route(
            'thank-you',
            array(
                'controller' => 'index',
                'action'     => 'thank-you'
            )
        ));
        
        // crunch data
        $router->addRoute('crunch-data', new Zend_Controller_Router_Route(
            'crunch-data',
            array(
                'controller' => 'index',
                'action'     => 'crunch-data'
            )
        ));

    }
    
    protected function _initLayout()
    {
        // init resource
        $layout = Zend_Layout::startMvc();
        $layout->setLayoutPath(APPLICATION_PATH . '/layouts/scripts');
        
        // Set the sites layout file to be 'layout.phtml'
        $layout->setLayout('layout');

        // return resource
        return $layout;
    }
    
    protected function _initView()
    {
        // init dependencies
        $this->bootstrap('Frontcontroller');

        // init resource
        $view = new Zend_View();

        // init xhtml
        $view->doctype(Zend_View_Helper_Doctype::XHTML1_STRICT);
        $view->setEncoding('UTF-8');
        
        // init meta tags
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=UTF-8');        

        // init title
        $view->headTitle()->setSeparator(' : ');
        $view->headTitle('Feedback Form 2000!');

        // init css
        $view->headLink()->appendStylesheet('/application.css');

        // init js
        //$view->headScript()->appendFile('/application.js');

        // return resource
        return $view;        

    }
    
    protected function _initLocale()
    {
        // init resource
        $currentLocale = 'en';
        
        // get locale from session
        $defaultNamespace = new Zend_Session_Namespace('Default');
        
        if (isset($defaultNamespace->locale)) {
            $currentLocale = $defaultNamespace->locale;
        } else {
            $defaultNamespace->locale = $currentLocale;
        }

        // set locale
        $locale = new Zend_Locale($currentLocale);

        // register resource
        Zend_Registry::set('locale', $locale);
        Zend_Registry::set('Zend_Locale', $locale);

        // return resource
        return $locale;
    }

    protected function _initTranslate()
    {
        // init dependencies
        $this->bootstrap('Locale');

        // init resource
        $french = array(
            'Home' => 'Accueil',
            'Change Language' => 'Changer la langue',
            'Clear Cache' => 'Vider le cache',
            'Feedback Form 2000!' => '2000 Formulaire de commentaires!',
            'Leave Feedback' => 'Laissez vos commentaires',
            'View Feedback' => 'Afficher le feedback',
            'View Feedback Paged' => 'Afficher le feedback paginée',            
            'Crunch Data' => 'Crunch de données',
            'Help' => 'Aide',
            'This is a pretty simple site do you really need help???' => "Il s'agit d'un site assez simple avez-vous vraiment besoin d'aide???",
            'Name' => 'Non',
            'What is your first and last name?' => 'Quel est votre nom et prénom?',
            'Email' => 'Email',
            'Please give us your email address so we can spam you!' => "S'il vous plaît donnez-nous votre adresse e-mail afin que nous puissions vous spam!",
            'Topic' => 'Sujet',
            'Why you are bothering us?' => 'Pourquoi êtes-vous nous dérange?',
            'Feeling' => 'Sentiment',
            'How Are You Feeling Today?' => "Comment vous sentez-vous aujourd'hui?",
            'Do not understand the help page' => "Je ne comprends pas la page d'aide",
            'I am board and have nothing else todo' => "Je suis conseil d'administration et n'ont rien d'autre choses à faire",
            'What is a feedback form?' => "Qu'est-ce qu'un formulaire de commentaires?",
            'Pissed Off At The World' => 'Chier le monde',
            'Meh' => 'Meh',
            'Super Happy Fun Time!' => 'Super Fun Time heureux!',
            'Please tell us how you are feeling today so that we can decide if your feedback is worth listening to!' => "S'il vous plaît dites-nous comment vous vous sentez aujourd'hui afin que nous puissions décider si votre opinion est digne d'intérêt!",
            'Feedback' => 'Commentaires',
            'Please comment (Min 5 Character | Max 10 Characters)' => "S'il vous plaît commentaire (minimum 5 caractères | Maximum 10 caractères)",
            'Thank You' => 'Je vous remercie',
            'Thanks for wasting out time! We will be sure to get back to your shortly.... But only if we feel like it!' => "Merci de gaspiller les temps! Nous ne manquerons pas de revenir à votre peu de temps .... Mais seulement si ça nous chante!",
            'Crunching.....' => 'Une puissance de calcul .....',
            'We crunched %1\$s pieces of data.' => "Nous croqué %1\$s morceaux de données.",
            'Cache Hit!!!' => 'Cache Hit!!!',
            'Cache Miss :(' => 'Cache Miss :(',
        );
        
        $translate = new Zend_Translate('Array', $french, 'fr', array(
            'disableNotices' => true
        ));
        
        // Set the current language
        $translate->setLocale($this->locale);
        
        // register resource
        Zend_Registry::set('translate', $translate);
        Zend_Registry::set('Zend_Translate', $translate);

        // return resource
        return $translate;
    }
    
    protected function _initSession()
    {
        Zend_Session::start();
    }
    
    protected function _initCache()
    {
        // init resource

        // We choose a backend (for example 'File' or 'Sqlite'...)
        $backendName = 'File';

        // We choose a frontend (for example 'Core', 'Output', 'Page'...)
        $frontendName = 'Core';

        // We set an array of options for the chosen frontend
        $frontendOptions = array(
            'automatic_serialization' => true
        );

        // We set an array of options for the chosen backend
        $backendOptions = array(
            'cache_dir' => APPLICATION_PATH . '/../data/cache'            
        );

        // We create an instance of Zend_Cache
        // (of course, the two last arguments are optional)
        $cache = Zend_Cache::factory($frontendName,
                                     $backendName,
                                     $frontendOptions,
                                     $backendOptions);

        Zend_Registry::set('cache', $cache);
    }

}

