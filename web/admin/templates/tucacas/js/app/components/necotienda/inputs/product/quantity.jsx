/** @jsx React.DOM **/

class InputsProductQuantity extends NecotiendaComponent {

    constructor(props) {
        super(props);

        this.state = {
            field:'quantity'
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