/* eslint no-alert: 0, no-empty: 0, no-fallthrough: 0, default-case: 0 */
var Base64 = {

// private property
    _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

// public method for encoding
    encode : function (input) {
        input = escape(input);
        var output = "";
        var chr1, chr2, chr3 = "";
        var enc1, enc2, enc3, enc4 = "";
        var i = 0;

        do {
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

            output = output +
                this._keyStr.charAt(enc1) +
                this._keyStr.charAt(enc2) +
                this._keyStr.charAt(enc3) +
                this._keyStr.charAt(enc4);
            chr1 = chr2 = chr3 = "";
            enc1 = enc2 = enc3 = enc4 = "";
        } while (i < input.length);

        return output;
    },

// public method for decoding
    decode : function (input) {
    var output = "";
    var chr1, chr2, chr3 = "";
    var enc1, enc2, enc3, enc4 = "";
    var i = 0;

    // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
    var base64test = /[^A-Za-z0-9\+\/\=]/g;
    if (base64test.exec(input)) {
        alert("There were invalid base64 characters in the input text.\n" +
            "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
            "Expect errors in decoding.");
    }
    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

    do {
        enc1 = this._keyStr.indexOf(input.charAt(i++));
        enc2 = this._keyStr.indexOf(input.charAt(i++));
        enc3 = this._keyStr.indexOf(input.charAt(i++));
        enc4 = this._keyStr.indexOf(input.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if (enc3 != 64) {
            output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
            output = output + String.fromCharCode(chr3);
        }

        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";

    } while (i < input.length);

    return unescape(output);
}
};

var _log = function log(name, level, args) {
    if (!window.console || !window.console.log) return;
    var stackTrace="", message="";
    for(var i = 0; i < args.length; i++){
        var arg = args[i];
        try {
            if (arg instanceof Error) {
                if (typeof(printStackTrace) != 'undefined') {
                    var trace = printStackTrace({e: arg});
                    stackTrace += "\nStackTrace:\n" + trace.join('\n');
                } else if (arg.stack) {
                    stackTrace += "\nStackTrace:\n" + arg.stack;
                }
            }
        } catch (e) {
        }
        message += " " + arg;
    }
    var msg = '['+name+']' + message + stackTrace;
    if (level in window.console) {
        window.console[level](msg);
    } else {
        window.console.log(msg);
    }
};

var logger =  function (name, level) {
    if(!name) name = "NexusConnect";
    this.debug = this.log = this.info = this.warn = this.error = function() {};
    switch (level) {
        case "debug":
            this.debug = this.log = function () {
                _log(name,'log',arguments);
            };
        case "info":
            this.info = function () {
                _log(name,'info',arguments);
            };
        case "warn":
            this.warn = function () {
                _log(name,'warn',arguments);
            };
        case "error":
            this.error = function () {
                _log(name,'error',arguments);
            };
    }
};

var NexusConnect = function(jwt,callback1, options) {

    this.options = options || {};
    this._logLevel = "info";
    this._logger = new logger("NexusConnect", this._logLevel);
    this._apptoken = jwt;
    if (!jwt) {
        this._logger.error("Unable to derive url -> Empty JWT");
    }

    this._tinyInstall = this.options.tiny === true;

    try {
        var decodedjwt;
        if (window.atob) {
            decodedjwt = atob(jwt.split(".")[1]);
        }
        else {
            decodedjwt = Base64.decode(jwt.split(".")[1]);
        }
        var jwtJson = JSON.parse(decodedjwt);
        this._serverUrl = "https://" + jwtJson.t + "." + jwtJson.d;
		console.log('data in nexus connect:'+jwtJson.t)
		return jwtJson;
    } catch (ex) {
        this._logger.error("Unable to derive url -> Got exception", ex);
        return false;
    }
};

// This is the function used to actually send the data
// It takes parameters, which is an object populated with key/value pairs.
var __sendData = function(data, url, callback) {
    var name,
        form = document.createElement("form"),
        node = document.createElement("input");
    form.action = url;

    for(name in data) {
        node.name  = name;
        node.value = data[name].toString();
        form.appendChild(node.cloneNode());
    }

    // To be sent, the form needs to be attached to the main document.
    form.style.display = "none";
    form.target = "nexusframe";
    form.method = "POST";
    document.body.appendChild(form);

    // Let's create the iFrame used to send our data
    this._iframe = document.createElement("iframe");
    this._iframe.name = "nexusframe";
    this._iframe.id = "nexusframe";
    this._iframe.style.display = "none";
    document.body.appendChild(this._iframe);

    // Here "addEventListener" is for standards-compliant web browsers and "attachEvent" is for IE Browsers.
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];

    // Now...
    // if
    //    "attachEvent", then we need to select "onmessage" as the event.
    // if
    //    "addEventListener", then we need to select "message" as the event

    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

    // Listen to message from child IFrame window
    eventer(messageEvent, function (e) {
        var error = JSON.parse(e.data);
        callback(error.code, error.data);
        //// remove this handler
        if (window.removeEventListener) {
            e.target.removeEventListener(e.type, arguments.callee);
        }
        else {
            window.detachEvent("onmessage" , arguments.callee);
        }
        // Do whatever you want to do with the data got from IFrame in Parent form.
    }, false);



    form.submit();

    // But once the form is sent, it's useless to keep it.
    document.body.removeChild(form);
};

NexusConnect.prototype.DownloadNexus = function(connectionCode, callback){
    var url = this._serverUrl + "/consumer/downloadNexusForPartners" + (this._tinyInstall ? "/?tiny=1" : "");
    var data = {id: connectionCode,
        auth_token: this._apptoken};
    __sendData(data, url, callback);

};
NexusConnect.prototype.DownloadNexus1 = function(serverUrl,apptok,connectionCode, callback){
    var url = serverUrl+ "/consumer/downloadNexusForPartners" + (this._tinyInstall ? "/?tiny=1" : "");
    var data = {id: connectionCode,
        auth_token: apptok};
    __sendData(data, url, callback);

};


