/** @jsx React.DOM **/

class InputsCommonSelect extends NecotiendaComponent {

    constructor(props) {
        super(props);
    }

    render() {
        const { 
            name, 
            className, 
            placeholder,  
            options,  
            fnSave 
        } = this.props;
        
        return (
            <div className="panel-body">
                <div className="form-group">
                    <label>{placeholder}</label>
                    <select 
                        name={name} 
                        onChange={fnSave} 
                        className={className}
                    >
                        <option>Select an option</option>
                        {options}
                    </select>
                </div>
            </div>
        );
    }
}