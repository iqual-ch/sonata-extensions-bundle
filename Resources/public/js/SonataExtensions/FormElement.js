SonataExtensions.FormElement = SonataExtensions.Class.extend({
    event: null,
    init: function () {
        this.event = new SonataExtensions.EventDispatcher();
    }
});
