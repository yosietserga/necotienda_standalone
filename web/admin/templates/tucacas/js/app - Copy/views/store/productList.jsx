/** @jsx React.DOM **/

class ProductList extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this.state ={
            products:props.products
        };
    }

    componentWillReceiveProps(nextProps) {
        if (nextProps.products !== this.props.products) {
            this.setState({
                products:nextProps.products
            });
        }
    }

    render() {
        const { products } = this.state;

        if (products) {
            var listItems = products.map((product) => {
                return (
                    <ProductListItems key={product.get('id')} product={product}/>
                );
            });
        } else {
            var listItems = ( <tr><td> Nothing to show </td></tr> );
        }

        return (
            <div className="project-list">
                { listItems }
            </div>
        );
    }
}