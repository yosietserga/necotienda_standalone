/** @jsx React.DOM **/

/*
                    $items[$l] = array(
                        'shipping' => $result['shipping'],
                        'date_available' => $result['date_available'],
                        'weight_class' => $result['wctitle'],
                        'length_class' => $result['lctitle'],
                        'subtract' => $result['subtract'],
                        'minimum' => $result['minimum'],
                        'image' => $image,
                        'quantity' => $result['quantity'],
                        'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'))
                    );
                    */
class ProductFormMain extends NecotiendaComponent {
    constructor(props) {
        super(props);

        this._bind('handleCancel');
    }

    save(data) {
        var type = 'post',
            postData = {},
            product = {},
            uriData = {},
            method = 'POST',
            toSave = false,
            self = this;

        product = App.Data.get('product');
        if (product) {
            uriData = {
                id:product.get('id')
            };
            method = 'PUT';
        }

        postData = data;

        fetch(App.Route.CreateAdminUrl('api/v1/products', uriData),
        {
            body: JSON.stringify(postData),
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
              'user-agent': 'Mozilla/4.0 MDN Example',
              'content-type': 'application/json'
            },
            method: method,
        })
        .then(resp => {
            return resp.json().catch(error => {
                console.log('ERROR', error);
                return 'Invalid JSON: ' + error.message;
            });
        })
        .then(data => {
            if (typeof data.payload == 'undefined') {
                /* some error messages */
            } else {
                data.payload = Object.assign({}, data.payload, postData);
                var result = App.Utils.Immutable.fromJS(data.payload);

                product = App.Data.get('product');

                if (product) {
                    product.mergeDeep(result);
                } else {
                    product = result;
                }

                if (product.get('id') != 0) {
                    App.Data.set('product', product);
                }
            }
        });
    }

    handleCancel() {
        this.props.onBtnCancelClick('ProductListMain');
    }

    render() {
        /* //TODO: load product if ID is set in the url */
        var modelProduct = {
            stockStatusId:0,
            taxClassId:0,
            manufacturerId:0,
        };

        const { 
            stockStatusId,
            taxClassId,
            manufacturerId
        } = modelProduct;
        
        return (
            <FormsProductAdd 
                saveProduct={this.save} 
                handleCancel={this.handleCancel} 
            />
        );
    }
}