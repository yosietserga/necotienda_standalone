;(function($, window){
    'use strict';
    var App = window.App;

    App.Data.Language = App.Data.Language || {};

    App.Models.Language = function(){
        /** private functions and vars **/
        var data = {},
            modelId = 0;

        function compare() {
            if (attributes !== this.attributes) {
                push('update', this.attributes);
            }
        }

        function fetch(action, data, cb) {
            if (typeof action == 'undefined') {
                action = null;
            }
            if (typeof data == 'undefined') {
                data = null;
            }
            if (typeof cb == 'undefined') {
                cb = null;
            }
            console.log(30);
            var data = data,
                action = action,
                Model = this,
                dbIndex = 'Language:'+ modelId;

            App.DB.set(dbIndex, data);
            console.log('App.Utils.Connection.Live');
            if (App.Utils.Connection.Live) {console.log(38);
                return $.ajax({
                    url:App.Route.CreateAdminUrl('api/language', {resp:'json', action:action, id:modelId}),
                    type:'GET',
                    dataType:'json',
                    data:data
                });
            } else {
                /** //TODO: handle no connection
                 * **/
            }
        }

        function push(type, action, data, cb) {
            if (typeof action == 'undefined') {
                return null;
            }

            if (typeof type == 'undefined') {
                type = 'post';
            }

            if (typeof cb == 'undefined') {
                cb = null;
            }

            var data = data,
                action = action,
                type = type,
                Model = this,
                dbIndex = 'Language:'+ modelId;

            App.DB.set(dbIndex, data);

            if (App.Utils.Connection.Live) {
                return $.ajax({
                    url:App.Route.CreateAdminUrl('api/language', {resp:'json', action:action, id:modelId}),
                    type:type,
                    dataType:'json',
                    data:data
                });
            } else {
                SaveDeferred(type, action, dbIndex);
            }
        }

        function SaveDeferred(type, action, dbIndex) {
            console.log('db request deferred');
            App.Utils.Tasks.AddQueue('DB:push:Language:'+ modelId, {
                type:'connect',
                requestUrl:App.Route.CreateAdminUrl('api/language', {resp:'json', action:action, id:modelId}),
                requestType:type,
                requestDataType:'json',
                beforeSend:this.beforeSave,
                onSuccess:this.afterSave,
                onError:this.errorHandler
            }, dbIndex);
        }

        function errorHandler(jqXHR, textStatus, errorThrown) {

        }

        function get(attribute) {
            return data[attribute] || null;
        }

        function set(attribute, value) {
            if (attribute === 'id') return;
            data[attribute] = value;
        }

        function save() {
            var type, response;

            $('body').on('Language:OnSave',App.Events.Language.OnSave);
            console.log('92');
            console.log(modelId);
            beforeSave();

            if (modelId === 0) {
                type = 'POST';
            } else {
                type = 'PUT';
            }
            push(type, '_Languages', data).done(function(data) {
                if (data.error) {

                } else {
                    console.log(data);
                    $('body').trigger('Language:OnSave');
                    afterSave(data);
                }
            }).fail(function(data) {
                SaveDeferred(type, action, dbIndex);
            });
            console.log('102');

            $('body').off('Language:OnSave', App.Events.Language.OnSave);
        }

        function beforeSave() {

        }

        function afterSave(data) {
            if (typeof data == 'undefined') {
                data = null;
            }
            if (typeof data.data.id !== 'undefined') {
                modelId = data.data.id;
            }
        }

        function getById(id, data) {
            if (typeof id == 'undefined') { return null; }
            if (typeof data == 'undefined') { null; }
            data.id = id;
            fetch('_Languages', data, null)
                .done(function(resp){
                console.log(resp);
            })
                .fail();
        }

        function getAll(data) {
            if (typeof data == 'undefined') { null; }
            fetch('_Languages', data, null).done(function(resp){
                console.log(resp);
            }).fail();
        }

        /** public functions and vars **/

        this.get = function(attribute) {
            get(attribute);
        };

        this.set = function(attribute, value) {
            set(attribute, value);
        };

        this.getId = function() {
            return modelId;
        };

        this.setId = function(id) {
            modelId = id;
        };

        this.save = function() {
            return save();
        };

        this.fetch = function(action, data, cb) {
            return fetch(action, data, cb);
        };

        this.getById = function(id, data) {
            return getById(id, data);
        };

        this.getAll = function(data) {
            return getAll();
        };
    };

    window.App = App;
})(jQuery, window);