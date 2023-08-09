<?php

  // Declare the security credentials to use
  $username = "my_username";
  $password = "SecrEt12345";

  // Set the attributes of the message to send
  $message  = "Hello World";
  $type     = "1-way";
  $senderid = "XYZCorp";
  $to       = "61400000000";

  // Build the URL to send the message to. Make sure the 
  // message text and Sender ID are URL encoded. You can
  // use HTTP or HTTPS
  $url = "http://api.directsms.com.au/s3/http/send_message?" .
         "username=" . $username . "&" .
         "password=" . $password . "&" .
         "message="  . urlencode($message) . "&" .
         "type="     . $type . "&" .
         "senderid=" . urlencode($senderid) . "&" .
         "to="       . $to;

  // Send the request
  $output = file($url);

  // The response from the gateway is going to look like 
  // this:
  // id: a4c5ad77ad6faf5aa55f66a
  // 
  // In the event of an error, it will look like this:
  // err: invalid login credentials
  $result = explode(":", $output[0]);

  if($result[0] == "id") 
  {
    echo("Message sent\n");
  }
  else
  {
    echo("Error - " . $result[1] . "\n");
  }

?>
