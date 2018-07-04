;(function($, window){
    'use strict';
    var App = window.App;

    App.DB.get = function(index) {
        return simpleStorage.get(index, null);
    };

    App.DB.set = function(index, value) {
        simpleStorage.set(index, value);
    };

    App.DB.clear = function(index) {
        simpleStorage.deleteKey(index);
    };

    window.App = App;
})(jQuery, window);