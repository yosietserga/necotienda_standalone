/** @jsx React.DOM **/

class ProductImportMain extends NecotiendaComponent {
    constructor(props) {
        super(props);
        this._bind('handleCancel');
    }

    onHandleSubmit(query) {
        this.getCollection().fetch({
            data: $.param({
                q: query,
                limit: 25
            })
        });
    }

    componentDidMount() {

    }

    componentDidUpdate() {

    }

    handleCancel(e) {
        e.preventDefault();
        this.props.onBtnCancelClick('ProductListMain');
    }

    render() {
        return (
            <div className="ibox">
                <div className="ibox-title">
                    <div className="ibox-tools">
                        <a onClick={this.handleCancel} className="btn btn-primary btn-xs">Cancel</a>
                    </div>
                </div>
                <div className="ibox-content">
                    Importar
                </div>
            </div>
        );
    }
}