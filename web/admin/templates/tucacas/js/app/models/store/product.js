;(function($, window){
    'use strict';
    var App = window.App;

    App.Data.Product = App.Data.Product || {};

    App.Models.Product = function(){
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
                dbIndex = 'Product:'+ modelId;

            App.DB.set(dbIndex, data);
            console.log('App.Utils.Connection.Live');
            if (App.Utils.Connection.Live) {console.log(38);

                fetch(App.Route.CreateAdminUrl('api/v1/products', {resp:'json', action:action, id:modelId}))
                    .then(function(resp) {
                        return resp.json().catch(error => {
                            return Promise.reject(new ResponseError('Invalid JSON: ' + error.message));
                        });
                    })
                    .then(function(data){
                        App.Data.set('products', List(data.results));
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
                dbIndex = 'Product:'+ modelId;

            App.DB.set(dbIndex, data);

            if (App.Utils.Connection.Live) {
                return $.ajax({
                    url:App.Route.CreateAdminUrl('api/v1/products', {resp:'json', action:action, id:modelId}),
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
            App.Utils.Tasks.AddQueue('DB:push:Product:'+ modelId, {
                type:'connect',
                requestUrl:App.Route.CreateAdminUrl('api/v1/products', {resp:'json', action:action, id:modelId}),
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
            var type, response,
                self = this;

            $('body').on('Product:OnSave',App.Events.Product.OnSave);
            console.log('92');
            console.log(modelId);
            beforeSave();

            if (modelId === 0) {
                type = 'POST';
            } else {
                type = 'PUT';
            }
            push(type, '_products', self.data).done(function(data) {
                if (data.error) {

                } else {
                    console.log(data);
                    $('body').trigger('Product:OnSave');
                    afterSave(data);
                }
            }).fail(function(data) {
                SaveDeferred(type, action, dbIndex);
            });
            console.log('102');

            $('body').off('Product:OnSave', App.Events.Product.OnSave);
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
            fetch('_products', data, null)
                .done(function(resp){
                console.log(resp);
            })
                .fail();
        }

        function getAll(data) {
            if (typeof data == 'undefined') { null; }
            return App.Data.set('products');
        }

        /** public functions and vars **/

        this.data = {};

        this.modelId = null;

        this.get = function(attribute) {
            get(attribute);
            console.log('model/store/product::get()', this.data[attribute]);
            return this.data[attribute] || null;
        };

        this.set = function(attribute, value) {
            set(attribute, value);
            if (typeof attribute == 'undefined' || typeof value == 'undefined') return;
            this.data[attribute] = value;
            console.log('model/store/product::set()', this.data[attribute]);
        };

        this.getId = function() {
            return this.modelId;
        };

        this.setId = function(id) {
            this.modelId = modelId = id;
        };

        this.save = function() {
            return save();
        };

        this.push = function(type, action, data, cb) {
            return push(type, action, data, cb);
        }

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