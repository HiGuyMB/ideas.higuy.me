<?php
require "vendor/autoload.php";

chdir(__DIR__);
define("ROOT_DIR", __DIR__);

$loader = new Twig_Loader_Filesystem(ROOT_DIR . "/templates");
$twig = new Twig_Environment($loader, []);
