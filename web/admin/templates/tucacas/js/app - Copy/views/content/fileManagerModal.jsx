/** @jsx React.DOM **/

class FileManagerModal extends NecotiendaComponent {

    constructor() {
        super();
        this.state = {
            formHasError: false
        }
    }

    componentDidMount() {
        var self = this;
    }

    componentDidUpdate() {
        var self = this;
    }

    handleCancel(e) {
        e.preventDefault();
    }

    handleSubmit(e) {
        e.preventDefault();
        $('.file-name').each(function () {
            if (this.refs.searchInput.value.toLowerCase() !== $(this).data('name').toLowerCase()) {
                $(this).hide();
            } else {
                $(this).show();
            }
            console.log(this);
        });
    }

    render() {
        return (
            <div>
                <div className="modal inmodal fade" id="fileManagerModal" tabindex="-1" role="dialog"
                     aria-hidden="true">
                    <div className="modal-dialog modal-lg" style={{width: '90%'}}>
                        <div className="modal-content">

                            <div className="modal-header">
                                <button type="button" className="close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span><span className="sr-only">Close</span></button>
                                <h4 className="modal-title">File Manager</h4>

                                <div className="row m-b-sm m-t-sm">
                                    <form id="searchFiles" onSubmit={this.handleSubmit}>
                                        <div className="col-md-12">
                                            <div className="input-group">

                                                <input className="input-sm form-control" type="text" id="searchFile"
                                                       onBlur={this.handleSubmit} ref="searchFileInput" name="search"
                                                       placeholder="search..."/>

                                                <span className="input-group-btn">
                                                        <button type="button"
                                                                className="btn btn-sm btn-primary"> Go!</button>
                                                    </span>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div className="modal-body">
                                <div className="wrapper wrapper-content">
                                    <div className="row">
                                        <div className="col-lg-3">
                                            <div className="ibox float-e-margins">
                                                <div className="ibox-content">

                                                    <div className="file-manager">
                                                        <h5>Folders</h5>
                                                        <ul className="folder-list" style={{padding: 0}}>
                                                            <li><a href=""><i className="fa fa-folder"></i> Files</a>
                                                            </li>
                                                            <li><a href=""><i className="fa fa-folder"></i> Pictures</a>
                                                            </li>
                                                            <li><a href=""><i className="fa fa-folder"></i> Web
                                                                pages</a></li>
                                                            <li><a href=""><i className="fa fa-folder"></i>
                                                                Illustrations</a></li>
                                                            <li><a href=""><i className="fa fa-folder"></i> Films</a>
                                                            </li>
                                                            <li><a href=""><i className="fa fa-folder"></i> Books</a>
                                                            </li>
                                                        </ul>
                                                        <div className="clearfix"></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div className="col-lg-9 animated fadeInRight">
                                            <div className="row">
                                                <div className="col-lg-12">

                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="fa fa-file"></i>
                                                                </div>
                                                                <div className="file-name"
                                                                     data-name="Document_2014.doc">
                                                                    Document_2014.doc
                                                                    <br/>
                                                                    <small>Added: Jan 11, 2014</small>
                                                                    <br />

                                                                    <p style={{textAlign: 'center'}}>
                                                                        <a data-id="" data-old-name="" data-name=""
                                                                           style={{
                                                                               width: '20%',
                                                                               display: 'block',
                                                                               float: 'left'
                                                                           }}><i
                                                                            className="fa fa-check-circle fa-2x"></i></a>
                                                                        <a data-id="" data-old-name="" data-name=""
                                                                           style={{
                                                                               width: '20%',
                                                                               display: 'block',
                                                                               float: 'left'
                                                                           }}><i
                                                                            className="fa fa-search-plus fa-2x"></i></a>
                                                                        <a data-id="" data-old-name="" data-name=""
                                                                           style={{
                                                                               width: '20%',
                                                                               display: 'block',
                                                                               float: 'left'
                                                                           }}><i className="fa fa-close fa-2x"></i></a>
                                                                    </p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="image">
                                                                    <img alt="image" className="img-responsive"
                                                                         src="img/p1.jpg"/>
                                                                </div>
                                                                <div className="file-name">
                                                                    Italy street.jpg
                                                                    <br />
                                                                    <small>Added: Jan 6, 2014</small>
                                                                </div>
                                                            </a>

                                                        </div>
                                                    </div>

                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="image">
                                                                    <img alt="image" className="img-responsive"
                                                                         src="img/p2.jpg"/>
                                                                </div>
                                                                <div className="file-name">
                                                                    My feel.png
                                                                    <br/>
                                                                    <small>Added: Jan 7, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="fa fa-music"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Michal Jackson.mp3
                                                                    <br/>
                                                                    <small>Added: Jan 22, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="image">
                                                                    <img alt="image" className="img-responsive"
                                                                         src="img/p3.jpg"/>
                                                                </div>
                                                                <div className="file-name">
                                                                    Document_2014.doc
                                                                    <br/>
                                                                    <small>Added: Fab 11, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="img-responsive fa fa-film"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Monica's birthday.mpg4
                                                                    <br/>
                                                                    <small>Added: Fab 18, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <a href="#">
                                                            <div className="file">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="fa fa-bar-chart-o"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Annual report 2014.xls
                                                                    <br/>
                                                                    <small>Added: Fab 22, 2014</small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="fa fa-file"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Document_2014.doc
                                                                    <br/>
                                                                    <small>Added: Jan 11, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="image">
                                                                    <img alt="image" className="img-responsive"
                                                                         src="img/p1.jpg"/>
                                                                </div>
                                                                <div className="file-name">
                                                                    Italy street.jpg
                                                                    <br/>
                                                                    <small>Added: Jan 6, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="image">
                                                                    <img alt="image" className="img-responsive"
                                                                         src="img/p2.jpg"/>
                                                                </div>
                                                                <div className="file-name">
                                                                    My feel.png
                                                                    <br/>
                                                                    <small>Added: Jan 7, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="fa fa-music"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Michal Jackson.mp3
                                                                    <br/>
                                                                    <small>Added: Jan 22, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="image">
                                                                    <img alt="image" className="img-responsive"
                                                                         src="img/p3.jpg"/>
                                                                </div>
                                                                <div className="file-name">
                                                                    Document_2014.doc
                                                                    <br/>
                                                                    <small>Added: Fab 11, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="img-responsive fa fa-film"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Monica's birthday.mpg4
                                                                    <br/>
                                                                    <small>Added: Fab 18, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <a href="#">
                                                            <div className="file">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="fa fa-bar-chart-o"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Annual report 2014.xls
                                                                    <br/>
                                                                    <small>Added: Fab 22, 2014</small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="fa fa-file"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Document_2014.doc
                                                                    <br/>
                                                                    <small>Added: Jan 11, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="image">
                                                                    <img alt="image" className="img-responsive"
                                                                         src="img/p1.jpg"/>
                                                                </div>
                                                                <div className="file-name">
                                                                    Italy street.jpg
                                                                    <br/>
                                                                    <small>Added: Jan 6, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="image">
                                                                    <img alt="image" className="img-responsive"
                                                                         src="img/p2.jpg"/>
                                                                </div>
                                                                <div className="file-name">
                                                                    My feel.png
                                                                    <br/>
                                                                    <small>Added: Jan 7, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="fa fa-music"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Michal Jackson.mp3
                                                                    <br/>
                                                                    <small>Added: Jan 22, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="image">
                                                                    <img alt="image" className="img-responsive"
                                                                         src="img/p3.jpg"/>
                                                                </div>
                                                                <div className="file-name">
                                                                    Document_2014.doc
                                                                    <br/>
                                                                    <small>Added: Fab 11, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <div className="file">
                                                            <a href="#">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="img-responsive fa fa-film"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Monica's birthday.mpg4
                                                                    <br/>
                                                                    <small>Added: Fab 18, 2014</small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div className="file-box">
                                                        <a href="#">
                                                            <div className="file">
                                                                <span className="corner"></span>

                                                                <div className="icon">
                                                                    <i className="fa fa-bar-chart-o"></i>
                                                                </div>
                                                                <div className="file-name">
                                                                    Annual report 2014.xls
                                                                    <br/>
                                                                    <small>Added: Fab 22, 2014</small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
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