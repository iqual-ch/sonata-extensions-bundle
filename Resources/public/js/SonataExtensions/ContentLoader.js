SonataExtensions.ContentLoader = Class.extend({
    url: null,
    params: null,
    method: null,
    init: function (url, params, method) {
        if (!url) {
            throw 'SonataExtensions.ContentLoader: url cannot be null.';
        }
        this.url = url;
        this.params = params || {};
        this.method = method || 'GET';
    },
    load: function () {
        return $.ajax({
            method: this.method,
            url: this.url,
            data: this.params
        });
    }
});