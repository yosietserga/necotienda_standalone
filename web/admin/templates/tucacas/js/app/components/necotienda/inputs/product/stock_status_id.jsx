/** @jsx React.DOM **/

class InputsProductStockStatusId extends NecotiendaComponent {

    constructor(props) {
        super(props);

        this.state = {
            stockStatuses: App.Utils.Immutable.List(),
            stockStatusId: props.stockStatusId,
            field:'stock_status_id'
        };

        this._bind('save');
        /* //TODO: number fomatter */
    }

    componentDidMount() {
        this._list();
    }

    _list() {
        if (App.Data.get('stockStatuses') !== App.Data.get('list:stockStatuses') || !App.Data.get('list:stockStatuses')) {
            fetch(App.Route.CreateAdminUrl('api/v1/stock_statuses'), {
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

                    App.Data.set('stockStatuses', results);
                    App.Data.set('list:stockStatuses', results);

                    this.setState({
                        stockStatuses: results
                    });
                });
        } else {
            /* cached languages */
            this.setState({
                stockStatuses: App.Data.get('list:stockStatuses')
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
            stockStatuses, 
            stockStatusId 
        } = this.state;

        if (stockStatuses) {
            var statuses = stockStatuses.map(function (item) {
                var selected = (stockStatusId==item.get('id')) ? 1 : 0;
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
                options={statuses}
            />
        );
    }
}