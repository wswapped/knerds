<?php
// header("Content-Type: application/json");
# replace with your client information: developer.whereismytransport.com/clients
$client_id="8e411440-0548-49ed-ab08-d82546a6fa7b";
$client_secret="10SMVl6YGIYohIcJmUkukabN25VutFCTsY80mX4GFD4=";

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

// RESPONSE=$(curl\
//     -H "Accept: application/json"\
//     -d "client_id=$client_id"\
//     -d "client_secret=$client_secret"\
//     -d "grant_type=client_credentials"\
//     -d "scope=transportapi:all"\
//     https://identity.whereismytransport.com/connect/token)

// TOKEN=$(echo $RESPONSE | python -c "import sys, json; print json.load(sys.stdin)['access_token']")
// echo "Token: " $TOKEN

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
