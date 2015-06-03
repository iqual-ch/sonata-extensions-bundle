SonataExtensions.Form.Collection = SonataExtensions.FormElement.extend({
    name: null,
    buttonAdd: null,
    buttonRemove: null,
    addEmpty: null,
    table: null,
    prototype: null,
    
    init: function (name, addEmpty) {
        this._super(name);
        this.name = name;
        
        this.addEmpty = addEmpty == undefined ? true : addEmpty;
        
        this.table = $('#' + name + '-table');
        this.buttonAdd = '.se-btn-add';
        this.buttonRemove = '.se-btn-remove';
        this.prototype = $('#' + name + '-prototype').html();
        
        var self = this;
        this.table.on('click', this.buttonAdd, function () {
            self.addRow();
        });
        this.table.on('click', this.buttonRemove, function () {
            var index = $(this).closest('tr').prevAll().size();
            self.removeRow(index);
        });
    },
    
    addRow: function () {
        var table = this.table;
        var pos = table.find('tbody tr').size();
        var row = this.createEmptyRow(pos);

        table.find('tbody').append(row);
        Admin.setup_icheck();
        Admin.setup_select2();
        this.event.trigger(SonataExtensions.Form.Collection.Events.ROW_ADDED, [this, row]);
        return row;
    },
    
    removeRow: function (index, addEmpty) {
        if (addEmpty === undefined) {
            addEmpty = this.addEmpty;
        }
        
        this.table.find('tbody tr').eq(index).remove();
        this.event.trigger(SonataExtensions.Form.Collection.Events.ROW_REMOVED, [this]);
        
        if (addEmpty) {
            this.insertNewRowIfNoneLeft();
        }
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