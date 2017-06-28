<?php
  $apikey = 'myapp';
 //$nexus_url = 'https://sfgiants.demo.firebet.dev.support.com/nexus/api/auth/app/myapp';

  $data = array(
            'algorithm' => 'HMACSHA256',
            'context' => array(
              'user' => array(
                //'id' => "testId1001",
                'email' =>"agent1021@support.com",
                'first_name' => "James",
                'last_name' => "Bond",
                'phone' => "6505568951",
              ),
              'environment' => array(
                'parameters' => array(
                  //'sessionId' => "10328",
                  'referenceId' => "123",
                  'referenceNumber' => "somenumberforexternalid",
                  'contactId' => "1428",
                  'customFields' => array(
                    'origin' => "email",
                    'zipcode' => "94321",
                    'insurancecode' => 'dsdasdsa',
                    'model' => 'iPhone6',
                    'make' => 'Apple',
                    'carrier' => 'ATT',
                  ),
                ),
              ),
            ),
  //echo var_export($data, true)."\n";
  $jsdata = json_encode($data);
  //echo $jsdata."\n";
  $base64data = base64_encode($jsdata);
  //echo 'jsdata:'.$jsdata.';base64dataesessionExtension'.$base64data."\n";
  $binaryHash = hash_hmac("sha256", $base64data, $apikey, true);
  $sign = base64_encode($binaryHash);
  //echo 'sign:'.$sign."\n";

  $payload = $sign.'.'.$base64data;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>My App</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.1.1/css/bootstrap.min.css"/>
<style>
.json {
  width: auto;
  min-width: 500px;
}
.json pre {
  padding: 5px;
  font-family: Consolas,Menlo,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New,monospace,serif;
  background: #eee;
  line-height: 19px;
}
</style>
  </head>
  <body>
    <div class="container">
      <h1></h1>
      <hr/>
      <div class="page">
         <div class="json"><pre/></div>
      </div>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore-min.js"></script>
    <form id="nexus_deliver_init_form" name="nexus_deliver_init_form" style="display:none" action="<?=$nexus_url ?>" target="_blank" method="POST">
      <input type="hidden" name="signed_request" value="<?=$payload ?>"/>
      <input type="submit" post="post"/>
    </form>

<script type="text/javascript">
$('#nexusbtn').off('click').on('click', function() {
  jQuery("#nexus_deliver_init_form").submit();
});
var o = <?=$jsdata?>;
$('.json pre').html(JSON.stringify(o, undefined, 2));
</script>

  </body>
</html>