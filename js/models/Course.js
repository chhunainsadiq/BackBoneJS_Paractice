"use strict";
APP.Course = Backbone.Model.extend({
    idAttribute: 'Course_id',

    defaults: {
        Course_id: "",
        Course_name: "",
        table : "Course"
    },
    url: 'database.php'

});
