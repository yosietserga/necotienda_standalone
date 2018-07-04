/** @jsx React.DOM **/

class ProductListItemsActivateLabel extends NecotiendaComponent {
    render() {
        return (
            <td className="project-status">
                <span className="label label-primary">{this.props.status}</span>
            </td>
        );
    }
}

class ProductListItemsActivateButton extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this.state = {activated: false};
    }

    handleClick(e) {
        e.preventDefault();
        this.setState({activated: !this.state.activated});
        this.props.onActivate(this.state.activated);
        this.props.model.save('status', !this.state.activated);
        /**
         * update model
         * add push request to task queue
         * update db record
         */
    }

    render() {
        var text = this.state.activated ? 'Activate' : 'Disactivate';
        return (
            <a href="#" className="btn btn-white btn-sm" onClick={this.handleClick}><i
                className="fa fa-pencil"></i> {text} </a>
        );
    }
}

class ProductListItems extends NecotiendaComponent {

    constructor(props) {
        super(props);
        var statusText = props.product.get('status') ? 'Active' : 'Inactive',
            statusClass = props.product.get('status') ? 'label label-primary' : 'label label-default';
        this.state = {
            statusText: statusText,
            statusClass: statusClass
        };
    }

    onHandleActivate(status) {
        var statusText = status ? 'Active' : 'Inactive';
        var statusClass = status ? 'label label-primary' : 'label label-default';
        this.setState({
            statusText: statusText,
            statusClass: statusClass
        });
    }

    render() {
        const {product} = this.props;
        var rating_img = window.nt.http_image + 'stars_' + product.get('rating') + '.png';
        const swipeConfig = {
            startSlide:1,
            continuous: false
        };

        return (
            <ReactSwipe className="carousel" swipeOptions={swipeConfig}>
                <div>Reviews and Stats</div>
                <div>

                    <a href={App.Route.CreateAdminUrl('api/v1/products', {id: product.get('id')})}>
                        <img alt={product.get('title')} className="img-circle" src={product.get('image')}/>
                    </a>

                    <div className="project-title">
                        <a href={App.Route.CreateAdminUrl('api/v1/products', {id: product.get('id')})}>{product.get('title')}</a>
                        <br/>
                        <small>{product.get('model')}</small>
                        <br/>
                        <img src={rating_img} alt={product.get('rating')}/>
                        <br/><br/>
                        <h3><strong>{product.get('price')}</strong></h3>
                    </div>
                    <div className="project-completion">
                        <small>viewed: {product.get('viewed')}</small>
                        <br/>
                        <small>quantity: {product.get('quantity')}</small>
                    </div>
                    <div className="project-status">
                        <span className={this.state.statusClass}>{this.state.statusText}</span>
                    </div>
                </div>
                <div>

                    <div className="project-actions">
                        <a href="#" className="btn btn-white btn-sm"><i className="fa fa-folder"></i> read </a>
                        <a href="#" className="btn btn-white btn-sm"><i className="fa fa-pencil"></i> Edit </a>
                        <a href="#" className="btn btn-white btn-sm"><i className="fa fa-pencil"></i> Edit </a>

                        <ProductListItemsActivateButton model={this.props.model}
                                                        onActivate={this.onHandleActivate}
                                                        productId={product.get('id')} />

                    </div>
                </div>
            </ReactSwipe>

        );
    }
}