"use strict";
APP.Student = Backbone.Model.extend({
    idAttribute: 'Roll_No',

    defaults: {
        Name: "",
        Email: "",
        Roll_No: "",
        table : "Student"
    },
    url: 'database.php'

});
