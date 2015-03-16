SonataExtensions.EventDispatcher = SonataExtensions.Class.extend({
    trigger: function (name, data) {
        $(this).trigger(name, data);
    },
    
    triggerGlobally: function (name, data) {
        $(document).trigger(name, data);
    },
    
    on: function (event, callback) {
        $(this).on(event, callback);
    },
    
    onGlobally: function (name, callback) {
        $(document).on(name, callback);
    }
});