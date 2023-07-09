<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");
$route->namespace("Source\App");

/**
 * WEB ROUTES
 */
$route->group(null);
$route->get("/", "WebController:home");

/**
 * APP ROUTES
 */
$route->namespace("Source\App\App");
$route->group("/app");

//login
$route->get("/", "AuthController:root");
$route->get("/login", "AuthController:login");
$route->post("/login", "AuthController:login");
$route->get("/register", "AuthController:register");
$route->post("/register", "AuthController:register");
$route->get("/forget", "WebController:forget");
$route->post("/forget", "WebController:forget");
$route->get("/forget/{code}", "WebController:reset");
$route->post("/forget/reset", "WebController:reset");

//dash
$route->get("/dash", "DashController:dash");
$route->get("/dash/home", "DashController:home");
$route->post("/dash/home", "DashController:home");
$route->get("/logoff", "DashController:logoff");

//users
$route->get("/users/home", "UserController:home");
$route->post("/users/home", "UserController:home");
$route->get("/users/home/{search}/{page}", "UserController:home");
$route->get("/users/user", "UserController:user");
$route->post("/users/user", "UserController:user");
$route->get("/users/user/{user_id}", "UserController:user");
$route->post("/users/user/{user_id}", "UserController:user");

//requests
$route->get("/requests/home", "RequestController:home");
$route->post("/requests/home", "RequestController:home");
$route->get("/requests/home/{search}/{page}", "RequestController:home");
$route->get("/requests/request", "RequestController:request");
$route->post("/requests/request", "RequestController:request");
$route->get("/requests/request/{request_id}", "RequestController:request");
$route->post("/requests/request/{request_id}", "RequestController:request");

//notification center
$route->post("/notifications/count", "Notifications:count");
$route->post("/notifications/list", "Notifications:list");

/**
 * ADMIN ROUTES
 */
$route->namespace("Source\App\Admin");
$route->group("/admin");

//login
$route->get("/", "AuthController:root");
$route->get("/login", "AuthController:login");
$route->post("/login", "AuthController:login");
$route->get("/register", "AuthController:register");
$route->post("/register", "AuthController:register");
$route->get("/forget", "WebController:forget");
$route->post("/forget", "WebController:forget");
$route->get("/forget/{code}", "WebController:reset");
$route->post("/forget/reset", "WebController:reset");

//dash
$route->get("/dash", "DashController:dash");
$route->get("/dash/home", "DashController:home");
$route->post("/dash/home", "DashController:home");
$route->get("/logoff", "DashController:logoff");

//users
$route->get("/users/home", "UserController:home");
$route->post("/users/home", "UserController:home");
$route->get("/users/home/{search}/{page}", "UserController:home");
$route->get("/users/user", "UserController:user");
$route->post("/users/user", "UserController:user");
$route->get("/users/user/{user_id}", "UserController:user");
$route->post("/users/user/{user_id}", "UserController:user");

//clients
$route->get("/clients/home", "UserController:clients");
$route->post("/clients/home", "UserController:clients");
$route->get("/clients/home/{search}/{page}", "UserController:clients");
$route->get("/clients/client", "UserController:client");
$route->post("/clients/client", "UserController:client");
$route->get("/clients/client/{client_id}", "UserController:client");
$route->post("/clients/client/{client_id}", "UserController:client");

//requests
$route->get("/requests/home", "RequestController:home");
$route->post("/requests/home", "RequestController:home");
$route->get("/requests/home/{search}/{page}", "RequestController:home");
$route->get("/requests/request", "RequestController:request");
$route->post("/requests/request", "RequestController:request");
$route->get("/requests/request/{request_id}", "RequestController:request");
$route->post("/requests/request/{request_id}", "RequestController:request");

//notification center
$route->post("/notifications/count", "Notifications:count");
$route->post("/notifications/list", "Notifications:list");

/**
 * ERROR ROUTES
 */
$route->group("/ops");
$route->get("/{errcode}", "Web:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
