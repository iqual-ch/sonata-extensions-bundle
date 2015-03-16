SonataExtensions.Helper = {
    url: function (url, params, queryParams) {
            function replaceParameterPlaceholder(url, params) {
                params = params || {};
                var placeholders = url.match(/(:\w+)/g);
                for (var i in placeholders) {
                    var paramsKey = placeholders[i].replace(':', '');
                    if (!typeof params[paramsKey] !== undefined) {
                        var key = params[paramsKey] === null ? '' : params[paramsKey];
                        url = url.replace(placeholders[i], key);
                    } else {
                        console.error('[$url] Failed to assemble url: cannot find value of a parameter "' + paramsKey + '" for url "' + url + '". Params: ', params);
                        throw('$url: failed to assemble url.');
                    }
                }
                return url;
            };
            
            function appendQueryParams(url, params) {
                params = params || {};
                var parts = [];
                for (var i in params) {
                    parts.push(i + '=' + params[i]);
                }
               
                var appendix = parts.join('&');
                if (parts.length) {
                    appendix = '?' + appendix;
                }
                return url + appendix;
            };
        
        // replace parameters by value
        url = replaceParameterPlaceholder(url, params);

        // remove trailing slashes
        url = url.replace(/\/+$/, '');

        // append query params if any
        url = appendQueryParams(url, queryParams);
        return url;
    }
};
var _seh = SonataExtensions.Helper;