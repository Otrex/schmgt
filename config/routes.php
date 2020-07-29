<?php

$router->get("", "home");

$router->get("home", "home");

$router->get("dashboard", "dashboard");

$router->get("fee", "fee");

$router->post("home", "home");

$router->post("login", "home&login");

//$router->post("error/login", "home&login");

$router->post("signup", "home&signup");

$router->post("dashboard", "dashboard");

$router->post("fee", "fee");

?>