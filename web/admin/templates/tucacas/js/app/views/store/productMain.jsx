/** @jsx React.DOM **/

if (typeof window.App === 'undefined') {
    console.log('Error: Can\'t find App container');
} else {
    var App = window.App;
}

const { List, Map } = App.Utils.Immutable;
const { Provider, connect } = ReactRedux;
const { createStore, combineReducers } = Redux;

/************* PRODUCT REDUX ******************/
App.Types.Product = {
    ADD_PRODUCT:'ADD_PRODUCT'
};

App.Actions.Product = {
    add: () => {
        return {
            type: 'ADD_TODO',
            products:App.Data.get('products')
        };
    }
};

App.Reducers.Product = (state = {}, action) => {
    if (!$.inArray(state.type, App.Types.Product)) {
        console.log('this type {'+ state.type +'} is not allowed');
        return;
    }

    switch (action.type) {
        case App.Types.Product.ADD_PRODUCT:
            var newState = Object.assign({}, { products:action.products }, state);
            return newState;

        default:
            return state;
    }
};
/************* /PRODUCT REDUX ******************/
rootReducer = combineReducers({
    product:App.Reducers.Product,
});

App.Data.set('store', createStore( rootReducer ));

class ProductMain extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this._bind('toogleView');

        this.state = {
            partialView: 'ProductListMain',
            isToggleOn: true
        }

        this.handleClick = this.handleClick.bind(this);
    }

    handleClick() {
        this.setState(prevState => ({
            isToggleOn: !prevState.isToggleOn
        }));
    }


    _renderPartial() {
        switch(this.state.partialView) {
            case 'ProductFormMain':
                return <ProductFormMain onBtnCancelClick={this.toogleView} />;
            case 'ProductImportMain':
                return <ProductImportMain onBtnCancelClick={this.toogleView} />;
            case 'ProductListMain':
            default:
                return <ProductListMain
                    collection={this.Products}
                    onBtnFormClick={this.toogleView}
                    onBtnImportClick={this.toogleView} />;
        }
    }

    toogleView(v) {
        if (typeof e !== 'undefined') {
            e.preventDefault();
        }
        this.setState(prevState => ({
            partialView: v
        }));
    }

    render() {
    const { Button } = mui;

        return (
            <div className="row">
                <Button onClick={this.handleClick}>
                    {this.state.isToggleOn ? 'ON' : 'OFF'}
                </Button>

                <Button variant="contained" color="primary">
                  Hello World
                </Button>

                <div className="col-md-12">
                    <div className="wrapper wrapper-content animated fadeInUp">
                        {this._renderPartial()}
                    </div>
                </div>
            </div>
        );
    }
}

const mapStateToProps = state => ({ products:state.products });
connect(mapStateToProps)(ProductMain);

ReactDOM.render(
    <Provider store={App.Data.store}>
        <ProductMain App={App} />
    </Provider>,
    document.getElementById('app')
);