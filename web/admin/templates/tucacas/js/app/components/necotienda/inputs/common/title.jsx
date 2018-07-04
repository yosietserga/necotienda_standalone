/** @jsx React.DOM **/

class InputsCommonTitle extends NecotiendaComponent {

    constructor(props) {
        super(props);
    }

    render() {
        const { language, saveDescription } = this.props;
        
        return (
            <div className="form-group">
                <input type="text" 
                    name={'product_description[' + language.get('id') + '][title]'}
                    data-language_id={language.get('id')} 
                    data-field="title"
                    placeholder="Nombre del producto"
                    className="form-control product-description-title"
                    onBlur={saveDescription} />
            </div>
        );
    }
}