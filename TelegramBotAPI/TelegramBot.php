<?php
namespace TelegramBotAPI;

class TelegramBot {
    use commands\help;
    use commands\info;
    use methods\new_user;
    use methods\sendMessage;
    use methods\sendDocument;

    private $raw_input;
    private $input;
    private $db;
    private $chat_id = null;
    private $msg_id = null;
    
    public function __construct(){
        
    }

    public function init( $mode = null ) {
        if( $mode === 'webhook' ) {
            $this -> db = new \Medoo\Medoo([
                'database_type' => 'mysql',
                'database_name' => DB,
                'server' => DBSERVER,
                'username' => DBUSER,
                'password' => DBPASS
            ]);

            $aux = $this -> db -> select( 'clients_data','*',["origin" => DOMAIN]);
            if($aux){
                $client_data = array();
                $client_data['database_type'] = $aux[0]['db_type'];
                $client_data['server'] = $aux[0]['server'];
                $client_data['username'] = $aux[0]['user'];
                $client_data['password'] = $aux[0]['pass'];
                $client_data['database_name'] = $aux[0]['db'];
                $client_data['port'] = $aux[0]['port'];
                $client_data['appname'] = 'ITE';
                $client_data['prefix'] = $aux[0]['table_prefix'];
                $this -> db = new \Medoo\Medoo( $client_data );

                $aux = $this -> db -> get( 'system__connections', '*', ['system__connections_id' => '1' ]);
                $client_data['username'] = $aux['username'];
                $client_data['password'] = $aux['password'];
                $client_data['database_name'] = $aux['database_name'];
                $this -> db = new \Medoo\Medoo( $client_data );
            }

            $this -> parse_input();
        }
    }

    private function parse_input(){
        $this -> raw_input = file_get_contents( 'php://input' );
        $this -> input = json_decode( $this -> raw_input, true );
        $this -> log( 'request', $this -> raw_input );

        if( isset( $this -> input["message"] ) ){
            $this -> chat_id = $this -> input["message"]["chat"]["id"];
            $this -> msg_id = $this -> input["message"]["message_id"];
            $command = explode( ' ', substr($this -> input["message"]["text"], 1 ) );
            
            $this -> new_user();

            switch ( $command[0] ) {
                case 'info':
                    $this -> info();
                    break;
                case 'help':
                    $this -> help();
                    break;
                default:
                    $this -> sendMessage("Comando desconocido: " . $this -> input["message"]["text"] );
            }
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

