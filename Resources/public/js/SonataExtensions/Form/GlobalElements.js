SonataExtensions.Form.GlobalFormElements = {
    initAll: function () {
        this.initMoney();
    },
    initMoney: function () {
        $(document).find('[data-type="money"]').autoNumeric('init', {
            aSep: "'",
            aPad: false,
            lZero: 'deny'
        });
    }
};