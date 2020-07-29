<?php


require_once "autoloader.php";

require_once "htaccess-setup.php";

require_once "dbObjCreator.php";

# Loads Up neccessary Dependencies
autoload("core","../app", "../app/bootstrap");

autoload(
    "models","../app", "../app/core/Models", true
);

# Creates the htaccess file
create("/schmgt/public");

# Set up Db
setUpDb("127.0.0.1","schmgt","root", "");

?>