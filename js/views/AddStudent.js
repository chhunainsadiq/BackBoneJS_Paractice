"use strict";

APP.AddStudentView = Backbone.View.extend({
    // functions to fire on events
    // here we are blocking the submission of the form, and handling it ourself
    events: {
        "click .save": "save",
        "keyup input": "validate",
    },

    template: _.template($('#formTemplate').html()),

    initialize: function () {
        this.model.bind('invalid', this.showErrors);
    },

    save: function (event) {
        event.stopPropagation();
        event.preventDefault();

        this.model.set({
            Roll_No: this.$el.find('input[name=Roll_No]').val(),
            Name: this.$el.find('input[name=Name]').val(),
            Email: this.$el.find('input[name=Email]').val(),
        });

        var id = this.$el.find('input[name=Roll_No]').val();
        var nm = this.$el.find('input[name=Name]').val();
        var em = this.$el.find('input[name=Email]').val();

        if (this.model.isValid()) {
            // save
            this.collection.add(this.model);

            this.model.sync("create", this.model);
            Backbone.history.navigate("student/index", {trigger: true});
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
        this.$el.html(
            this.template(this.model.toJSON())
        );
        return this;
    }
});