//"use strict";
window.APP = window.APP || {};

APP.crudRouter = Backbone.Router.extend({
    routes: {
        "student/new": "create",
        "student/index": "index",
        "student/:id/edit": "edit",
        "student/:id/delete": "delete",
        "student/:id/showCourses": "showCourses",
        "course/new": "CourseCreate",
        "course/index": "CourseIndex",
        "course/:id/edit": "CourseEdit",
        "course/:id/delete": "CourseDelete",
        "course/:id/showStudents": "showStudents",
        "courseAgStudent/new" : "createCourseAgainstStudent"
    },

    $container: $('#primary-content'),

    initialize: function () {
        Backbone.emulateHTTP = true;
        Backbone.emulateJSON = true;

        this.index();
        // start backbone watching url changes
        Backbone.history.start();
    },

    create: function () {
        var view = new APP.AddStudentView({
            collection: this.collection,
            model: new APP.Student()
        }); 
        this.$container.html(view.render().el);
    },

    delete: function (Roll_No) {
        console.log(this.collection);
        var crud = this.collection.get(Roll_No);
        crud.destroy({
            data: "model="+JSON.stringify(crud)+"&_method=DELETE"
                //+"&_table=student"
        });
        Backbone.history.navigate("student/index", {trigger: true});
    },

    edit: function (Roll_No) {
        var view = new APP.EditStudentView({
            model: this.collection.get(Roll_No)});
        this.$container.html(view.render().el);
    },

    index: function () {
        this.collection = new APP.Students();
        this.collection.fetch();  // to set fetch the default set of model in the collection using the sync method.
        console.log(this.collection);
        var view = new APP.MainView({collection: this.collection});
        this.$container.html(view.render().el);
    },
    showCourses: function (Roll_No) {
        this.collection = new APP.StudentsCourses();
        this.collection.url += "&Roll_No="+Roll_No;
        this.collection.fetch();
        var view = new APP.CourseMainView({collection: this.collection});
        this.$container.html(view.render().el);
    },

    showStudents: function (Course_id) {
        this.collection = new APP.StudentsCourses();
        this.collection.url += "&Course_id="+Course_id;
        this.collection.fetch();
        var view = new APP.MainView({collection: this.collection});
        this.$container.html(view.render().el);
        // Backbone.history.navigate("course/index", {trigger: true});
    },

    //Course functions
    CourseCreate: function () {
        var view = new APP.AddCourseView({
            collection: this.collection,
            model: new APP.Course()
        });
        this.$container.html(view.render().el);
    },

    CourseDelete: function (id) {
        console.log(this.collection);
        var crud = this.collection.get(id);
        crud.destroy({
            data: "model="+JSON.stringify(crud)+"&_method=DELETE"
            //+"&_table=student"
        });
        Backbone.history.navigate("course/index", {trigger: true});
    },

    CourseEdit: function (id) {
        var view = new APP.EditCourseView({
            model: this.collection.get(id)});
        this.$container.html(view.render().el);
    },

    CourseIndex: function () {
        this.collection = new APP.Courses();
        this.collection.fetch();
        var view = new APP.CourseMainView({collection: this.collection});
        this.$container.html(view.render().el);
    },

    createCourseAgainstStudent: function () {
    var view = new APP.AddCourseAgStdView({
        collection: this.collection,
        model: new APP.StudentCourse()
    });
    this.$container.html(view.render().el);
},

});