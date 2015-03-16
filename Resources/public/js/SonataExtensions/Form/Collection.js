SonataExtensions.Form.Collection = SonataExtensions.FormElement.extend({
    name: null,
    buttonAdd: null,
    buttonRemove: null,
    table: null,
    prototype: null,
    
    init: function (name) {
        this._super(name);
        this.name = name;
        this.table = $('#' + name + '-table');
        this.buttonAdd = '.se-btn-add';
        this.buttonRemove = '.se-btn-remove';
        this.prototype = $('#' + name + '-prototype').html();
        
        var self = this;
        this.table.on('click', this.buttonAdd, function () {
            self.addRow();
        });
        this.table.on('click', this.buttonRemove, function () {
            self.removeRow($(this));
        });
    },
    
    addRow: function () {
        var table = this.table;
        var pos = table.find('tbody tr').size();
        var row = this.createEmptyRow(pos);

        table.find('tbody').append(row);
        Admin.setup_icheck();
        this.event.trigger(SonataExtensions.Form.Collection.Events.ROW_ADDED, [this, row]);
        return row;
    },
    
    removeRow: function (button) {
        button.closest('tr').remove();
        this.event.trigger(SonataExtensions.Form.Collection.Events.ROW_REMOVED, [this]);
        this.insertNewRowIfNoneLeft();
    },
    
    insertNewRowIfNoneLeft: function() {
        if (this.table.find('tbody tr').size() === 0) {
            this.addRow();
        }
    },
    
    createEmptyRow: function (index) {
        return $(this.prototype.replace(/__name__/g, index));
    }
});

SonataExtensions.Form.Collection.Events = {
    ROW_ADDED: 'se.collection.row_added',
    ROW_REMOVED: 'se.collection.row_removed'
};