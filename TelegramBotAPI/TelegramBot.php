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
        if(defined('DEBUG') && DEBUG === true){
            ini_set('display_errors',1);
        }

    }
    
    public static function singleton(){
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
            
            self::$instance->commands = \TelegramBotAPI\providers\commandsServiceProvider::init(self::$instance);
        }
        return self::$instance;
    }
    
    public function init(){
        global $_ITE;
        
        $this->raw_response = file_get_contents('php://input');
        $this->response = json_decode($this->raw_response, true);
        
        if(!isset($_ITE->bdd->select('rol_users',"user_id = '".$this->response["message"]["from"]["id"]."'")[0]['user_id'])){
            $this->newUser();
        }
        
        $aux = explode(' ', substr($this->response["message"]["text"], 1));
        if (count($aux) <= 2) {
            switch ($aux[0]) {
                case 'roll':
                    if(isset($aux[1])){
                        $this->commands->roll->reply($aux[1]);
                    }else{
                        $this->commands->roll->reply();
                    }
                    
                    break;
                case 'dado':
                    if(isset($aux[1])){
                        $this->commands->roll->reply($aux[1]);
                    }else{
                        $this->commands->roll->reply();
                    }
                case 'skills':
                    if(isset($aux[1])){
                        $this->commands->skills->reply($aux[1]);
                    }else{
                        $this->commands->skills->reply();
                    }
                    
                    break;
                case 'habilidades':
                    if(isset($aux[1])){
                        $this->commands->skills->reply($aux[1]);
                    }else{
                        $this->commands->skills->reply();
                    }
                case 'help':
                    $this->commands->help->reply();
                    
                    break;
                default:
                    $this->reply($this->response["message"]["chat"]["id"],"Hola Caracola v.2 (Fran aún no ha terminado esto... que tío...)");
            }
        }
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
    
    public function reply($chatid,$reply,$replytomsgid = false){
        file_put_contents('temp-dev.txt', print_r($this->response, TRUE));
        $sendto = API_URL . "sendmessage?parse_mode=HTML&chat_id=" . $chatid . "&text=" . urlencode($reply);
        if($replytomsgid !== false){
            $sendto .= '&reply_to_message_id='.$this->response["message"]["message_id"];
        }
        file_get_contents($sendto);
    }
    
    public function __destruct() {
        if(defined('DEBUG') && DEBUG === true){
            file_put_contents('temp-dev.txt', print_r($this->response, TRUE));
        }
    }
}
