<?php
  $apikey = 'myapp';
 //$nexus_url = 'https://sfgiants.demo.firebet.dev.support.com/nexus/api/auth/app/myapp'; $nexus_url = 'https://sfgiants.rwcqa.firebet.dev.support.com/nexus/api/auth/app/myapp'; //$nexus_url = 'https://sfgiants.stage.nexus.support.com/nexus/api/auth/app/myapp'; //$nexus_url = 'https://sfgiants.patch.firebet.dev.support.com/nexus/api/auth/app/nexus';

  $data = array(
            'algorithm' => 'HMACSHA256',
            'context' => array(			  'source' => 'ninjato',
              'user' => array(
                //'id' => "testId1001",
                'email' =>"agent1021@support.com",
                'first_name' => "James",
                'last_name' => "Bond",
                'phone' => "6505568951",				
              ),
              'environment' => array(
                'parameters' => array(                //'target' => "seesupport", //seesupport, embedded
                  //'sessionId' => "10328",
                  'referenceId' => "123",
                  'referenceNumber' => "somenumberforexternalid",				  'contactEmail' => "shane.watson@mail.com",				  'contactFirstName' => "John",				  'contactLastName' => "One",				    'contactPhone' => "444456454555",				  'contactMobile' => "6506506502",				  'contactOtherPhone' => "",
                  'contactId' => "1428",
                  'customFields' => array(
                    'origin' => "email",					'session_queue' => "Sales",
                    'zipcode' => "94321",
                    'insurancecode' => 'dsdasdsa',
                    'model' => 'iPhone6',
                    'make' => 'Apple',
                    'carrier' => 'ATT',
                  ),				  'deviceComputer' => array(                    'name' => 'PC/Mac',					'os' => 'Windows 7',					'os_variant' => 'Professional',					'os_arch' => '64-bit',					'os_version' => '6.1.7601',					'os_lang' => '1033',					'os_sp_minor' => '45',					'os_sp_major' => '1',					'host' => 'MY-PC-3500',					'model' => 'Vostro 3500',					'serial' => 'ABCWXYZ',					'vendor' => 'Dell Inc',					'memory' => '8135684096',					'owner' => 'MyName',					'swap_space' => '1024',					'av_prods' => array(						array(						'company' => 'Norton',						'latest' => true,						'name'=> 'Symantec Endpoint Protection',						'version' => '10.234'						)					)                  ),				//'deviceMobile' => array(				//	'name' => 'iOS',				//	'os' => '9.1',				//	'serial' => 'a890ghijk345678',				//	'serial2' => 'TA9012LMXZ',				//	'os_sdk' => '19',				//	'os_build' => '19, KTU84P',				//	'os_lang' => 'English',				//	'model' => 'XT1080',				//	'manufacturer' => 'Motorola',				//	'brand' => 'motorola',				//	'cpu' => 'QuadCore',				//	'cpu_arch' => 'armv7l',				//	'memory' => '1.76 GB',                //  ),				  'assign' => "false",				  'paths' => array(				  'search' => array(						//array(						//'search_type' => 'full_text', //category_uid, tag, and/or path_uid						//'search_values' => array(						//	'image' //Category UID						//'fe7fa73a-b9ef-eb2f-59a6-437938d884a8' //Path UID						//),						//),					//	array(					//	'search_type' => 'full_text', //full_text', //category_uid, tag, and/or path_uid					//	'search_values' => array(						//	'galaxy',					//		'Acme Bluetooth Speakers - No Sound',						//	'andromeda'					//	),					//	),						//array(						//'search_type' => 'path_uid', //category_uid, tag, and/or path_uid						//'search_values' => array(						//'eecc6905-b1a3-4cef-9c9d-33ea1ba18e41'						//),						//)						),                  'remote' => true,                  'allPaths' => true                  ),				  'showSessionStatusChange' => false,				  'showAssignToMeButton' => true,				  'showSessionTransferButton' => false,				  'user'=> array (					'locale' =>  "en",//[Optional locale used to derive language for content. Ex: en-US or en]",								'teams' =>  array( //[Optional Array of user's teams. These are created (if missing) and assigned to user. ex: [{\"teamId\":\"teamA-external-Id\",\"teamName\":\"teamA\"},{\"teamId\":\"teamB-external-Id\",\"teamName\":\"teamB\"}...]]"						array(						"teamId" => "32525108",						"teamName" => "Team USA"						),						array(						"teamId" => "29491127",						"teamName" => "Support"						)						)						)
                ),
              ),
            ),			          );
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
      <hr/>		<button id="nexusbtn">Nexus Session</button>
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
