<?php
require('config/standard.php');
require('config/functions.php');

$raw_response = file_get_contents('php://input');
$response = json_decode($raw_response, true);
$chatID = $response["message"]["chat"]["id"];
$reply = '';

if(DEBUG){
    file_put_contents('response.txt', print_r($response, true));
}

$aux = explode( ' ', substr( $response["message"]["text"], 1 ) );

switch ( $aux[0] ) {
	case 'dado':
    case 'roll':
        $tiradas_dados = $aux;
        array_shift($tiradas_dados);

        if( count( $tiradas_dados) >= 1 ) {
	        foreach( $tiradas_dados as $tirada ) {
	            if( isset( $tirada ) && strpos( $tirada, 'd') !== false ){
	                $aux2 = explode( 'd', $tirada );
	                $dados = ( intval($aux2[0]) >= 1)?intval($aux2[0]):1;
	                $caras = ( intval($aux2[1]) >= 1)?intval($aux2[1]):6;
	            }

	            $aux_reply = "\xF0\x9F\x8E\xB2".' <strong>'.$tirada.'</strong>: ';
	            for ($i = 0; $i < $dados; $i++) {
	                $aux_reply .= rand( 1, $caras ) . ', ';
	            }
	            $reply = '@'. $response["message"]['from']['first_name'].' '.substr( $aux_reply, 0, -2) ;

	            reply( $chatID, $reply );

	        }
	    } else {
	    	$dados = 1;
            $caras = 6;

            $aux_reply = "\xF0\x9F\x8E\xB2".' <strong>1d6</strong>: ';
            $aux_reply .= rand( 1, $caras );
            $reply = '@'. $response["message"]['from']['first_name'].' '.$aux_reply;

	        reply( $chatID, $reply, $response["message"]['message_id'] );
	    }

        break;
    case 'ayuda':
    case 'help':
    	require ('Medoo.php');
    	$db = new Medoo\Medoo( $Medoo_config );

    	if( ! $db -> has( 'users', [ 'user_id' => $response["message"]['from']['id'] ] ) ){
    		$db -> insert( 'users', ['user_id' => $response["message"]['from']['id'], 'user' => $response["message"]['from']['first_name']] );
    	}

     	$reply = "";
        $reply .= "Soy el <strong>Maestro de Juego</strong>, puedo ayudarte en tu partida de rol realizando ciertas acciones y proporcionandote información adicional.%0A%0A";
        $reply .= "Puedes controlarme empleando los siguientes comandos:%0A%0A";
        $reply .= "/roll (o /dado) - Devuelve <strong>1 tirada</strong> de un dado de <strong>6 caras</strong>%0A";
        $reply .= "/roll XdY - Devuelve <strong>X tiradas</strong> de un dados de <strong>Y caras</strong>%0A";
        $reply .= "/roll XdY XdY ... - Devuelve <strong>X tiradas</strong> de un dado de <strong>Y caras</strong> sucesivamente%0A";
        $reply .= "/help (o /ayuda) - Devuelve esta información de ayuda%0A";
        $reply .= "";   

        reply( $chatID, $reply, $response["message"]['message_id'] );

        break;
    case 'msg':
    	require ('Medoo.php');
    	$db = new Medoo\Medoo( $Medoo_config );

    	$user_info = $db -> get( 'users', '*', ['user' => $aux[1]] );

    	if( $user_info) {
    		array_shift($aux);
    		array_shift($aux);

    		reply( $user_info['user_id'], implode(' ',$aux) );
    	} else {
    		reply( $chatID, 'Lo siento, no reconozco el usuario. Puede que el usuario no haya leido todavía la ayuda del Bot.', $response["message"]['message_id'] );
    	}
    	
    	break;
    default:
    	if( count( $aux ) >= 2 ){
    		$reply = 'Lo siento, no reconozco ese comando.';
    		reply( $chatID, $reply, $response["message"]['message_id'] );
    	}
}

if(DEBUG){
    file_put_contents('reply.txt', print_r($reply, true));
}


