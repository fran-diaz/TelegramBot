<?php
namespace TelegramBotAPI;

class TelegramBot {
    use \Medoo\Medoo;
    use commands\help;
    use commands\info;
    use methods\new_user;
    use methods\sendMessage;

    private $raw_input;
    private $input;
    private $db;
    
    public function __construct(){
        
    }

    public function init( $mode ) {
        if( $mode === 'webhook' ) {
            $this -> db = new Medoo([
                'database_type' => 'mysql',
                'database_name' => DB,
                'server' => DBSERVER,
                'username' => DBUSER,
                'password' => DBPASS
            ]);

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
                $this -> sendMessage( $chat_id, "Comando info" );
                break;
            case 'help':
                //$this->commands->help->reply();
                $this -> sendMessage( $chat_id, "Comando help" );
                break;
            default:
                $this -> sendMessage( $chat_id, "Comando desconocido: " . $this -> input["message"]["text"] );
        }
    }

    private function rest( string $method, array $json ) {
        $ch = curl_init();
        $result = null;

        curl_setopt( $ch, CURLOPT_URL, API_URL . $method ); 
        try {
            $data_string = json_encode( $json );
            curl_setopt( $ch, CURLOPT_HEADER, false );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_string );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            
            curl_setopt( $ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen( $data_string ) 
            ]);

            $result = json_decode( curl_exec( $ch ), true );
            /*if( $result['ok'] !== TRUE ) {
                $result = null;
            }*/
        } catch(Exception $e) {
            $this -> log( 'curl-error', $e -> getMessage(),  );
        }

        curl_close($ch);
        return $result;
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

