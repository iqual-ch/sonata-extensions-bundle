SonataExtensions.Dialog = SonataExtensions.Class.extend({
    instance: null,
    content: null,
    onHide: null,
    event: null,
    init: function () {
        this.event = new SonataExtensions.EventDispatcher();
    },
    setContent: function (content) {
        this.instance = $(content);
        this.bind();
    },
    bind: function () {
        
    },
    show: function () {
        this.doShow();
    },
    doShow: function () {
        var self = this;
        this.instance.modal('show');
        this.instance.on('shown.bs.modal', function () {
            self.event.trigger(SonataExtensions.Dialog.Events.SHOW);
        });
        this.instance.on('hidden.bs.modal', function () {
            self.hide();
        });
    },
    hide: function () {
        this.instance.modal('hide');
        this.instance.remove();
        this.instance = null;
        this.event.trigger(SonataExtensions.Dialog.Events.HIDE, [this]);
    }
});
SonataExtensions.Dialog.Events = {
    HIDE: 'se-dialog.hide',
    SHOW: 'se-dialog.show',
    ERROR: 'se-dialog.error'
};