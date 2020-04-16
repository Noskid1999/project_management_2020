<?php

include_once 'Request.php';
include_once 'Router.php';
$router = new Router(new Request);
// php -S 127.0.0.1:8000
$router->get('/', function ($request) {
  includeWithVariables('main.php', array('user' => 'dikson'));
});
$router->get('/login', function ($request) {
  includeWithVariables('login.php');
});


$router->get('/profile', function ($request) {
  return <<<HTML
  <h1>Profile</h1>
HTML;
});

$router->post('/data', function ($request) {

  return json_encode($request->getBody());
});

function includeWithVariables($filePath, $variables = array(), $print = true)
{
  $output = NULL;
  if (file_exists($filePath)) {
    // Extract the variables to a local namespace
    extract($variables);

    // Start output buffering
    ob_start();

    // Include the template file
    include $filePath;

    // End buffering and return its contents
    $output = ob_get_clean();
  }
  if ($print) {
    print $output;
  }
  return $output;
}
