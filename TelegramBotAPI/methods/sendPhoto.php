<?php
namespace TelegramBotAPI\methods;

trait sendPhoto {
	public function sendPhoto( $photo_url, $chat_id = null, $msg_id = null ){
		if ( is_null($chat_id) && ! empty( $this -> chat_id ) ){
            $chat_id = $this -> chat_id;
        }
		if ( is_null($msg_id) && ! empty( $this -> msg_id ) ) {
            $msg_id = $this -> msg_id;
        }

        $data = [
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'photo' => $photo_url,
        ];

        if( ! is_null( $msg_id ) ){
            $data['reply_to_message_id'] = $msg_id;
            $data['allow_sending_without_reply'] = true;
        }
        
        $result = $this -> rest( 'sendPhoto', $data );
        $this -> log( 'sent-file', json_encode( $data ));
        $this -> log( 'sent-file', 'message_id: '. $msg_id );
        $this -> log( 'sent-file', 'Result: '. json_encode($result) );
        return $result;
    }
}
