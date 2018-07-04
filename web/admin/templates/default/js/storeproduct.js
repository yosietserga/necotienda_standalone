$(function(){

    /*
    addAttribute
    checkAttribute
    removea\Attribute
     */
    loadFormWidgets();
});

function loadFormWidgets() {
    $('#widgetsFormWrapper').html('<img src="'+ window.imageFolderUrl +'loader.gif" alt="Cargando" />');
    $('#widgetsFormWrapper').load(window.widgetsLoadUrl);
}

function addAttribute(el) {
    var el = el;
    if (typeof el == 'undefined') {
        return;
    }

    var category_id = $(el).val();

    if ($(el).prop('checked')) {
        url = createAdminUrl("store/category/attributes") + '&category_id=' + category_id;
        $.getJSON(url)
        .done(function(resp){
            if (typeof resp.success != 'undefined') {
                $.each(resp.results,function(i,data){
                    var data = data;
                    if ($('#product_attribute_group_id_'+ data.product_attribute_group_id).length == 0) {
                        var divGroup = $(document.createElement('div')).attr({
                            id:'product_attribute_group_id_'+ data.product_attribute_group_id,
                            class:'product_attribute_groups',
                            'data-categories':data.categoriesAttributes.join()
                        }),
                        attribute_group_id = data.product_attribute_group_id;

                        categories = data.categoriesAttributes.join();

                        $(divGroup).append('<input type="hidden" name="categoriesAttributes" value="'+ categories +'" class="categoriesAttributes" />');
                        $(document.createElement('h3')).html(data.title).appendTo(divGroup);

                        $.each(data.items,function(i,item){
                            div = $(document.createElement('div')).addClass('row');
                            input = $(document.createElement('input'));

                            if (item.label) {
                                input.attr('name', 'Attributes['+ attribute_group_id +']['+ item.label +':'+ item.product_attribute_id +']');
                                input.attr('placeholder', item.label);
                                var inputId = 'Attributes_'+ item.label;
                            } else if (item.name) {
                                input.attr('name', 'Attributes['+ attribute_group_id +']['+ item.name +':'+ item.product_attribute_id +']');
                                input.attr('placeholder', item.name);
                                var inputId = 'Attributes_'+ item.name;
                            } else {
                                input.attr('name', 'Attributes['+ attribute_group_id +'][attribute_'+ ($('.attributes:last-child').index() + 1) +']');
                                var inputId = 'Attributes_'+ ($('.attributes:last-child').index() + 1);
                            }

                            input.attr('id', inputId);

                            if (item.type) {
                                input.attr('type', item.type);
                            } else {
                                input.attr('type', 'text');
                            }

                            if (item.value) {
                                input.attr('value', item.value);
                            } else {
                                input.attr('value', '');
                            }

                            if (item.required) {
                                input.attr('required', 'required');
                            }

                            if (item.class) {
                                input.attr('class', item.class);
                            }

                            $(div).append('<label for=\"'+ inputId +'\" class="neco-label">'+ item.label +'</label>');
                            $(div).append(input);

                            $(divGroup).append(div);
                            input.ntInput();
                        });

                        $(divGroup).prepend('<div class=\"clear\"></div>');
                        $(divGroup).append('<div class=\"clear\"></div>');
                        $('#formAttributes').append(divGroup);
                    }
                });
            }
        });
    } else {
        /*
         - check if there is another category that has the same attributes
         - remove attributes of this category
         */
    }
}

function removeAttribute(el) {
    var canDelete = true,
        category_id = $(el).val(),
        categories = {},
        arr = [],
        categoriesSelected = [],
        groupsToDelete = {};

    console.log('get categories group by attribute_group_id');
    $('.product_attribute_groups .categoriesAttributes').each(function(){
        arr = $(this).val().split(',');
        console.log('arr', arr);
        if ($.inArray( category_id, arr ) >= 0) {
            id = $(this).parent('.product_attribute_groups').attr('id');
            categories[id] = $.unique( arr );
        }
    });
    console.log('categories', categories);

    console.log('get product categories selected');
    $('.categories input').each(function(){
        if ($(this).prop('checked')) {
            categoriesSelected.push( $(this).val() );
        }
    });
    console.log('categoriesSelected', categoriesSelected);

    if (categoriesSelected.length == 0) {
        console.log('there is no categories selected, remove all');
        $('.product_attribute_groups').remove();
    } else {
        console.log('determine who is going to be removed');
        $.each(categoriesSelected, function (key, value) {
            $.each(categories, function (attr_group_id, categoryIDs) {
                var index = $.inArray(value, categoryIDs);
                console.log('$.inArray( value, categoryIDs )', index);
                if (index == -1) {
                    groupsToDelete['#' + attr_group_id] = true;
                } else {
                    groupsToDelete['#' + attr_group_id] = false;
                }
            });
        });
        console.log('groupsToDelete', groupsToDelete);

        console.log('remove all attribute groups');
        $.each(groupsToDelete, function (i, item) {
            if (item) $(i).remove();
        });
    }
}