SonataExtensions.Controller = SonataExtensions.Class.extend({
    request: null,
    init: function (request) {
        this.request = request;
        this.bind();
    },
    bind: function () {},
    find: function (selector) {
        return $(selector);
    }
});