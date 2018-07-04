/** @jsx React.DOM **/

class ProductFormDesrciption extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this.state = {
            formHasError: false
        };
        this._bind('saveModel');
        this._bind('saveDescription');

    }

    componentDidUpdate() {
        var self = this;
        $('.summernote').summernote({
            onChange: function (contents, $editable) {
                let language_id = contents.context.getAttribute('data-language_id');
                self.__saveDescription(language_id, 'description', $editable);
            }
        });
    }

    handleCancel(e) {
        e.preventDefault();
        this.props.onBtnCancelClick();
    }

    __saveDescription(language_id, field, value) {
        if (typeof language_id == 'undefined' || typeof field == 'undefined' || typeof value == 'undefined') {
            return false;
        }

        var descriptions = {};
        descriptions[language_id] = {};

        descriptions[language_id]['language_id'] = language_id;
        descriptions[language_id][field] = value;

        this.props.saveProduct({
            descriptions:descriptions
        });
    }

    saveDescription(e) {
        e.preventDefault();
        this.__saveDescription(e.target.getAttribute('data-language_id'), e.target.getAttribute('data-field'), e.target.value);
    }

    saveModel(e) {
        e.preventDefault();
        this.props.saveProduct({
            model: e.target.value
        });
    }

    render() {
        const { languages } = this.props;
        
        let languageTabs = [];
        let languageInputs = [];
        let self = this;

        if (typeof languages != 'undefined') {
            var tabActive = true;
            languageTabs = languages.map(function (item) {
                var cssClass = (tabActive) ? 'active' : '';
                tabActive = false;
                return (
                    <li className={cssClass}>
                        <a data-toggle="tab" href={'#tab_lang_' + item.get('id')}>
                            <img src={window.nt.http_image + 'flags/' + item.get('image')} alt={item.get('code')}/>
                        </a>
                    </li>
                );
            });

            var tabActive = true;
            languageInputs = languages.map(function (item) {
                var cssClass = (tabActive) ? 'tab-pane active' : 'tab-pane';
                tabActive = false;
                return (
                    <div id={'tab_lang_' + item.get('id')} className={cssClass}>
                        <div className="form-group">
                            <input type="text" name={'product_description[' + item.get('id') + '][title]'}
                                   data-language_id={item.get('id')} 
                                   data-field="title"
                                   placeholder="Nombre del producto"
                                   className="form-control product-description-title"
                                   onBlur={self.saveDescription}/>
                        </div>

                        <div className="form-group">
                            <input type="text" name={'descriptions[' + item.get('id') + '][tags]'}
                                   data-language_id={item.get('id')} placeholder="Etiquetas del producto"
                                   className="form-control product-description-inputs" onChange={self.setKeywords}
                                   onBlur={self.saveKeywords}/>
                            <select data-placeholder="Etiquetas del producto" className="chosen-select" multiple
                                    tabindex="4">
                                <option value="">Select</option>
                                <option value="United States">United States</option>
                                <option selected value="United Kingdom">United Kingdom</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Aland Islands">Aland Islands</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                            </select>
                        </div>

                        <div className="form-group">

                            <div id={'description_' + item.get('id')} data-language_id={item.get('id')} className="summernote">
                                <h3>Lorem Ipsum is simply</h3>
                                dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the
                                industry's</strong> standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                It has survived not only five centuries, but also the leap into electronic
                                typesetting, remaining essentially unchanged. It was popularised in the 1960s with the
                                release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                                <br/>
                                <br/>
                                <ul>
                                    <li>Remaining essentially unchanged</li>
                                    <li>Make a type specimen book</li>
                                    <li>Unknown printer</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                );
            });
        }

        return (
            <div className="col-lg-8">
                <div className="ibox float-e-margins">
                    <div className="ibox-content" style={{borderTop: 'none'}}>
                        <div className="row">
                            <div className="col-sm-12">
                                <div className="panel blank-panel">
                                    <div className="panel-heading">
                                        <div className="panel-title m-b-md"><h4>Blank Panel with text tabs</h4></div>

                                        <div className="panel-options">
                                            <ul className="nav nav-tabs">
                                                {languageTabs}
                                            </ul>
                                        </div>
                                    </div>

                                    <div className="panel-body">
                                        <div className="form-group">
                                            <input type="text" name="model" ref="productInputModel"
                                                   placeholder="Product model" 
                                                   onBlur={this.saveModel} className="form-control product-input"/>
                                        </div>
                                        <div className="tab-content">
                                            {languageInputs}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}