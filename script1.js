/*  From: Inherited from - http://www.stoimen.com/blog/2009/07/16/jquery-browser-and-os-detection-plugin/
 */
(function() {
  var BrowserDetect = {
    init: function () {
      this.browser = this.searchString(this.dataBrowser) || null;
      this.version = this.searchVersion(navigator.userAgent)
        || this.searchVersion(navigator.appVersion)
        || null;
      this.OS = this.searchString(this.dataOS) || null;
      this.OSVersion = this.searchVersion(navigator.userAgent)
        || this.searchVersion(navigator.appVersion)
        || null;
      this.OSFriendlyName = this.getUserFriendlyOSName(this.OS, this.OSVersion);
    },
    getUserFriendlyOSName : function(osName, osVersion) {
      //Support for Windows
      if(osName == "Windows" && osVersion != null){
        switch(osVersion.toString()){
          case "6.3": return "Windows 8.1";
          case "6.2": return "Windows 8";
          case "6.1": return "Windows 7";
          case "6": case "6.0": return "Windows Vista";
          case "5.2":
          case "5.1":
            return "Windows XP"; //"Windows Server 2003";
          case "5": case "5.0" : return "Windows 2000";
          default: return "Windows";
        }
      }

      if(osName == "Mac" && osVersion != null) {
        var ua = navigator.userAgent || navigator.appVersion;
        var versionString = osVersion + '[_.]';
        if (ua.match(versionString + '4')) {
            return "Mac Tiger";// + osVersion;
        } else if (ua.match(versionString + '5')) {
            return "Mac Leopard";// + osVersion;
        } else if (ua.match(versionString + '6')) {
            return "Mac Snow Leopard";// + osVersion;
        } else if (ua.match(versionString + '7')) {
            return "Mac Lion";// + osVersion;
        } else if (ua.match(versionString + '8')) {
            return "Mac Mountain Lion";// + osVersion;
        }
      }
      return osName + " " + osVersion;
    },
    searchString: function (data) {
      for (var i=0;i<data.length;i++)	{
        var dataString = data[i].string;
        var dataProp = data[i].prop;
        this.versionSearchString = data[i].versionSearch || data[i].identity;
        if (dataString) {
          if (dataString.indexOf(data[i].subString) != -1)
            return data[i].identity;
        }
        else if (dataProp)
          return data[i].identity;
      }
    },
    searchVersion: function (dataString) {
      //Handling of compatability mode for IE10, IE9 & IE8
      if(this.versionSearchString == "MSIE"){
        var trident = "Trident";
        var tridentIndex = dataString.indexOf(trident);
        if (tridentIndex != -1) {
         var tridentVersion = parseFloat(dataString.substring(tridentIndex+trident.length+1));
         // IE 11 - Trident/7.0
         // IE 10 - Trident/6.0
         // IE 9 - Trident/5.0
         // IE 8 - Trident/4.0
         return tridentVersion + 4;
        }
      }
      var index = dataString.indexOf(this.versionSearchString);
      if (index == -1) return;
      return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
    },
    dataBrowser: [
      {
        string: navigator.userAgent,
        subString: "Chrome",
        identity: "Chrome"
      },
      { 	string: navigator.userAgent,
        subString: "OmniWeb",
        versionSearch: "OmniWeb/",
        identity: "OmniWeb"
      },
      {
        string: navigator.vendor,
        subString: "Apple",
        identity: "Safari",
        versionSearch: "Version"
      },
      {
        prop: window.opera,
        identity: "Opera"
      },
      {
        string: navigator.vendor,
        subString: "iCab",
        identity: "iCab"
      },
      {
        string: navigator.vendor,
        subString: "KDE",
        identity: "Konqueror"
      },
      {
        string: navigator.userAgent,
        subString: "Firefox",
        identity: "Firefox"
      },
      {
        string: navigator.vendor,
        subString: "Camino",
        identity: "Camino"
      },
      {		// for newer Netscapes (6+)
        string: navigator.userAgent,
        subString: "Netscape",
        identity: "Netscape"
      },
      {
        string: navigator.userAgent,
        subString: "MSIE",
        identity: "Internet Explorer",
        versionSearch: "MSIE"
      },
      {
        string: navigator.userAgent,
        subString: "Trident",
        identity: "Internet Explorer",
        versionSearch: "MSIE"
      },
      {
        string: navigator.userAgent,
        subString: "Gecko",
        identity: "Mozilla",
        versionSearch: "rv"
      },
      { 		// for older Netscapes (4-)
        string: navigator.userAgent,
        subString: "Mozilla",
        identity: "Netscape",
        versionSearch: "Mozilla"
      }
    ],
    dataOS : [
      {
        string: navigator.platform,
        subString: "Win",
        identity: "Windows",
        versionSearch: "Windows NT"
      },
      {
        string: navigator.userAgent,
        subString: "iPhone",
        identity: "iPhone/iPod",
        versionSearch: "iPhone OS"
      },
      {
        string: navigator.platform,
        subString: "Mac",
        identity: "Mac",
        versionSearch: "Mac OS X"
      },
      {
        string: navigator.platform,
        subString: "Linux",
        identity: "Linux"
      }
    ]

  };

  BrowserDetect.init();
  window.$.client = { os : { name : BrowserDetect.OS, version : BrowserDetect.OSVersion, friendlyName : BrowserDetect.OSFriendlyName }, browser : { name : BrowserDetect.browser, version : BrowserDetect.version } };
})();