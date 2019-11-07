//$x AJAX library

(function (global){
    var ajax = function(){
        //So I don't have to type new
        return new ajax.init();
    }

    ajax.prototype = {
        x: function () {
            if (typeof XMLHttpRequest !== 'undefined') {
                return new XMLHttpRequest();
            }
            var versions = [
                "MSXML2.XmlHttp.6.0",
                "MSXML2.XmlHttp.5.0",
                "MSXML2.XmlHttp.4.0",
                "MSXML2.XmlHttp.3.0",
                "MSXML2.XmlHttp.2.0",
                "Microsoft.XmlHttp"
            ];

            var xhr;
            for (var i = 0; i < versions.length; i++) {
                try {
                    xhr = new ActiveXObject(versions[i]);
                    break;
                } catch (e) {
                }
            }
            return xhr;
        },
        send: function (url, callback, method, data, async=true, json=false) {
          // console.log('sending');
            var x = this.x();
            x.open(method, url, async);
            x.timeout = 30000;
            x.onreadystatechange = function () {
              // console.log(x.readyState);
                if (x.readyState == 4 && x.status == 200) {
                  // console.log("JSON:"+json);
                    if (json){
                      try{
                        // console.log('yep');
                        // console.log(x.responseText);
                        // console.log(JSON.parse(x.responseText));
                        callback(JSON.parse(x.responseText));
                      }
                      catch(e){var obj = {error: e, responseText:x.responseText}; callback(obj)}
                    } else { callback(x.responseText)}
                }
            };
            x.ontimeout = function(e){
              console.log('AJAX TIMED OUT');
            }
            // console.log(method);
            if (method == 'POST') {
                x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            }
            x.send(data)
        },
        get: function (url, data, callback, async, json) {
          // console.log(url);
            var query = [];
            for (var key in data) {
                query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
            }
            this.send(url + (query.length ? '?' + query.join('&') : ''), callback, 'GET', null, async, json)
        },
        json: function(url, data, callback, async){
          $x.post(url, data, callback, async, true);
        },
        // json_get: function(url, data, callback, async){
        //   $x.get(url, data, callback, async, true);
        // },
        post: function (url, data, callback, async, json) {
          // console.log('X GON GIVE IT TO YA');
            var query = [];
            for (var key in data) {
                query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
            }
            this.send(url, callback, 'POST', query.join('&'), async, json)
        }
    };

    ajax.init = function (){
        var self = this;

    }

    ajax.init.prototype = ajax.prototype;

    global.ajax = global.$x = ajax();

})(window);
