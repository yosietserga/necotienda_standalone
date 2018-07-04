/**
 * Created by Carlos on 10-09-2015.
 */

(function (window) {
    'use strict';
    var App = App || {};

    App.Collections = {};
    App.Models = {};
    App.Views = {};
    App.Events = {};
    App.Route = {};
    App.Utils = {};
    App.Data = {};
    App.DB = {};
    App.Actions = {};
    App.Reducers = {};
    App.Types = {};
    App.Const = {};

    App.Utils.React = React || null;
    App.Utils.ReactDOM = ReactDOM || null;
    App.Utils.Redux = Redux || null;
    App.Utils.Immutable = Immutable || null;

    if (!App.Utils.React) {
        console.log('Error: ReactJS is required to work this app');
    }

    App.Data.get = (key) => {
        if (
            key === 'get' ||
            key === 'set' ||
            key === 'isSet' ||
            key === 'clear'
        ) return false;
        return App.Data[key] || null;
    };

    App.Data.isSet = (key) => {
        if (
            key === 'get' ||
            key === 'set' ||
            key === 'isSet' ||
            key === 'clear'
        ) return false;
        return !(typeof App.Data[key] === 'undefined');
    };

    App.Data.set = (key, value) => {
        if (
            key === 'get' ||
            key === 'set' ||
            key === 'isSet' ||
            key === 'clear'
        ) return false;

        App.Data[key] = value;
    };

    window.App = App;
})(window);




var functionExists = (fn, cb=null, args=null) => {
    if (typeof fn !== "function") return false;
    if (cb) {
        return cb(args);
    }
    return true;
};

var loadJSPolyfills = fn => {
    if (!functionExists(fn)) {
        var s = document.createElement('script');
        s.src = window.nt.http_home + '/js/polyfills/'+ fn +".js";
        document.head.appendChild(s);
    } else {
        return false;
    }
    return (functionExists(fn));
};

