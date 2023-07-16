<?php

// Montando o código do erro que será apresentado
$localizar  = array( strtolower(__DIR__), "/", "\\", ".php", ".");
$substituir = array( "", "", "", "", "-" );
$error_code = strtoupper( str_replace( $localizar, $substituir,  strtolower( __FILE__  ) ) ) . "-";

// Declarando os caminhos principais do sistema.
$localizar 	= array( "\\" );	
$substituir	= array( "/" );
$path 		= str_replace( $localizar, $substituir, __DIR__);


// Carregando as informações da requisição
$request = $_REQUEST;
if( isset( $_FILES ) && !empty(  $_FILES  ) ){
	
	$request['file'] = $_FILES['file'];
}

$autoload = __DIR__ . "/../vendor/autoload.php";
if( file_exists( __DIR__ . "/../vendor/autoload.php" ) ){

	include_once( $autoload );
	
	$classAjaxName  = $request['module'];
	$classMethod	= $request['action'];


	if( class_exists( "Source\Models\\" . $classAjaxName ) ){

		$namespace = "Source\Models\\" . $classAjaxName;

		$classAjax = new $namespace();
	
		if( $classAjax->response['response_status']['status'] == 1 ){
			
			if( method_exists( $classAjax, $classMethod) ){
				
				$response = $classAjax->$classMethod( $request );
				
				
			}
			else{
				$response['response_status']['status']     = 0;
				$response['response_status']['error_code'] = $error_code . __LINE__;
				$response['response_status']['msg']        = 'Não foi possível determinar a ação para sua solicitação. Classe ' . $classAjax . 'e método ' . $classMethod;
			}
		}
		else{
			$response['response_status']['status']     = 0;
			$response['response_status']['error_code'] = $error_code . __LINE__;
			$response['response_status']['msg']        = $classAjax->response['response_status']['error_code'] . '::' . $classAjax->response['response_status']['msg'];
		}
	}
	else{
		$response['response_status']['status']     = 0;
		$response['response_status']['error_code'] = $error_code . __LINE__;
		$response['response_status']['msg']        = 'Não foi possível determinar a ação para sua solicitação. ' . $classAjaxName . 'e método ' . $classMethod;
	}
}
else{
	$response['response_status']['status']     = 0;
	$response['response_status']['error_code'] = $error_code . __LINE__;
	$response['response_status']['msg']        = 'Não foi possível carregar as funcionalidades para execução da solicitação.';
}

// Preparando a resposta
header('Content-type: application/json;');
header('Cache-Control: no-cache;');

if( isset( $response['response_status']['status'] ) ){
	$responseJson = json_encode( $response );
}
else{
	$responseJson = '
	{ "response_status": 
		{ 
			"status": "0", 
			"error_code": "' . $error_code . __LINE__ . '", 
			"msg": "O sistema não gerou uma resposta para sua solicitação." 
		} 
	}';
}

print $responseJson;

?>