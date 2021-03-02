<?php

function reply( $chat_id, $reply, $replytomsgid = false ){
	$sendto = API_URL . "sendmessage?chat_id=" . $chat_id . "&text=" . $reply . "&parse_mode=HTML";
	if($replytomsgid !== false){
        $sendto .= '&reply_to_message_id='.$replytomsgid;
    }
    file_get_contents($sendto);
}