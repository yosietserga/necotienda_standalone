/** @jsx React.DOM **/

class InputsProductModel extends NecotiendaComponent {

    constructor(props) {
        super(props);

        this.state = {
            field:'model'
        };

        this._bind('save');
        /* //TODO: float fomatter */
    }

    save(e) {
        e.preventDefault();
        const { field } = this.state;
        var data = {};
        data[field] = e.target.value;
        this.props.save( data );
    }

    render() {
        const { field } = this.state;
        return (

            <div className="col-lg-8">
                <div className="ibox float-e-margins">
                    <div className="ibox-content" style={{borderTop: 'none'}}>
                        <div className="row">
                            <div className="col-sm-12">
                                <div className="panel blank-panel">

                                    <InputsCommonText 
                                        type="text" 
                                        name={field}
                                        placeholder={field} 
                                        onBlur={this.save} 
                                        className="form-control product-input"
                                    />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}