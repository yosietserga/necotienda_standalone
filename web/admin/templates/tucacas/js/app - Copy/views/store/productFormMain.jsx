/** @jsx React.DOM **/

class ProductFormPrice extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this._bind('save');
        /* //TODO: currency fomatter */
    }

    save(e) {
        e.preventDefault();
        this.props.saveProduct({
            price: e.target.value
        });
    }

    render() {
        return (
            <div className="panel-body">
                <div className="form-group">
                    <input type="text" name="price"
                           placeholder="Product price" 
                           onBlur={this.save} className="form-control product-input"/>
                </div>
            </div>
        );
    }
}

class ProductFormQuantity extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this._bind('save');
        /* //TODO: number fomatter */
    }

    save(e) {
        e.preventDefault();
        this.props.saveProduct({
            quantity: e.target.value
        });
    }

    render() {
        return (
            <div className="panel-body">
                <div className="form-group">
                    <input type="text" name="quantity"
                           placeholder="Product Quantity" 
                           onBlur={this.save} className="form-control product-input"/>
                </div>
            </div>
        );
    }
}

class ProductFormSku extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this._bind('save');
        /* //TODO: number fomatter */
    }

    save(e) {
        e.preventDefault();
        this.props.saveProduct({
            sku: e.target.value
        });
    }

    render() {
        return (
            <div className="panel-body">
                <div className="form-group">
                    <input type="text" name="sku"
                           placeholder="Product sku" 
                           onBlur={this.save} className="form-control product-input"/>
                </div>
            </div>
        );
    }
}

class ProductFormStockStatusId extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this._bind('save');
        /* //TODO: number fomatter */
    }

    save(e) {
        e.preventDefault();
        this.props.saveProduct({
            stock_status_id: e.target.value
        });
    }

    render() {
        return (
            <div className="panel-body">
                <div className="form-group">

                    <select onChange={this.save}>
                        <option value="grapefruit">Grapefruit</option>
                        <option value="lime">Lime</option>
                        <option value="coconut">Coconut</option>
                        <option value="mango">Mango</option>
                    </select>
                </div>
            </div>
        );
    }
}

                    $items[$l] = array(
                        'product_id' => $id,
                        'id' => $id,
                        'model' => $result['model'],
                        'title' => $result['pname'],
                        'meta_keywords' => $result['meta_keywords'],
                        'meta_description' => $result['meta_description'],
                        'description' => $result['pdescription'],
                        '' => $result['sku'],
                        '' => $result['ssname'],
                        'manufacturer' => $result['mname'],
                        'shipping' => $result['shipping'],
                        'price' => $result['price'],
                        'tax_class' => $result['tctitle'],
                        'date_available' => $result['date_available'],
                        'weight' => $result['weight'],
                        'weight_class' => $result['wctitle'],
                        'length' => $result['length'],
                        'width' => $result['width'],
                        'height' => $result['height'],
                        'length_class' => $result['lctitle'],
                        'date_added' => $result['created'],
                        'date_modified' => $result['date_modified'],
                        'viewed' => $result['viewed'],
                        'subtract' => $result['subtract'],
                        'minimum' => $result['minimum'],
                        'cost' => $result['cost'],
                        'sort_order' => $result['sort_order'],
                        'image' => $image,
                        'quantity' => $result['quantity'],
                        'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'))
                    );
class ProductFormMain extends NecotiendaComponent {
    constructor(props) {
        super(props);

        this.state = {
            languages: []
        };

        this._bind('handleCancel');
    }

    _listLanguages(filters) {
        const { name } = filters;

        if (typeof name !== 'undefined' || App.Data.get('languages') !== App.Data.get('list:languages') || typeof App.Data.get('list:languages') == 'null') {
            /* //TODO: check if necessary to make a nw request instead to use cached data */
            /* async languages */
            fetch(App.Route.CreateAdminUrl('api/v1/languages'), {
                credentials: 'same-origin'
            })
                .then(resp => {
                    return resp.json().catch(error => {
                        console.log('ERROR', error);
                        return 'Invalid JSON: ' + error.message;
                    });
                })
                .then(data => {
                    var languages = App.Utils.Immutable.fromJS(data.payload.results);

                    App.Data.set('languages', languages);
                    App.Data.set('list:languages', languages);

                    this.setState({
                        languages: languages
                    });
                });
        } else {
            /* cached languages */
            this.setState({
                languages: App.Data.get('list:languages')
            });
        }
    }

