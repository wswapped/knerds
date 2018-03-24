<?php
function callAPI($method, $url, $data){
   $curl = curl_init();
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
      'Authorization: Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6IkVBOUE2OTYzRjIyNUZFQjcwRDZGN0U2ODdCOTUzNTE3M0RDNjA0QTgiLCJ0eXAiOiJKV1QiLCJ4NXQiOiI2cHBwWV9JbF9yY05iMzVvZTVVMUZ6M0dCS2cifQ.eyJuYmYiOjE1MjE4ODg0ODksImV4cCI6MTUyMTg5MjA4OSwiaXNzIjoiaHR0cHM6Ly9pZGVudGl0eS53aGVyZWlzbXl0cmFuc3BvcnQuY29tIiwiYXVkIjoiaHR0cHM6Ly9pZGVudGl0eS53aGVyZWlzbXl0cmFuc3BvcnQuY29tL3Jlc291cmNlcyIsImNsaWVudF9pZCI6IjhlNDExNDQwLTA1NDgtNDllZC1hYjA4LWQ4MjU0NmE2ZmE3YiIsImNsaWVudF90ZW5hbnQiOiIyZmJjZTQzYS1lODQyLTQ3OTMtOWQ3ZS0xOTJkZTVmOTM0ODkiLCJqdGkiOiJhNzkyODM3NDI1OTY5NWQ5OWIzYzM4MjdjOTUxOGNlZCIsInNjb3BlIjpbInRyYW5zcG9ydGFwaTphbGwiXX0.WAf362vgUEsssEhYW3Nf6h6XO-fkeSFp525_7q6j9QooAe-o1vATPBkizqla7TcLHdFCCRXNdWlUBemr0VR0GbvoRNz0yEDf1RpViE37ep0wbV7zRxpGI79qKheIT-smNyWUUkwWrfMH8-82qDz5eh_w7ABVAxNKY3508g3Z99EuYLOKV-D0bJhMrzUXbbqHRbTIjMtvzCIII1LLqv4lkmFRj79qVTA5rDUqAuPdbRePAUGM14WNXVp3vv59Q43HA8Vz4VQvVFrL9WNT1PkY5qvgvhX9RkPp3nY4HvXYJsSlFy_bUIcDS6MsnW3MM4cRf1-cmgeE2pJ2isgrb1uXRA',
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

$get_data = callAPI('GET', 'https://platform.whereismytransport.com/api/stops?agencies=uCp9CGEAika36aipAPakUQ', false);
$response = json_decode($get_data, true);
print_r ($response);