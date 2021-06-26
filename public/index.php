<?php

use LevelIdeas\IdeaList;

require "../bootstrap.php";

$count = (int)($_GET["count"] ?? 2);
$count = max(2, min($count, 6));

$list = new IdeaList();
$ideas = $list->getGameMechanics($count);

$route = $_SERVER["SCRIPT_NAME"];
$route = substr($route, 0, strrpos($route, '/') + 1);

try {
	$view = $twig->render("index.twig", [
		"ideas" => $ideas,
		"styles" => file_get_contents("public/index.css"),
		"route" => $route
	]);
	echo($view);
} catch (Twig_Error_Loader $e) {
} catch (Twig_Error_Runtime $e) {
} catch (Twig_Error_Syntax $e) {
}
