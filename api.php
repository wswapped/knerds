<?php
// header("Content-Type: application/json");
# replace with your client information: developer.whereismytransport.com/clients
$client_id="0686037c-5c83-4905-ae09-1f396abe2fba";
$client_secret="UnXYCsYrki/AE/Y0RMiOKtnkB20rrcwLHsJGkXr6uu4=";

//caching the token
//we keeping token into a file
$file = fopen('token.txt', 'rw+');
$token_file = fread($file, filesize('token.txt'));
$old_token = json_decode($token_file, true);
$saved_time = $old_token['time'];

$interval = time() - $saved_time;

if($interval>3500){
   //generate new token
   $token = generateToken();

   $file = fopen('token.txt', "w+");
   fwrite($file, json_encode(array('token'=>$token, 'time'=>time())));
}else{
   $token = $old_token['token'];
}

function  getStops(){
   //getting stops
   $get_data = callAPI('GET', 'https://platform.whereismytransport.com/api/stops?agencies=uCp9CGEAika36aipAPakUQ', false);
   $response = json_decode($get_data, true);
   return $response;
}

function callAPI($method, $url, $data){
   $curl = curl_init();
   global $token;
   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                         
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }
   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer $token",
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure ".curl_error($curl));}
   curl_close($curl);
   return $result;
}
function generateToken(){
   global $client_id, $client_secret;
   $request_vars = array("client_id"=>$client_id,
    "client_secret"=>$client_secret,
    "grant_type"=>"client_credentials",
    "scope"=>"transportapi:all");
      $ch = curl_init();
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $request_vars);
   curl_setopt($ch, CURLOPT_URL, 'https://identity.whereismytransport.com/connect/token');

   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $token_object = json_decode(curl_exec($ch), true);
   $token = $token_object['access_token'];
   return $token;
}