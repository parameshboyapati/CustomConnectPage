<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Firebet Rest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS (load bootstrap from a CDN) -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <style>
        body    { padding-top:10px; }

        .json {

            width: auto;

            min-width: 500px;

        }

        .pre {

            padding: 5px;

            font-family: Consolas,Menlo,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New,monospace,serif;

            background:  #F0FFF0;

            line-height: 19px;

        }

        .navbar-default .navbar-brand {
            color: #06A11A;
        }

        iframe[seamless]{
            background-color: transparent;

            padding: 0px;
            overflow: hidden;
        }

    </style>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!--script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore-min.js"></script>
    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/components/core-min.js"></script>
    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/components/enc-utf16-min.js"></script>
    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/components/enc-base64-min.js"></script>
    <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/hmac-sha256.js"></script-->
	
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/core-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/enc-utf16-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/enc-base64-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/hmac-sha256.js"></script>

    <script language="JavaScript" src="/javascripts/browser_faster.js"></script>
    <script language="JavaScript" src="/javascripts/integration.js"></script>
    <script language="JavaScript" src="/javascripts/encoding.js"></script>
    <script type="text/javascript">

    // This code was written by Tyler Akins and has been placed in the
    // public domain.  It would be nice if you left this header intact.
    // Base64 code from Tyler Akins -- http://rumkin.com

    var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

    function encode64(input) {
        var output = new StringMaker();
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        while (i < input.length) {
            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output.append(keyStr.charAt(enc1) + keyStr.charAt(enc2) + keyStr.charAt(enc3) + keyStr.charAt(enc4));
        }
        console.log(output.toString());
        return output.toString();
    }

    function decode64(input) {
        var output = new StringMaker();
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {
            enc1 = keyStr.indexOf(input.charAt(i++));
            enc2 = keyStr.indexOf(input.charAt(i++));
            enc3 = keyStr.indexOf(input.charAt(i++));
            enc4 = keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output.append(String.fromCharCode(chr1));

            if (enc3 != 64) {
                output.append(String.fromCharCode(chr2));
            }
            if (enc4 != 64) {
                output.append(String.fromCharCode(chr3));
            }
        }

        return output.toString();
    }

     </script>

</head>
<body class="container">

<header>

    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">

            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <span class="glyphicon glyphicon glyphicon-off"></span>
                  Firebet Rest
                </a>
            </div>

            <ul class="nav navbar-nav">
                <li><a href="/">Home</a></li>
                <li><a href="/popoutIntegration.html">Nexus Popout Integration</a></li>

            </ul>

        </div>
    </nav>
</header>

<main>
    <div class="container">



    </div>

    <div class="container" >
        <div class="row " >
            <div class="row" >
                <div class="col-md-6" >

                    <div role="form" class="form-horizontal">
                        <div class="form-group">
                            <label for="tenanturl">Tenant URL:</label>
                            <input type="text" class="form-control" id="tenanturl">
                        </div>
                        <div class="form-group">
                            <label for="apikey">API Key:</label>
                            <input type="text" class="form-control" id="apikey">
                        </div>
                        <div class="form-group">
                            <label for="payload">Editable Payload:</label>
                            <textarea rows="20" class="form-control json pre " id="payload"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" onclick="sign()">Submit</button>
                    </div>
                </div>
                <div class="col-md-6" >
                    <div class="form-group">
                    <label for="displayopt">Display Nexus in:</label>
                    <select class="form-control" id="displayopt">
                        <option value="1">Inline Frame</option>
                        <option value="2">New Tab/Window</option>
                        <option value="3">full window</option>

                    </select>
                        </div>
                    <div class="form-group">
                        <label for="payloaddisp">Signed payload:</label>
                        <input type="textarea" readonly class="form-control" id="payloaddisp">



                </div>
                    <div class="form-group">
                        <label for="nexusholder">Nexus Container</label>
                    <iframe class="embed-responsive-item" id = "nexusholder" name = "nexusholder" width="550" height="400" seamless="seamless"></iframe>
                        </div>
            </div>
             </div>
            </div>

</div>


</main>

