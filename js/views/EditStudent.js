"use strict";
APP.EditStudentView = Backbone.View.extend({
    // functions to fire on events
    events: {
        "click .save": "save"
    },

    // the template
    template: _.template($('#formTemplate').html()),

    initialize: function () {
    },

    save: function (event) {
        event.stopPropagation();
        event.preventDefault();

        this.model.set({
            Roll_No: this.$el.find('input[name=Roll_No]').val(),
            Name: this.$el.find('input[name=Name]').val(),
            Email: this.$el.find('input[name=Email]').val(),
        });

        //if (this.model.isValid()) {
        var id = this.$el.find('input[name=Roll_No]').val();
        var nm = this.$el.find('input[name=Name]').val();
        var em = this.$el.find('input[name=Email]').val();

        this.model.save();
        Backbone.history.navigate("student/index", {trigger: true});
    },

    render: function () {
        this.$el.html(
            this.template(this.model.toJSON())
        );
        return this;
    }
});