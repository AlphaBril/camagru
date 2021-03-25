<?php

session_start();

if (!$_SESSION['user'])
	require_once($_SERVER['DOCUMENT_ROOT'] . '/mvc/view/login.php');
else
	require_once("mvc/view/camera_view.php");

function get_filters()
{
	foreach (glob("public/img/filters/*") as $filters)
		echo "<div class=filters><img style='border:none;' class='filters_img' src=\"" . $filters . "\"></div>";
}

function get_results()
{
	echo "<div class=results><img id=\"photo\" src=\"" . $test . "\"></div>";
}
