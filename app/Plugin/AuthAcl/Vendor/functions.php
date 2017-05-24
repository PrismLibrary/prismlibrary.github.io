<?php
function siteURL()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'];
	return $protocol.$domainName;
}

function checkIsAuthorizedMethod($actions){
	$flag = false;
	foreach($actions as $action){
		if ($action['Aco']['alias'] == 'isAuthorized'){
			$flag = true;
			break;
		}
	}
	
	return $flag;
}