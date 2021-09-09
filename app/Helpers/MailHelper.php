<?php
namespace App\Helpers;

use TokenHelper, Carbon;
use App\Models\Token;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;
 
class MailHelper {
    // create new token and then send to email
    public static function send_token_to_user($user,$token_type,$data_email){
        // generate token
        $new_token = TokenHelper::generate_token($token_type);

        // if user have previous token
        $previous_token = Token::where('token_type', $token_type)->where('token_status', 'Y')->where('used_at', null)->where('user_id', $user['id'])->first();
        if ($previous_token) {
            $previous_token->token_status = 'N';
            $previous_token->save();
        }

        // add token to database
        $expired_at = Carbon::now()->addMinutes(60);
        $token = new Token;
        $token->token = $new_token;
        $token->token_type = $token_type;
        $token->user_id = $user->id;
        $token->expired_at = $expired_at;
        $token->save();

        // send token to user email
        $data = [
            'subject' => $data_email['subject'],
            'user' => $user,
            'token' => $token,
            'markdown' => $data_email['markdown'],
        ];
        Mail::to($user->user_email)->send(new UserMail($data));
    }
}