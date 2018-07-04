/** @jsx React.DOM **/

class ProductListMain extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this._bind('handleBtnForm', 'handleBtnImport');
        this.state = {
            products:[],
        };
    }

    onHandleSubmit(filters) {
        this._listProducts(filters);
    }

    _listProducts(filters) {
        const { title } = filters;

        if (typeof title !== 'undefined' || App.Data.get('products') !== App.Data.get('list:products') || typeof App.Data.get('list:products') == 'null') {
            /* //TODO: check if necessary to make a nw request instead to use cached data */ 
            /* async products */
            /*
            check if products wasn't updated by other user in another session
            could be fetching some hash key for last products cached and compare it against clint current hash products key
            if are different: update list products, else use list products cached
             */
            fetch(App.Route.CreateAdminUrl('api/v1/products',{
                title:title
            }), {
                credentials: 'same-origin'
            })
                .then(resp => {
                    return resp.json().catch(error => {
                        console.log('ERROR', error);
                        return 'Invalid JSON: ' + error.message;
                    });
                })
                .then(data => {
                    var products = App.Utils.Immutable.fromJS(data.payload.results);

                    App.Data.set('products', products);
                    App.Data.set('list:products', products);

                    this.setState({
                        products: products
                    });
                });
        } else {
            /* cached products */
            this.setState({
                products: App.Data.get('list:products')
            });
        }
    }

    componentDidMount() {
        this._listProducts({ title:'' });
    }

    shouldComponentUpdate(nextProps, nextState) {
        return !(App.Data.get('products') !== App.Data.get('list:products') || typeof App.Data.get('list:products') == 'null');
    }

    handleBtnForm(e) {
        e.preventDefault();
        this.props.onBtnFormClick('ProductFormMain');
    }

    handleBtnImport(e) {
        console.log('click:handleBtnImport()');
        e.preventDefault();
        this.props.onBtnImportClick('ProductImportMain');
    }

    render() {
        const { products } = this.state;

        return (
            <div className="ibox">
                <div className="ibox-title">
                    <div className="ibox-tools">
                        <a onClick={this.handleBtnForm} className="btn btn-primary btn-xs">Add Product</a>
                        <a onClick={this.handleBtnImport} className="btn btn-primary btn-xs">Import Products</a>
                    </div>
                </div>
                <div className="ibox-content col-md-6">
                    <div className="col-md-12">
                        <ProductSearchBox onInputSubmit={(query) => this.onHandleSubmit(query)} />
                        <ProductList products={ products } />
                    </div>

                </div>
            </div>
        );
    }
}