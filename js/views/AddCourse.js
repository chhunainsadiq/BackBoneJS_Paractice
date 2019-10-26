"use strict";

APP.AddCourseView = Backbone.View.extend({
    // functions to fire on events
    // here we are blocking the submission of the form, and handling it ourself
    events: {
        "click .save": "save",
        "keyup input": "validate",
    },

    template: _.template($('#CourseformTemplate').html()),

    initialize: function () {
        this.model.bind('invalid', this.showErrors);
    },

    save: function (event) {
        event.stopPropagation();
        event.preventDefault();

        this.model.set({
            Course_id: this.$el.find('input[name=Course_id]').val(),
            Course_name: this.$el.find('input[name=Course_name]').val(),
        });

        var id = this.$el.find('input[name=Course_id]').val();
        var nm = this.$el.find('input[name=Course_name]').val();

        if (this.model.isValid()) {
            // save
            this.collection.add(this.model);

            this.model.sync("create", this.model);
            Backbone.history.navigate("course/index", {trigger: true});
        }
    },

    showErrors: function (note, errors) {
        $('.has-error').removeClass('has-error');
        $('.alert').html(_.values(errors).join('<br>')).show();

        // highlight the fields with errors
        _.each(_.keys(errors), function (key) {
            //jQuery('input[name=' + key + ']').parent.addClass('has-error');
        });
    },

    render: function () {
        console.log("I am in course add view");
        this.$el.html(
            this.template(this.model.toJSON())
        );
        return this;
    }
});