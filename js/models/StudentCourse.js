"use strict";
APP.StudentCourse = Backbone.Model.extend({
    idAttribute: 'Std_CourseId',

    defaults: {
        Std_CourseId: "",
        Roll_No: "",
        Name: "",
        Course_id : "",
        Course_name: "",
        table : "StudentCourse"
    },
    url: 'database.php'

});
