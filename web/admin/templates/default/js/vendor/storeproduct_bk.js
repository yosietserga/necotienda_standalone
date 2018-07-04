(function($, window){
    var App = window.App;

        App.Views.main = React.createClass({
            mixins: [Backbone.React.Component.mixin],
            onHandleSubmit: function(query) {
            this.getCollection().fetch({
                data: $.param({
                    q: query,
                    limit: 25
                }),
                success: function(data) {

                }
            });
        },
        render: function() {
            return (
                <div>
                <App.Views.SearchBox onInputSubmit={this.onHandleSubmit} />
        <App.Views.SearchResults data={this.props.collection} />
    </div>
);
}
});

React.render(<App.Views.main collection={new App.Collections.Characters} />, document.getElementById('app'));


    window.App = App;
})(jQuery, window);

App.Views.ProductForm.Create('ProductForm');


var Product1 = new App.Models.Product;
var Product2 = new App.Models.Product;

Product1.setId(1);
Product2.set('name', 'IPad');
console.log(Product2.getId());
$('body').on('click', function() {
    Product2.save();
});
$('body').on('Product:OnSave',function(e){
    console.log(Product2.getById(Product2.getId()));
    console.log(Product2.getAll());
});

function set(attribute, value) {
    console.log('duplicated');
}