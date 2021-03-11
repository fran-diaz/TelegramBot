<?php
namespace TelegramBotAPI\commands;

trait info {
    public function info( $args = 1 ){

        /*if(strpos($args, 'd') !== false){
            $aux = explode('d',$args);
            $dices = (intval($aux[0]) >= 1)?intval($aux[0]):1;
            $sides = (intval($aux[1]) >= 1)?intval($aux[1]):6;
        }else{
            $dices = (intval($args) >= 1)?intval($args):1;
            $sides = 6;
        }

        $aux_reply = '';
        for ($i = 0; $i < $dices; $i++) {
            $aux_reply .= rand(1, $sides) . ', ';
        }
        $reply = '@'. $this->container->response["message"]['from']['first_name'].' '.substr($aux_reply,0,-2);*/
        $reply = 'info';
        
        $this -> sendMessage( $this -> input['message']['chat']['id'], $reply, $this -> input['message']['message_id'] );
    }
}
