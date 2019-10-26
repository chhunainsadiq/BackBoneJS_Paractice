APP.Students = Backbone.Collection.extend({
    model: APP.Student,
    url: 'database.php?table=Student'
});