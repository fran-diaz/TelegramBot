<?php
namespace TelegramBotAPI\methods;

trait sendMessage {
	public function sendMessage( $text, $chat_id = null, $msg_id = null ){
		$chat_id = ( ! empty( $this -> chat_id ) ) ? $this -> chat_id : null;
		$chat_id = ( ! empty( $this -> msg_id ) ) ? $this -> msg_id : null;

        $data = [
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => $text,
        ];

        if( ! is_null( $msg_id ) ){
            $data['reply_to_message_id'] = $msg_id;
            $data['allow_sending_without_reply'] = true;
        }
        
        $result = $this -> rest( 'sendMessage', $data );
        $this -> log( 'sent', json_encode( $data ));
        $this -> log( 'sent', 'message_id '. $msg_id );
        $this -> log( 'sent', $return );
        return $result;
    }
}
