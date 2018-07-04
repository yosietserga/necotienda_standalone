/** @jsx React.DOM **/
class FormsProductAdd extends NecotiendaComponent {
    constructor(props) {
        super(props);

        this._bind('handleCancel');
    }

    handleCancel(e) {
        e.preventDefault();
        this.props.handleCancel();
    }

    render() {
        const { 
            save
        } = this.props;
        

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
            <div className="ibox">

                <div className="ibox-title">
                    <div className="ibox-tools">
                        <a onClick={this.handleCancel} className="btn btn-primary btn-xs">Cancel</a>
                    </div>
                </div>

                <form role="form">
                    <div className="ibox-content col-md-12">

                        <InputsProductModel save={save} />
                        <InputsProductDesrciptions save={save} />
                        <InputsProductPrice save={save} />
                        <InputsProductQuantity save={save} />
                        <InputsProductWidth save={save} />
                        <InputsProductLength save={save} />
                        <InputsProductWeight save={save} />
                        <InputsProductTaxClassId save={save} taxClassId={taxClassId} />
                        <InputsProductStockStatusId save={save} stockStatusId={stockStatusId} />
                        <InputsProductManufacturerId save={save} manufacturerId={manufacturerId} />

                    </div>
                </form>
            </div>
        );
    }
}