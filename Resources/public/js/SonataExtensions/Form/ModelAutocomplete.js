SonataExtensions.Form.ModelAutocomplete = SonataExtensions.FormElement.extend({
    hiddenField: null,
    init: function (options) {
        this._super();
        this.hiddenField = $('#' + options.hiddenField);
        var self = this;
        $('#' + options.id).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: options.url,
                    data: {
                        q: request.term,
                        key: options.key
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: options.minLength,
            select: function (e, ui) {
                self.hiddenField.val(ui.item.id);
                self.event.triggerGlobally(SonataExtensions.Form.ModelAutocomplete.Events.SELECT, [e, ui]);
                self.event.trigger(SonataExtensions.Form.ModelAutocomplete.Events.SELECT, [e, ui]);
            }
        });
    }
});
SonataExtensions.Form.ModelAutocomplete.Events = {
    SELECT: 'se-model-autocomplete-select'
};