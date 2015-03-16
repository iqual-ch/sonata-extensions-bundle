SonataExtensions.Form.Autocomplete = SonataExtensions.FormElement.extend({
    init: function (options) {
        this._super();
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
                self.event.triggerGlobally(SonataExtensions.Form.Autocomplete.Events.SELECT, [e, ui]);
                self.event.trigger(SonataExtensions.Form.Autocomplete.Events.SELECT, [e, ui]);
            }
        });
    }
});
SonataExtensions.Form.Autocomplete.Events = {
    SELECT: 'se-autocomplete-select'
};