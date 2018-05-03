<?php
function getConfig($param) {
	$config=array(
		"INFINI_MYSQL_HOST"=>"localhost",
		"INFINI_MYSQL_PORT"=>"",
		"INFINI_MYSQL_USER"=>"",
		"INFINI_MYSQL_DATABASE"=>"",
		"INFINI_MYSQL_PASSWORD"=>"",
		"INFINI_SALT"=>"",
		"INFINI_EMAIL_DOMAIN"=>"njupt.edu.cn",
		"INFINI_DOMAIN"=>"infini.1cf.co"
	);
	return $config[$param];
}
?>