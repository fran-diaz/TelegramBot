<?php
namespace TelegramBotAPI;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of command
 *
 * @author Fran Díaz <fran.diaz.gonzalez@gmail.com>
 */
class command {
    public $roll;
    public $help;
    public $skills;
    
    public function __construct(\TelegramBotAPI\TelegramBot $instance) {
        $this->roll = new \TelegramBotAPI\commands\roll($instance);
        $this->help = new \TelegramBotAPI\commands\help($instance);
        $this->skills = new \TelegramBotAPI\commands\skills($instance);
    }
}
