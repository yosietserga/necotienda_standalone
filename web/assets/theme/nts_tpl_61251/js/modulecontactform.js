function animateForm(el) {
    $(el).hide();

    $(document.createElement('div')).attr({
        id:el +'_temp',
        class:'loader'
    })
        .append('<img src="'+ window.nt.http_image +'loader.gif" alt="Loading..." />')
        .appendTo($(el).parent());
}

function processForm(el, wname) {
    var el = el;
    var f = $(el);
    $.post(
        createUrl('module/contact_form/processform', {
            async:1,
            name:wname,
        }),
        {
            name:$(el +' input[name=name]').val(),
            email:$(el +' input[name=email]').val(),
            enquiry:$(el +' textarea[name=enquiry]').val()
        })
        .done(function(resp){
            $(el +'_temp').remove();
            f.show();

            var data = $.parseJSON(resp);
            $(el +' .msg').remove();

            if (data.error) {
                $(el).prepend('<div class="msg error">'+ data.msg +'</div>');
            } else {
                $(el).prepend('<div class="msg success">'+ data.msg +'</div>');
                $(el +' input[name=name]').val('');
                $(el +' input[name=email]').val('');
                $(el +' textarea[name=enquiry]').val('');
            }
        }
    );
}