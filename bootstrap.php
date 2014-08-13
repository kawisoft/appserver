<?php session_start(); //Start the php session

$env = getenv('APPLICATION_ENV') == 'development' ? 'dev' : 'prod';
$env = php_sapi_name() == 'cli-server' ? 'dev' : $env ;

#define('BASEPATH', TRUE); // This has been included to prevent direct access to certain files
define('ENV', $env);

// Define where AMFPHP should look for services to consume
define('SERVICE_DIR','../services/');
define('MANDISA_SERVICES', SERVICE_DIR . 'mandisa/');
define('EXAMPLE_SERVICES', SERVICE_DIR . '/ExampleServices/');
define('NAMESPACE_SERVICES', SERVICE_DIR . '/ServicesWithNamespace/');
define('VALUE_OBJECTS', SERVICE_DIR . 'Vo/');
define('NAMESPACE_VALUE_OBJECTS', SERVICE_DIR . '/NamespaceVo/');


/**/
//require_once dirname(__FILE__) . '/php-activerecord/ActiveRecord.php';
require_once 'vendor/autoload.php'; 



// initialize ActiveRecord
ActiveRecord\Config::initialize(function($cfg)
{
    $localhost = getenv('OPENSHIFT_MYSQL_DB_HOST'); 
    $db_username = getenv('OPENSHIFT_MYSQL_DB_USERNAME'); 
    $db_password = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
    $db          = getenv('OPENSHIFT_GEAR_NAME');

    $cfg->set_model_directory(SERVICE_DIR);
    $cfg->set_connections(array('dev' => 'mysql://root:welcome1@localhost/appserver_db',
                                'prod' => "mysql://$db_username:$db_password@$localhost/$db"
                              )
	
			);

    // you can change the default connection with the below
    $cfg->set_default_connection(ENV);
	
});
