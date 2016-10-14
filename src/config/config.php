<?php
return new \Phalcon\Config([
    'database' => [
        'adapter'   => 'Mysql',
        'host'      => '104.236.73.187',
        'username'  => 'zentasql',
        'password'  => 'zCFAvFwvPLbZpUFU',
        'dbname'    => 'mibar'
    ],
    'application' => [
        'controllersDir'    => APP_DIR.'/controllers/',
        'businessDir'       => APP_DIR.'/business/',
        'utilitiesDir'      => APP_DIR.'/utilities/',
        'modelsDir'         => APP_DIR.'/models/',
        'formsDir'          => APP_DIR.'/forms/',
        'libraryDir'        => APP_DIR.'/library/',
        'pluginsDir'        => APP_DIR.'/plugins/',
        'cacheDir'          => APP_DIR.'/cache/',
        'baseUri'           => '/mibar/',
        'publicUrl'         => '/mibar/',
        'cryptSalt'         => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D'
    ],
    'amazon' => [
        'AWSAccessKeyId'    => '',
        'AWSSecretKey'      => ''
    ], 
    'noAuth'        => [         
        'session'   => array('*'    =>  true),
        'welcome'   => array('*'    =>  true),
        'menu'   => array('*'    =>  true),
        'prueba'    => array('*'    =>  true),
        'test'      => array('*'    =>  true)
    ],
    'appTitle'      =>'MiBar',
    'appName'       =>"MiBar",
    'appAutor'      =>'Zenta',
    'appAutorLink'  =>'Zenta',
]);