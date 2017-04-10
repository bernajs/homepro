<?php
error_reporting(1);
define('ONESIGNAL_APPID',"3a7e988f-11d9-428b-98f1-9113b15ca93f");
define('ONESIGNAL_APIKEY',"YWE5YzNkOGItYTRkYS00ZjI4LTk2YmUtYjY3YzkyZTFlODdl");
define('NONESIGNAL_APPID',"b81a7f7e-fa00-4b10-bda7-b1550a8d8e8b");
define('NONESIGNAL_APIKEY',"MGU2OTg2ZWItZGFhNC00MjQ5LTk0MmYtMjg4ZGVkODBmYTUy");
date_default_timezone_set('America/Monterrey');
switch($_SERVER['SERVER_NAME']){
    case "localhost":
        define("SERVER_HOST","localhost");
        define('SERVER_USER',"root");
        define('SERVER_PASS',"");
        define('SERVER_DB',"homepro");
        break;
    case "serviciosapp.mobkii.net":
        define("SERVER_HOST","serviciosapp.mobkii.net");
        define('SERVER_USER',"mobkiiah_lgarcia");
        define('SERVER_PASS',"Mobkii2017");
        define('SERVER_DB',"mobkiiah_serviciosapp");
        break;
    case "taxania":
        define("SERVER_HOST","localhost");
        define('SERVER_USER',"root");
        define('SERVER_PASS',"qwerty123");
        define('SERVER_DB',"taxania");
        break;
    case "taxania.mobkii.net":
        define("SERVER_HOST","localhost");
        define('SERVER_USER',"mobkiiah_dev");
        define('SERVER_PASS',"qwerty123");
        define('SERVER_DB',"mobkiiah_taxiapp");
        break;
    case "taxania.mx":
        define("SERVER_HOST","mobkii.net");
        define('SERVER_USER',"mobkiiah_dev");
        define('SERVER_PASS',"qwerty123");
        define('SERVER_DB',"mobkiiah_taxiapp");
        break;
    case "app.homepro.mx":
        define("SERVER_HOST","172.99.97.96");
        define('SERVER_USER',"1033529_homepro");
        define('SERVER_PASS',"mobkii1M");
        define('SERVER_DB',"1033529_homepro");
        break;
}
?>