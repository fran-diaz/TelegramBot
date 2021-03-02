<?php
namespace TelegramBotAPI\commands;

use TelegramBotAPI\command;

/**
 * Description of roll
 *
 * @author Fran Díaz <fran.diaz.gonzalez@gmail.com>
 */
class help extends command{
    private $container;
    
    public function __construct(\TelegramBotAPI\TelegramBot $instance) {
        $this->container = $instance;
    }
    
    public function reply($args = 1){
        $reply = "";
        $reply .= "Soy el <strong>Maestro de Juego</strong>, puedo ayudarte en tu partida de rol realizando ciertas acciones y proporcionandote información adicional.\n\n";
        $reply .= "Puedes controlarme empleando los siguientes comandos:\n\n";
        $reply .= "/roll (o /dado) - Devuelve <strong>1 tirada</strong> de un dado de <strong>6 caras</strong>\n";
        $reply .= "/roll X - Devuelve <strong>X tiradas</strong> de un dado de <strong>6 caras</strong>\n";
        $reply .= "/roll XdY - Devuelve <strong>X tiradas</strong> de un dados de <strong>Y caras</strong>\n";
        $reply .= "/skills (o /habilidades) - Devuelve tu listado de <strong>habilidades</strong>\n";
        $reply .= "/skills X - Devuelve el listado de <strong>habilidades</strong> del usuario X\n";
        $reply .= "/skills all (o todos) - Devuelve las <strong>habilidades</strong> de todos los usuarios\n";
        $reply .= "";
        
        $this->container->reply($this->container->response["message"]["chat"]["id"],$reply);
    }
}