    __saveProduct(data) {
        var type = 'post',
            postData = {},
            product = {},
            uriData = {},
            method = 'POST',
            toSave = false,
            self = this;

        product = App.Data.get('product');
        if (product) {
            uriData = {
                id:product.get('id')
            };
            method = 'PUT';
        }

        postData = data;

        fetch(App.Route.CreateAdminUrl('api/v1/products', uriData),
        {
            body: JSON.stringify(postData),
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
              'user-agent': 'Mozilla/4.0 MDN Example',
              'content-type': 'application/json'
            },
            method: method,
        })
        .then(resp => {
            return resp.json().catch(error => {
                console.log('ERROR', error);
                return 'Invalid JSON: ' + error.message;
            });
        })
        .then(data => {
            if (typeof data.payload == 'undefined') {
                /* some error messages */
            } else {
                data.payload = Object.assign({}, data.payload, postData);
                var result = App.Utils.Immutable.fromJS(data.payload);

                product = App.Data.get('product');

                if (product) {
                    product.mergeDeep(result);
                } else {
                    product = result;
                }

                if (product.get('id') != 0) {
                    App.Data.set('product', product);
                }
            }
        });
    }

    componentDidMount() {
        this._listLanguages({ name:'' });
    }

    componentDidUpdate() {

    }

    handleCancel(e) {
        e.preventDefault();
        this.props.onBtnCancelClick('ProductListMain');
    }

    render() {
        var modelProduct = new App.Models.Product,
            modelLanguage = new App.Models.Language;

        if (this.props.productId) {
            modelProduct.setId(this.props.productId);
            modelProduct.fetch().done(function (resp) {
                console.log(resp);
            });
        }

        const { languages } = this.state;
        
        return (
            <div className="ibox">

                <div className="ibox-title">
                    <div className="ibox-tools">
                        <a href={App.Route.CreateAdminUrl('store/product/insert')} className="btn btn-primary btn-xs">Save</a>
                        <a onClick={this.handleCancel} className="btn btn-primary btn-xs">Cancel</a>
                    </div>
                </div>

                <form role="form">
                    <div className="ibox-content col-md-12">
                        <ProductFormDesrciption saveProduct={this.__saveProduct} languages={languages} />
                        <ProductFormPrice saveProduct={this.__saveProduct} />
                        <ProductFormQuantity saveProduct={this.__saveProduct} />

                        <div className="col-lg-4">
                            <div className="ibox float-e-margins">
                                <div className="ibox-content"
                                     style={{borderTop: 'none', borderLeft: 'solid 1px #E7EAEC',}}>
                                    <div className="panel blank-panel">
                                        <div className="panel-heading">
                                            <div className="panel-title m-b-md"><h4>Blank Panel with text tabs</h4>
                                            </div>
                                            <div className="panel-options">

                                                <ul className="nav nav-tabs">
                                                    <li className="active"><a data-toggle="tab" href="#2tab-1">First
                                                        Tab</a></li>
                                                    <li><a data-toggle="tab" href="#2tab-2">Second Tab</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div className="panel-body">
                                            <div className="tab-content">
                                                {/*
                                                 <div id="2tab-1" className="tab-pane active">
                                                 <ProductFormImages modelProduct={modelProduct} />
                                                 </div>
                                                 */}
                                                <div id="2tab-2" className="tab-pane">
                                                    <div className="form-group">
                                                        <label className="col-lg-2 control-label">Categorias</label>
                                                    </div>
                                                    <div className="form-group">
                                                        <input type="text" placeholder="Etiquetas del producto"
                                                               className="form-control"/>
                                                    </div>
                                                    <div className="form-group">
                                                        <textarea className="form-control"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        );
    }
}