<?php
namespace TelegramBotAPI\commands;

use TelegramBotAPI\command;

/**
 * Description of roll
 *
 * @author Fran Díaz <fran.diaz.gonzalez@gmail.com>
 */
class skills extends command{
    private $container;
    
    public function __construct(\TelegramBotAPI\TelegramBot $instance) {
        $this->container = $instance;
    }
    
    public function reply($args = false){
        global $_ITE;
        
        if($args !== false){
            if($args == 'all' || $args == 'todos'){
                $user_id = '';
                $aux = $_ITE->bdd->select('rol_users','','',false,false);
                foreach($aux as $user){
                    $user_id .= $user['rol_users_id'].',';
                }
                $user_id = substr($user_id, 0, -1);
                $aux_reply_msg = "Estas son las <strong>habilidades</strong> de <em>todos</em>:\n";
            }else{
                $aux = $_ITE->bdd->select('rol_users',"first_name = '$args'",'user_id ASC LIMIT 1');
                $user_id = $aux[0]['rol_users_id'];
                $aux_reply_msg = "Estas son las <strong>habilidades</strong> de <em>".$aux[0]['first_name']."</em>:\n";
            }
        }else{
            $user_id = $_ITE->bdd->select('rol_users',"user_id = '".$this->container->response["message"]["from"]["id"]."'")[0]['rol_users_id'];
            $aux_reply_msg = "Estas son tus <strong>habilidades</strong>:\n";
        }

        $aux_reply = $aux_reply_msg."\n<pre>";
        $aux_user = '';
        $aux_skills = $_ITE->bdd->select('rol_skills',"rol_users_id IN ($user_id)","rol_users_id ASC, skill ASC",false,false);
        if(!isset($aux_skills[0]['skill'])){
            $this->container->reply($this->container->response["message"]["chat"]["id"],'No se han encontrado habilidades.');
        }else{
            if($args == 'all' || $args == 'todos'){
                foreach($aux_skills as $num => $skill){
                    if($aux_user !== $skill['rol_users_id']){
                        $aux = $_ITE->bdd->select('rol_users',"rol_users_id = '$skill[rol_users_id]'",'user_id ASC LIMIT 1');
                        $aux_reply .= ($num !== 0)?"\n\n".'@'.$aux[0]['first_name'].":\n":'@'.$aux[0]['first_name'].":\n";
                        $aux_user = $skill['rol_users_id'];
                    }
                    $aux_reply .= ' - '.$skill['skill'].': '.$skill['value']."\n";
                }
            }else{
                foreach($aux_skills as $skill){
                    $aux_reply .= '- '.$skill['skill'].': '.$skill['value']."\n";
                }
            }

            $reply = $aux_reply.'</pre>';

            $this->container->reply($this->container->response["message"]["chat"]["id"],$reply);
        }
    }
}
