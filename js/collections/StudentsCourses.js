//Bridge table of students and courses because of many to many relation
APP.StudentsCourses = Backbone.Collection.extend({
    model: APP.StudentCourse,
    url: 'database.php?table=StudentCourse'
});