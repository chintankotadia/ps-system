(function($) {

    var _init = [];

    $.app = {

        init: function(f) {
            if(f) {
                _init.push(f);
            }
            else {
                $.each(_init, function(idx, f) {
                    f();
                });
            }

            $.app.backToTop();
        },

        json: {
            encode: function(obj, useOwn) {
                if(typeof JSON != "undefined" && !useOwn) {
                    return JSON.stringify(obj);
                } else {
                    return _json_encode(obj, []);
                }
            },

            decode: function(str) {
                return $.parseJSON(str);
            }
        },

        ajax: function(method, url, params, callback, error, beforeCallback) {
            if(typeof params == "function") {
                error = callback;
                callback = params;
                params = {};
            }

            callback = callback || function() {};
            error = error || function() {};
            beforeCallback = beforeCallback || function() {};

            $.ajax({
                type: method,
                url: url,
                data: params,
                dataType: 'json',
                beforeSend: beforeCallback,
                success: function(result) {
                    if(!result.success && result.message == '404 page not found.') {
                        window.location.reload();
                    } else  {
                        callback(result);
                    }
                },
                error: error
            });
        },

        get: function(controller, params, callback, error) {
            $.app.ajax("get", controller, params, callback, error);
        },

        post: function(controller, params, callback, error) {
            $.app.ajax("post", controller, params, callback, error);
        },

        message_box: function(message, selector, element) {
            switch(selector) {
                case 'error':
                    $(element+' .message-container').html('<div class="alert alert-error"><a class="close" data-dismiss="alert">x</a>'+message+'</div>');
                    break;

                case 'warning':
                    $(element+' .message-container').html('<div class="alert alert-error"><a class="close" data-dismiss="alert">x</a>'+message+'</div>');
                    break;

                case 'info':
                    $(element+' .message-container').html('<div class="alert alert-error"><a class="close" data-dismiss="alert">x</a>'+message+'</div>');
                    break;

                case 'success':
                default:
                    $(element+' .message-container').html('<div class="alert alert-success"><a class="close" data-dismiss="alert">x</a>'+message+'</div>');
                    break;
            }
        },

        element_message_box : function(message, selector, element) {
            element.html('<div class="alert alert-'+selector+'"><a class="close" data-dismiss="alert">x</a>'+message+'</div>');
        },

        trim : function(string) {
            return $.trim(string);
        },

        urls: function(value) {
            var data = $.parseJSON(urls);

            switch(value) {
                case 'base_url':
                default:
                    return data.base_url;
                    break;
            }
        },

        /** Apply icheck to checkbox*/
        iCheck: function() {
            if(jQuery().iCheck){
                $('.iCheck, .icheck').iCheck({
                    checkboxClass: 'icheckbox_square-blue checkbox',
                    radioClass: 'iradio_square-blue'
                });
            }
        },

        backToTop: function() {

            var offset   = 220, duration = 500;

            $(window).scroll(function() {
                if ($(this).scrollTop() > offset) {
                    $('.back-to-top').fadeIn(duration);
                } else {
                    $('.back-to-top').fadeOut(duration);
                }
            });

            $('.back-to-top').click(function(event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, duration);
                return false;
            });
        }
    }

    $(document).ready(function() {
        _bind_events();
    });

    var _bind_events = function() {
        $.app.backToTop();
    }

    var _json_encode = function(obj, cache) {
        if($.inArray(obj, cache) > -1) {
            throw "JSON error: circular reference";
        }

        if(obj === null) {
            return "null";
        }
        else if(typeof obj == "string") {
            return "\"" + obj.replace(/\\/g, "\\\\").replace(/"/g, "\\\"") + "\"";
        }
        else if(typeof obj == "object") {
            cache.push(obj);
            if(obj.constructor === window.Array) {
                return "[" + $.map(obj, function(v) {return _encode(v, cache.slice(0));}).join(", ") + "]";
            }
            else {
                var p = [];
                for(var k in obj) {
                    if(obj.hasOwnProperty(k)) {
                        p.push(_encode(k, cache.slice(0)) + ": " + _encode(obj[k], cache.slice(0)));
                    }
                }
                return "{" + p.join(", ") + "}";
            }
        }
        else {
            return obj.toString();
        }
    };

})(jQuery);