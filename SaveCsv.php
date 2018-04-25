<?php
error_reporting(E_ERROR);

function avoidDDOS($value='')
{
	@session_start();
	// Assuming session is already started
	$ip = md5($_SERVER["REMOTE_ADDR"]);
	$exp = 0.3; // s
	$hash = $ip .'|'. microtime(true);
	if (!isset($_SESSION['ddos'])) {
	    $_SESSION['ddos'] = $hash;
	}

	list($_ip, $_exp) = explode('|', $_SESSION['ddos']);
	if ($_ip == $ip && (microtime(true) - $_exp) < $exp) {
	    header('HTTP/1.1 503 Service Unavailable');
	    die;
	}

	// Save last request
	$_SESSION['ddos'] = $hash;
}
avoidDDOS();

function iniFolder($folder)
{
	if (!file_exists($folder)) {
	    mkdir($folder, 0777);
	}
}
function changeComma($str)
{
	return '"'.$str.'"';
}

$name = $_POST['name'];
$image = $_POST['image'];
$message = $_POST['message'];

$rs = [
	'status' => 'SUCCESS',
	'message' => 'Save data successfully !',
	'data' => "User name : " . $name .PHP_EOL."Image : " . $image .PHP_EOL."Message : " . $message
];

try {
	$homeDir = __DIR__;
	$folderCsv = $homeDir.'/../../../Instagram-post-csv';
	$folderDate = $folderCsv.'/'.date('Ymd');
	$fileUser = $folderDate.'/'.$name.'('.date('Ymd').').csv';
	iniFolder($folderCsv);
	iniFolder($folderDate);

	$content = changeComma($message).',,,'.changeComma($image).PHP_EOL;
	$f = fopen($fileUser, 'a');
	fwrite($f, $content);
	fclose($f);
} catch (Exception $e) {
	$rs = [
		'status' => 'ERROR',
		'message' =>  $e->message()
	];
}

exit(json_encode($rs));

