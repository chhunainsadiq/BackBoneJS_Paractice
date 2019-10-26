"use strict";
APP.EditCourseView = Backbone.View.extend({
    // functions to fire on events
    events: {
        "click .save": "save"
    },

    // the template
    template: _.template($('#CourseformTemplate').html()),

    initialize: function () {
    },


    save: function (event) {
        event.stopPropagation();
        event.preventDefault();

        this.model.set({
            Course_id: this.$el.find('input[name=Course_id]').val(),
            Course_name: this.$el.find('input[name=Course_name]').val(),
        });

        //if (this.model.isValid()) {
        var id = this.$el.find('input[name=Course_id]').val();
        var nm = this.$el.find('input[name=Course_name]').val();

        this.model.save();
        Backbone.history.navigate("course/index", {trigger: true});
    },

    render: function () {
        this.$el.html(
            this.template(this.model.toJSON())
        );
        return this;
    }
});