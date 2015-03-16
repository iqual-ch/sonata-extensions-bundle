SonataExtensions.Form.GlobalFormElements = {
    initAll: function () {
        this.initMoney();
    },
    initMoney: function () {
        $(document).find('[data-type="money"]').maskMoney();
    }
};