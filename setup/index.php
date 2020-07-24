<?php


require_once "autoloader.php";

require_once "htaccess-setup.php";

require_once "dirsetter.php";

# Loads Up neccessary Dependencies
autoload("core","../app", "../app/bootstrap");

autoload(
    "models","../app", "../app/core/Models", true
);

# Creates the htaccess file
create("/schmgt.edu/public");

# Sets up the root path
setDirectories("http://localhost/schmgt.edu");

?>