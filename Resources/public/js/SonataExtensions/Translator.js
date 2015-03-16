SonataExtensions.Translator = {
    translate: function (message) {
        if (_TRANSLATIONS[message]) {
            return _TRANSLATIONS[message];
        } else {
            console.warn('SonataExtensions.Translator: no translation for message: ' + message);
            return message;
        }
    }
};

function t(message) {
    return SonataExtensions.Translator.translate(message);
}