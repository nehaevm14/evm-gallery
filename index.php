<?php

require('../vendor/autoload.php');

require('../shopify.php');
define("SHOPIFY_API_KEY", getenv("7f5683ce5bc0596779cba7b2ccb56ae5"));
define("SHOPIFY_SECRET", getenv("9068aec0e1ad538918ba57f0c56e00a6"));
define("SHOPIFY_SCOPE", getenv("read_products,write_products,read_script_tags,write_script_tags,write_themes,read_content, write_content"));

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Our web handlers

$app->match('/', function(Request $request) use($app) {
  $app['monolog']->addDebug('logging output.');

  ob_start();
  include('index.inc.php');
  return new Response(ob_get_clean(), 200);
});

$app->match('/rates', function(Request $request) use($app) {
  $app['monolog']->addDebug('logging output.');

  ob_start();
  include('rates.inc.php');
  return new Response(ob_get_clean(), 200);
});

$app->run();

