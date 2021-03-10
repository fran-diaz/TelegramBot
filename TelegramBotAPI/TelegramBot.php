<?php
namespace TelegramBotAPI;

/**
 * Description of TelegramBot
 *
 * @author Fran Díaz <fran.diaz.gonzalez@gmail.com>
 */

class TelegramBot {
    private static $instance;
    private $raw_response;
    public $response;
    public $commands;
    
    public function __construct(){
        
    }

    public function init( $mode ){
        if( $mode === 'webhook' ){
            $this -> parse_input();
        }
    }

    private function parse_input(){
        $this -> raw_input = file_get_contents( 'php://input' );
        $this -> input = json_decode( $this -> raw_input, true );
        $this -> log( 'request', $this -> raw_input );

        $chat_id = $this -> input["message"]["chat"]["id"];
        $command = explode( ' ', substr($this -> input["message"]["text"], 1 ) );
        switch ( $command[0] ) {
            case 'info':
                $this -> send_message( $chat_id, "Comando info" );
                break;
            case 'help':
                //$this->commands->help->reply();
                $this -> send_message( $chat_id, "Comando help" );
                break;
            default:
                $this -> send_message( $chat_id, "Comando desconocido" );
        }
    }

    private function rest( string $method, array $json ) {
        $ch = curl_init();
        $result = null;

        curl_setopt( $ch, CURLOPT_URL, API_URL . '/' . $method ); 
        try {
            $data_string = json_encode( $json );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_string );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen( $data_string ) 
            ]);

            $result = json_decode( curl_exec( $ch ), true );
            $this -> log( 'sent', $result );
            if( $result['ok'] !== TRUE ) {
                $result = null;
            }
        } catch(Exception $e) {
            $this -> log( 'curl-error', $e -> getMessage(),  );
        }

        curl_close($ch);
        return $result;
    }
    
    public function send_message( $chat_id, $text, $msg_id = false ){
        $data = [
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => $text,
        ];

        if( $msg_id !== false ){
            $data['reply_to_message_id'] = $msg_id;
        }
        $this -> log( 'sent', json_encode( $data ) );
        $result = $this -> rest( 'sendMessage', $data );
        $this -> log( 'sent', json_encode( $result ) );
        return $result;
    }

    public function newUser(){
        global $_ITE;
        
        $fields = [];
        $values = [];
        
        if(isset($this->response["message"]["from"]["id"])){
            $fields[] = 'user_id';
            $values[] = $this->response["message"]["from"]["id"];
        }
        
        if(isset($this->response["message"]["from"]["first_name"])){
            $fields[] = 'first_name';
            $values[] = $this->response["message"]["from"]["first_name"];
        }
        
        if(isset($this->response["message"]["from"]["username"])){
            $fields[] = 'username';
            $values[] = $this->response["message"]["from"]["username"];
        }
            
        $_ITE->bdd->insert('rol_users',$fields,$values);
    }

    private function log( string $file, string $msg ){
        $username = ( ! empty( $this -> input["message"]["from"]["first_name"] ) ) ? $this -> input["message"]["from"]["first_name"] : '';
        return file_put_contents( $file.'-log.txt', date( 'd-m-Y H:i:s' ) . ' - ' . $username . ' - ' . $msg ."\n", FILE_APPEND );
    }
    
    public function __destruct() {
        if( defined( 'DEBUG' ) && DEBUG === true ){
            //file_put_contents('temp-dev.txt', print_r($this->response, TRUE));
        }
    }
}

