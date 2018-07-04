/** @jsx React.DOM **/

class ProductFormImages extends NecotiendaComponent {

    constructor(props) {
        super(props);
        this.state = {
            formHasError: false
        };
    }

    componentDidMount() {
        var self = this;
    }

    componentDidUpdate() {
        var self = this;
    }

    handleCancel(e) {
        e.preventDefault();
        this.props.onBtnCancelClick();
    }

    onDrop(files) {
        console.log('Received files: ', files);
        /*
         - preview de las imagenes subidas
         -
         */
        this.ntUploadFiles(files);
    }

    ntUploadFiles(files) {
        if (typeof files == 'undefined' || files.length == 0 || !window.FileReader) {
            return false;
        }

        var goon = false,
            data = new FormData();

        $.each(files, function (key, file) {
            var html = '',
                size = '';

            goon = true;

            $('.product-images').each(function () {
                if ($(this).data('old-name') == file.name) {
                    goon = false;
                }
            });

            if (file.size > 5000000 && goon) {
                goon = false;
            }

            if ((file.size / 1024) > 1000) {
                size = Math.round(file.size / 1024 / 1024) + ' MB';
            } else {
                size = Math.round(file.size / 1024) + ' KB';
            }

            if (goon) {
                goon = false;
                var ext = (file.name.substring(file.name.lastIndexOf("."))).toLowerCase();
                var allowed = [
                    ".gif",
                    ".jpg",
                    ".png",
                    ".doc",
                    ".docx",
                    ".xls",
                    ".xlsx",
                    ".txt",
                    ".csv",
                    ".swf",
                    ".flv",
                    ".mp3",
                    ".pdf"
                ];

                for (var i = 0; i < allowed.length; i++) {
                    if (allowed[i] == ext) {
                        goon = true;
                        break;
                    }
                }
            }

            if (goon) {
                goon = false;
                allowed = [
                    'image/jpg',
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/x-png',
                    'image/gif',
                    "text/csv",
                    "text/comma-separated-values",
                    "text/tab-separated-values",
                    "text/plain",
                    'application/x-shockwave-flash',
                    'application/msword',
                    'application/pdf',
                    'application/x-pdf',
                    'application/msexcel',
                    'audio/x-mpeg'
                ];

                for (var i = 0; i < allowed.length; i++) {
                    if (allowed[i] == file.type.toLowerCase()) {
                        goon = true;
                        break;
                    }
                }
            }

            if (goon) {
                html += '<div class="file-box" id="' + md5(file.name) + '">';
                html += '<div class="file">';
                html += '<div class="image">';
                html += '<img className="img-responsive product-images" id="fileuploaded_' + key + '" alt="' + file.name + '" width="150" data-old-name="' + file.name + '" data-name="' + file.name + '" />';
                html += '</div>';
                html += '<div class="file-name">';
                html += '<p style="text-align:center">';
                html += '<a data-id="" data-old-name="' + file.name + '" data-name="' + file.name + '"><i class="fa fa-check-circle fa-2x"></i></a>';
                html += '&nbsp;&nbsp;&nbsp;&nbsp;';
                html += '<a data-id="" data-old-name="' + file.name + '" data-name="' + file.name + '" data-toggle="modal" data-target="#fileManagerModal"><i class="fa fa-folder-open fa-2x"></i></a>';
                html += '&nbsp;&nbsp;&nbsp;&nbsp;';
                html += '<a data-id="" data-old-name="' + file.name + '" data-name="' + file.name + '"><i class="fa fa-search-plus fa-2x"></i></a>';
                html += '&nbsp;&nbsp;&nbsp;&nbsp;';
                html += '<a data-id="" data-old-name="' + file.name + '" data-name="' + file.name + '"><i class="fa fa-close fa-2x"></i></a>';
                html += '</p>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#filesSelected').append(html);

                if (file.type.toLowerCase() === 'text/csv' || file.type.toLowerCase() === 'text/comma-separated-values' || file.type.toLowerCase() === 'text/tab-separated-values') {
                    $('#fileuploaded_' + index).attr('src', '/image/icons/csv.png');
                } else if (file.type.toLowerCase() === 'text/plain') {
                    $('#fileuploaded_' + index).attr('src', '/image/icons/txt.png');
                } else if (file.type.toLowerCase() === 'application/x-shockwave-flash') {
                    $('#fileuploaded_' + index).attr('src', '/image/icons/_blank.png');
                } else if (file.type.toLowerCase() === 'application/msword') {
                    $('#fileuploaded_' + index).attr('src', '/image/icons/doc.png');
                } else if (file.type.toLowerCase() === 'application/pdf' || file.type.toLowerCase() === 'application/x-pdf') {
                    $('#fileuploaded_' + index).attr('src', '/image/icons/pdf.png');
                } else if (file.type.toLowerCase() === 'application/msexcel') {
                    $('#fileuploaded_' + index).attr('src', '/image/icons/xls.png');
                } else if (file.type.toLowerCase() === 'audio/x-mpeg') {
                    $('#fileuploaded_' + index).attr('src', '/image/icons/_blank.png');
                } else {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        $('#fileuploaded_' + key).attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }

                data.append(key, file);
            }
        });

        if (goon) {
            $.ajax({
                url: App.Route.CreateAdminUrl('content/file/uploader', {
                    product_id: this.props.modelProduct.getId()
                }),
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = $.ajaxSettings.xhr();

                    xhr.upload.onprogress = function (e) {
                        var percent = e.loaded / e.total * 100;
                        $('#uploadProgressBar div').css('width', percent + '%');
                    };

                    xhr.upload.onload = function () {
                        $('#uploadProgressBar div')
                            .css('width', '100%')
                            .delay(1000)
                            .css('width', '0%')
                            .delay(500)
                            .hide();
                    };

                    return xhr;
                }
            }).done(function (data) {
                if (data.error) {
                    console.log('ERRORS: ' + data.error);
                } else {

                }
            });
        }
    }

    render() {
        return (
            <div>
                <Dropzone onDrop={this.onDrop}>
                    <div>Try dropping some files here, or click to select files to upload.</div>
                </Dropzone>

                <div id="uploadProgressBar" className="progress progress-small">
                    <div style={{width: '0%'}} className="progress-bar"></div>
                </div>

                <div id="filesSelected"></div>

                <FileManagerModal />
            </div>
        );
    }
}