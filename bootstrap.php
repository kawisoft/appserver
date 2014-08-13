<?php session_start(); //Start the php session

$env = getenv('APPLICATION_ENV') == 'development' ? 'dev' : 'prod';
$env = php_sapi_name() == 'cli-server' ? 'dev' : $env ;

#define('BASEPATH', TRUE); // This has been included to prevent direct access to certain files
define('ServicesDir', '/Services/');
define('ENV', $env);



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

    $cfg->set_model_directory(dirname(__FILE__) . '/Services');
    $cfg->set_connections(array('dev' => 'mysql://root:welcome1@localhost/appserver_db',
                                'prod' => "mysql://$db_username:$db_password@$localhost/$db"
                              )
	
			);

    // you can change the default connection with the below
    $cfg->set_default_connection(ENV);
	
});


//-- Manually loading AMFPHP might be necessary since it is being managed by composer
//-- yet to test and confirm though
/* LOAD AMFPHP 2.2.1
######################################################################################################## */
require_once dirname(__FILE__) . 'vendor/silexlabs/amfphp/Amfphp/ClassLoader.php';

// Define where AMFPHP should look for services to consume
define('SERVICE_DIR','services');
define('NAMESPACE_SERVICES','ServicesWithNamespace/');
define('VALUE_OBJECTS','Vo/');
define('NAMESPACE_VALUE_OBJECTS','NamespaceVo/');
