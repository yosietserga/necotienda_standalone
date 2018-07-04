/** @jsx React.DOM **/

class InputsProductManufacturerId extends NecotiendaComponent {

    constructor(props) {
        super(props);

        this.state = {
            manufacturers: App.Utils.Immutable.List(),
            manufacturerId: props.manufacturerId,
            field:'manufacture_id'
        };

        this._bind('save');
        /* //TODO: number fomatter */
    }

    componentDidMount() {
        this._list();
    }

    _list() {
        if (App.Data.get('manufacturers') !== App.Data.get('list:manufacturers') || !App.Data.get('list:manufacturers')) {
            fetch(App.Route.CreateAdminUrl('api/v1/manufacturers'), {
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

                    App.Data.set('manufacturers', results);
                    App.Data.set('list:manufacturers', results);

                    this.setState({
                        manufacturers: results
                    });
                });
        } else {
            /* cached languages */
            this.setState({
                manufacturers: App.Data.get('list:manufacturers')
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
            manufacturers, 
            manufacturerId 
        } = this.state;

        if (manufacturers) {
            var _manufacturers = manufacturers.map(function (item) {
                var selected = (manufacturerId==item.get('id')) ? 1 : 0;
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
                options={_manufacturers}
            />
        );
    }
}