<footer>
    <p class="text-center text-muted">© Copyright 2015 Support.com Engineering</p>
</footer>
<script type="text/javascript">

   $('#nexusbtn').off('click').on('click', function() {

        jQuery("#nexus_deliver_init_form").submit();

    });


    var payloaddefault ={
  "algorithm": "HMACSHA256",
  "context": {
    "user": {
      "id": "",
      "email": "automation@support.com",
      "first_name": "fname",
      "last_name": "lname",
      "phone": "6505568951"
    },
    "environment": {
      "parameters": {
        "target": "",
        "sessionId": "",
        "referenceId": "123",
        "referenceNumber": "mynumber",
        "contactFirstName": "John",
        "contactLastName": "One",
        "contactEmail": "Customer11@111.com",
        "contactPhone": "1231231235",
        "contactOtherPhone": "",
        "contactMobile": "",
        "contactId": "",
        "customFields": {
          "origin": "email",
          "session_queue": "Sales",
          "zipcode": "94321",
          "insurancecode": "dsdasdsa",
          "model": "iPhone6",
          "make": "Apple",
          "carrier": "ATT"
        },
        "deviceComputer": {
          "name": "PC",
          "os": "Windows 7"
        },
        "deviceMobile": {},
        "assign": "True",
        "paths": {
          "search": [
            {
              "search_type": "category_uid",
              "search_values": [
                "52683262-8bef-4464-88fd-fc7b34dc490e",
                "96520d7f-a793-44e6-9dd9-1d13e50ff084"
              ]
            },
            {
              "search_type": "tag",
              "search_values": []
            },
			 {
              "search_type": "full_text",
              "search_values": []
            },
            {
              "search_type": "path_uid",
              "search_values": [
                "5c864d4b-51bf-40ed-9fc9-15bd516e5689",
                "ca2cd037-d48b-4996-b993-24b17fed63e2",
                "67e64798-dd62-4272-aca9-ce4c1c430c88"
              ]
            }
          ],
          "remote": true,
          "allPaths": true
		  },
          "showSessionStatusChange": "",
          "showAssignToMeButton": "",
          "showSessionTransferButton": "",
          "user": {
            "locale": "en",
            "teams": [{"teamId":"","teamName":""}]
          }
        
      }
    }
  }
}

    $(document).ready(function() {
        document.getElementById("payload").value = JSON.stringify(payloaddefault, null,2);
        console.log(JSON.stringify(payloaddefault));

    })
    function sign(){
        var jsonData = $('textarea#payload').val();
        var apikey = $('#apikey').val();
        var tenanturl = $('#tenanturl').val();
       // alert(apikey);
       jsonData = JSON.stringify(JSON.parse(jsonData), null,-1);
        console.log(jsonData);
        var encodedString = encode64(jsonData);

        console.log(encodedString);
        var hash = CryptoJS.HmacSHA256(encodedString, apikey);

        var base64 = hash.toString(CryptoJS.enc.Base64)




        var payload = base64+'.'+encodedString
        console.log(payload);
        $('#payloaddisp').val(payload);
        var nexusdisplay =  $('#displayopt').val();
       // var nexusdisplay = e.options[e.selectedIndex].value;
        var target;
        switch (nexusdisplay) {

            case '1':
                target =  "nexusholder";
                console.log("selected 1");
               // $('nexusholder').removeAttr('seamless')
                break;
            case '2':
                target =  "_blank";
                console.log("selected 2");
               // $('nexusholder').attr('seamless','seamless')
                break;
            case '3':
                target =  "_top";
             //   $('nexusholder').attr('seamless','seamless')
                break;

        }

//
       post(tenanturl,payload,target); }

    function post(path, payload,target, method) {
        method = method || "POST"; // Set method to post by default if not specified.

        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("id", "nexus_deliver_init_form");
        form.setAttribute("name", "nexus_deliver_init_form");
        form.setAttribute("style", "display:none");
        form.setAttribute("target", target);


        form.setAttribute("action", path);

        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "signed_request");
        hiddenField.setAttribute("value", payload);
        form.appendChild(hiddenField);


        document.body.appendChild(form);
        form.submit();
    }



</script>
</body>
</html>