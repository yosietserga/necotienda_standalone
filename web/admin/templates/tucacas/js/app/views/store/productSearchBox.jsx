/** @jsx React.DOM **/

if (typeof App == 'undefined') {
    var App = window.App || {};
}

class ProductSearchBox extends NecotiendaComponent {
    constructor(props) {
        super(props);

        this._bind('handleSubmit');
    }

    handleSubmit(e) {
        e.preventDefault();
        this.props.onInputSubmit({ title:e.target.value });
    }

    render() {
        return (
            <div className="row m-b-sm m-t-sm">
                <form id="search-form" onSubmit={this.handleSubmit}>
                    <div className="col-md-6">
                        <div className="input-group">

                            <input className="input-sm form-control" type="text" id="search" onKeyUp={this.handleSubmit} name="search" placeholder="search..." />

                            <span className="input-group-btn">
                                <button type="button" className="btn btn-sm btn-primary"> Go!</button>
                            </span>

                        </div>
                    </div>
                </form>
            </div>
        );
    }
}