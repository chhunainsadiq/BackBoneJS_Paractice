APP.Courses = Backbone.Collection.extend({
    model: APP.Course,
    url: 'database.php?table=Course'
});