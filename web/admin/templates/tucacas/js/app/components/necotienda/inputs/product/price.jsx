/** @jsx React.DOM **/

class InputsProductPrice extends NecotiendaComponent {

    constructor(props) {
        super(props);

        this.state = {
            field:'price'
        };

        this._bind('save');
        /* //TODO: currency fomatter */
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
            <InputsCommonText 
                type="text" 
                name={field}
                placeholder={field} 
                onBlur={this.save} 
                className="form-control product-input"
            />
        );
    }
}