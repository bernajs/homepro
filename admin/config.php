<?php
error_reporting(0);
switch($_SERVER['SERVER_NAME']){
	case "localhost":
	case "dev":
	case "taxania":
	define("SERVER_HOST","localhost");   
	define('SERVER_USER',"root");
	define('SERVER_PASS',"qwerty123");
	define('SERVER_DB',"taxania");
	break;
	case "dev.mobkii.net":
	define("SERVER_HOST","mobkii.net");   
	define('SERVER_USER',"mobkiiah_dev");
	define('SERVER_PASS',"qwerty123");
	define('SERVER_DB',"mobkiiah_taxiapp");
	break;
	case "homepro.mx":
	define("SERVER_HOST","homepro.mx");   
	define('SERVER_USER',"1033529_homepro");
	define('SERVER_PASS',"mobkii1M");
	define('SERVER_DB',"1033529_homepro");
	break;    
}
/*define("SERVER_HOST","mobkii.net");   
   define('SERVER_USER',"mobkiiah_dev");
   define('SERVER_PASS',"qwerty123");
   define('SERVER_DB',"mobkiiah_taxiapp");*/
   ?>