<?php
class Push extends Helper {
    var $pid;
    var $body;
    var $url;

    public function __construct(){ }

    public function sendMessage($pid,$body,$url = NULL, $negocio = null, $device = null){
        if ($negocio) {
            $appid = NONESIGNAL_APPID;
            $restapikey = NONESIGNAL_APIKEY;
        } else {
            $appid = ONESIGNAL_APPID;
            $restapikey = ONESIGNAL_APIKEY;
        }


        #PLAYER ID
        $pid = array($pid);
        $content = array("en" => $body);
        if($url!=NULL){
          if($device == 'ios'){
            $fields = array('app_id' => $appid,'include_player_ids' => $pid,'contents' => $content, 'data' => array("chat" => $url));
          }else if($device == 'android'){
            $fields = array('app_id' => $appid,'include_player_ids' => $pid,'contents' => $content,'url' => $url);
          }
        }else{
            $fields = array('app_id' => $appid,'include_player_ids' => $pid,'contents' => $content, 'data' => array("chat" => "open"));
        }
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$restapikey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
        file_put_contents('push.log', 'Send push to:'.$appid.' at: '.date('Y-m-d H:i:s').'msg: '.$content, FILE_APPEND);
        return $response;
    }
}
?>
