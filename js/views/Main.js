"use strict";
APP.MainView = Backbone.View.extend({

    template: _.template($('#indexTemplate').html()),

    render: function () {
        
        var self = this;
        this.collection.fetch({
            success: function () {
                self.$el.html(
                    self.template({students: self.collection.toJSON()})
                );
            }
        });
        return this;
    }
});