<?php
namespace TelegramBotAPI\methods;

trait sendMessage {
	public function sendMessage( $chat_id, $text, $msg_id = false ){
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
        return $result;
    }
}
