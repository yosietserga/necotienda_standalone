/** @jsx React.DOM **/

class InputsCommonText extends NecotiendaComponent {

    constructor(props) {
        super(props);
    }

    render() {
        const { 
            name, 
            className, 
            placeholder,  
            fnSave 
        } = this.props;
        
        return (
            <div className="panel-body">
                <div className="form-group">
                    <input 
                        type="text" 
                        name={name}
                        placeholder={name} 
                        onBlur={fnSave} 
                        className={className}
                    />
                </div>
            </div>
        );
    }
}