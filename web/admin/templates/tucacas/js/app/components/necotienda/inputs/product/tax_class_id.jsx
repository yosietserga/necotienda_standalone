/** @jsx React.DOM **/

class InputsProductTaxClassId extends NecotiendaComponent {

    constructor(props) {
        super(props);

        this.state = {
            taxClasses: App.Utils.Immutable.List(),
            taxClassId: props.taxClassId,
            field:'tax_class_id'
        };

        this._bind('save');
        /* //TODO: number fomatter */
    }

    componentDidMount() {
        this._list();
    }

    _list() {
        if (App.Data.get('taxClasses') !== App.Data.get('list:taxClasses') || !App.Data.get('list:taxClasses')) {
            fetch(App.Route.CreateAdminUrl('api/v1/tax_classes'), {
                credentials: 'same-origin'
            })
                .then(resp => {
                    return resp.json().catch(error => {
                        console.log('ERROR', error);
                        return 'Invalid JSON: ' + error.message;
                    });
                })
                .then(data => {
                    var results = App.Utils.Immutable.fromJS(data.payload.results);

                    App.Data.set('taxClasses', results);
                    App.Data.set('list:taxClasses', results);

                    this.setState({
                        taxClasses: results
                    });
                });
        } else {
            /* cached languages */
            this.setState({
                taxClasses: App.Data.get('list:taxClasses')
            });
        }
    }

    save(e) {
        e.preventDefault();
        const { field } = this.state;
        var data = {};
        data[field] = e.target.value;
        this.props.save( data );
    }

    render() {
        const { 
            field, 
            taxClasses, 
            taxClassId 
        } = this.state;

        if (taxClasses) {
            var classes = taxClasses.map(function (item) {
                var selected = (taxClassId==item.get('id')) ? 1 : 0;
                return (
                    <option value={item.get('id')} selected={selected}>{item.get('name')}</option>
                );
            });
        }

        return (
            <InputsCommonSelect 
                name={field} 
                placeholder={field} 
                className="" 
                onChange={this.save} 
                options={classes}
            />
        );
    }
}