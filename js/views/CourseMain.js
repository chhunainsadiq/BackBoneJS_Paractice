"use strict";
APP.CourseMainView = Backbone.View.extend({

    template: _.template($('#CourseindexTemplate').html()),

    render: function () {
        console.log(this.collection);
        console.log(this.collection.toJSON());

        var self = this;
        this.collection.fetch({
            success: function () {
                self.$el.html(
                    self.template({courses: self.collection.toJSON()})
                );
            }
        });
        return this;
    }
});