/**
 * NecoForm
 * Author: Yosiet Serga
 * Version: 1.0.1
 * 
 * Dual licensed under the MIT and GPL licenses
 * 
 */
(function($) {
    $.fn.ntForm = function(method) {
        var defaults = {
            url:     '',
            enctype:    'multipart/form-data',
            ajax:       false,
            type:       'post',
            dataType:   'json',
            classname:  'neco-form',
            lockButton: true,
            submitButton: true,
            cancelButton: true,
            loading:    {
                title:'Cargando...',
                image:'../loader.gif',
                classname:'neco-form-loading'
            },
            error:      {
                classname:'neco-form-error',
                text:'Lo sentimos pero no se pudo procesar el formulario',
            },
            options:    {},
            create:     function(){},
            beforeSend: function(){},
            complete:   function(){},
            success:    function(){},
            submit: function(){}
        }
        
        var settings = {};
        var data = {};
        var methods = {
            init : function(options) {
                return this.each(function() {
                    settings = $.extend({}, defaults, options);
                    data.element = $(this);
                    helpers._create();
                    data.container = data.element.find('.' + settings.classname);
                    
                });
            }
        }
 
        var helpers = {
            _create: function() {                
                var formCounter = 0;
                if (data.element.length == 0) { //all forms in the document
                    data.element = $('body');
                    $(data.element).find('form').each(function() {
                        $(this).attr('id','neco-form-' + formCounter).addClass('neco-form');
                        formCounter = formCounter + 1 * 1;
                        
                        $(data.element).find('input').each(function() {
                            $(this).ntInput($(this).attr('type'));
                        });
                        
                        $(data.element).find('select').each(function() {
                            $(this).ntSelect();
                        });
                        
                        $(data.element).find('textarea').each(function() {
                            $(this).ntTextArea();
                        });
                    });
                } 
                if (data.element.length > 0 && $(data.element).get(0).tagName != 'FORM') { //all forms inside the tag dom
                    if ($(data.element).find('form')) {
                        $(data.element).find('form').each(function() {
                            $(this).attr('id','neco-form-' + formCounter).addClass('neco-form');
                            formCounter = formCounter + 1 * 1;
                            
                            $(data.element).find('input').each(function() {
                                $(this).ntInput($(this).attr('type'));
                            });
                            
                            $(data.element).find('select').each(function() {
                                $(this).ntSelect();
                            });
                            
                            $(data.element).find('textarea').each(function() {
                                $(this).ntTextArea();
                            });
                        });
                    }
                } 
                if ($(data.element).get(0).tagName == 'FORM') { //is a form, so let´s get it
                    $(data.element).addClass('neco-form').attr({
                        action:settings.url,
                        method:settings.type,
                        enctype:settings.enctype,
                        name:'neco-form-' + formCounter
                    });
                    $(data.element).find('input').each(function() {
                        if (settings.map) {
                            
                        } else {
                            
                        }
                        $(this).ntInput();
                    });
                }
                
                $(data.element).find('label').each(function() {
                    $(this).addClass('neco-label');
                });
                
                submitButton = $(document.createElement('a')).addClass('button').text('Aceptar').attr({
                    title:'Al hacer click en este bot\u00F3n, usted est\u00E1 aceptando todas las condiciones y t\u00E9rminos de uso de este sitio web'
                }).css({'display':'none'}).appendTo(data.element);
                
                cancelButton = $(document.createElement('a')).addClass('button').text('Cancelar').attr({
                    title:'Al hacer click en este bot\u00F3n, usted est\u00E1 aceptando todas las condiciones y t\u00E9rminos de uso de este sitio web'
                }).css({'display':'none'}).appendTo(data.element);
                
                $(cancelButton).on('click',function(e){
                   $(data.element).find('input').each(function(){
                        $(this).val('').removeClass('neco-input-error').removeClass('neco-input-success');
                        $("#tempError").remove();
                   }); 
                });
                
                if (settings.lockButton) {
                    unlockButton = $(document.createElement('div')).attr({
                       id:'neco-unlock-form' 
                    }).html('<div id="slide-to-unlock"></div><div id="neco-unlock-slider-wrapper"><div id="neco-unlock-slider"><div class="ui-slider-handle"></div></div></div>').appendTo(data.element);
                    
                    $("#neco-unlock-slider").slider({
                		animate:true,
                		slide: function(e,ui) {
                			$("#slide-to-unlock").css("opacity", 1-(parseInt($(ui.handle).css("left"))/120));
                		},
                        stop:function(e,ui) {
                            left = Math.round($(ui.handle).position().left);
                			if(left > 200) {
                				 $(unlockButton).fadeOut(function(data){
         				             $(unlockButton).remove();
                        			 $(submitButton).fadeIn();
                        			 $(cancelButton).fadeIn();
                				 });
                			} else {
                			     $(ui.handle).animate({left: 0}, 200 );
    				            $("#slide-to-unlock").animate({opacity: 1}, 200 );
                			}
                        }
              		});
                } else {
                    if (settings.submitButton) $(submitButton).fadeIn();
                    if (settings.cancelButton) $(cancelButton).fadeIn();
                }
                $(submitButton).on('click',function(e){
                    var msg;
                    var error = false;
                    var top, input;
                    $(data.element).find('input').each(function(){
                        var value = !!$(this).val();
                        var required = $(this).attr('required');
                        var type = $(this).attr('type');
                        var top = $(this).offset().top;
                        
                        if (type=='email' && $(this).val()=='@') {
                            error = true;
                            $("#tempError").remove();
                            msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('Debes ingresar una direcci\u00F3n de email v\u00E1lida');
                            if ($(this).hasClass('neco-input-success')) { $(this).removeClass('neco-input-success') }
                            $(this).addClass('neco-input-error').parent().find('.neco-form-error').attr({'title':'Debes ingresar una direcci\u00F3n de email v\u00E1lida'});
                        }
                        
                        if (type=='fullname' && $(this).val()=='Ingresa tu nombre completo') {
                            error = true;
                            $("#tempError").remove();
                            msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('Debes ingresar tu nombre completo');
                            if ($(this).hasClass('neco-input-success')) { $(this).removeClass('neco-input-success') }
                            $(this).addClass('neco-input-error').parent().find('.neco-form-error').attr({'title':'Debes ingresar tu nombre completo'});
                        }
                        
                        if (type=='firstname' && $(this).val()=='Ingrese sus nombres') {
                            error = true;
                            $("#tempError").remove();
                            msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('Debes ingresar tus nombres');
                            if ($(this).hasClass('neco-input-success')) { $(this).removeClass('neco-input-success') }
                            $(this).addClass('neco-input-error').parent().find('.neco-form-error').attr({'title':'Debes ingresar tus nombres'});
                        }
                        
                        if (type=='lastname' && $(this).val()=='Ingrese sus apellidos') {
                            error = true;
                            $("#tempError").remove();
                            msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('Debes ingresar tus apellidos');
                            if ($(this).hasClass('neco-input-success')) { $(this).removeClass('neco-input-success') }
                            $(this).addClass('neco-input-error').parent().find('.neco-form-error').attr({'title':'Debes ingresar tus apellidos'});
                        }
                        
                        if (!value && required && !error) {
                            error = true;
                            $("#tempError").remove();
                            msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('Debes rellenar todos los campos obligatorios identificados con asterisco (*)');
                            if ($(this).hasClass('neco-input-success')) { $(this).removeClass('neco-input-success'); }
                            $(this).addClass('neco-input-error').parent().find('.neco-form-error').attr({'title':'Debes rellenar este campo con la informaci\u00F3n correspondiente'});
                        }
                        
                        var pattern = new RegExp(/.["\\\/\{\}\[\]\+']/i);
                        if (pattern.test($(this).val()) && !error && $(this).attr('type') != 'password' && $(this).attr('type') != 'hidden' && $(this).attr('type') != 'date') {
                            error = true;
                            $("#tempError").remove();
                            msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('No se permiten ninguno de estos caracteres especiales ["#$/\'+}{\u003C\u003E] en este formulario');
                            if ($(this).hasClass('neco-input-success')) { $(this).removeClass('neco-input-success'); }
                            $(this).addClass('neco-input-error').parent().find('.neco-form-error').attr({'title':'No se permiten ninguno de estos caracteres especiales ["#$&/?\'+}{\u003C\u003E] en este campo'});
                            top = $(this).offset().top;
                        }
                        
                        if ($(this).hasClass('neco-input-error') && !error) {
                            error = true;
                            $("#tempError").remove();
                            msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('Hay errores en el formulario, por favor revise y corr\u00EDjalos todos para poder continuar');
                        }
                        if (error) return false;
                    });
                    
                    if (error) {
                        $(this).before(msg);
                        $('html, body').animate({scrollTop:top}, 'slow');
                    } else {
                        error = false;
                        if (settings.ajax) {
                            $.ajax({
                               type:settings.type,
                               dataType:settings.dataType,
                               data:$(data.element).serialize(),
                               url:settings.url,
                               beforeSend:helpers._beforeSend(),
                               complete:helpers._complete(),
                               success:function(data) {helpers._success(data)}
                            });
                        } else {
                            $(data.element).submit();
                        }
                    }
                });
                
                if (typeof settings.create == 'function') {
                    settings.create();
                }
            },
            _beforeSend: function() {
                if (typeof settings.beforeSend == "function") {
                    settings.beforeSend();
                }
            },
            _complete: function() {
                if (typeof settings.complete == "function") {
                    settings.complete();
                }
            },
            _success: function(data) {
                if (typeof settings.success == "function") {
                    settings.success(data);
                }
            },
            _submit: function() {
                if (typeof settings.mouseleave == "function") {
                    settings.mouseleave(this,data.li);
                }
            }
        }
        
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error( 'Method "' +  method + '" does not exist in ntForm plugin!');
        }
    }
})(jQuery);

/**
 * NecoInput
 * Author: Yosiet Serga
 * Version: 1.0.1
 * 
 * Dual licensed under the MIT and GPL licenses
 * 
 */
(function($) {
    $.fn.ntInput = function(method) {
        var defaults = {
            error:      false,
            message:    false,
            pattern:     '',
            format:     '',
            thousands:  '.',
            decimals:   ',',
            showQuick:   true,
            focus:      function(){},
            blur:       function(){},
            keydown:    function(){},
            change:     function(){},
            options:    {},
            loading:    {
                title:'Comprobando...',
                image:'../loader.gif',
                classname:'neco-input-loading'
            }
        }
        
        var settings = {};
        var data = {};
        var methods = {
            init : function(options) {
                return this.each(function() {
                    settings = $.extend({}, defaults, options);
                    data.element = $(this);
                    helpers._create();
                    helpers._focus();
                    helpers._blur();
                    helpers._keydown();
                    helpers._change();
                });
            }
        }
 
        var helpers = {
            _create: function() {
                data.type = $(data.element).attr('type');
                if (data.type=='hidden') return;
                $(data.element).addClass('neco-input-' + data.type); // add class to the form field
                $('*', data.element).change(helpers._change);
                $('*', data.element).keydown(helpers._keydown);
                
                if (data.type == 'text') {
                    data.element.on('change',function(event){
                        if (settings.pattern.length > 0) {
                            data.error = helpers.checkPattern();
                        }
                        if (data.error) {
                            helpers.showError();
                        } else {
                            helpers.showSuccess();
                        }
                    });
                }
                
                if (data.type == 'rif') {
                    settings.pattern = /\b[JGVE]-[0-9]{8}-[0-9]{1}\b/i;
                    settings.help = "Por favor ingrese su numero de cedula, RIF Natural o RIF de su empresa";
                    settings.tip = "Si eres una persona y no posees RIF, ingresa tu número de cédula con un cero (0) al final";
                    $(data.element).mask("a-99999999-9",{placeholder:" "});
                    data.element.on('change',function(event){
                        data.error = helpers.checkPattern();
                        
                        if (!data.error) {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"Debes ingresar un n\u00FAmero de C\u00E9dula o RIF v\u00E1lido para poder continuar"});
                            helpers.showError();
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                    $(data.element).on('change',function(e){
                        $(this).val(this.value.charAt(0).toUpperCase() + this.value.slice(1));
                    });
                }
                
                if (data.type == 'fullname') {
                    settings.pattern = /^\D+$/i;
                    settings.help = "Por favor ingrese su nombre completo";
                    if ($(data.element).val().length==0) {
                        $(data.element).val('Ingresa tu nombre completo').focus(function(e){
                           $(this).val('');
                        }).blur(function(e){
                            $(this).val('Ingrese su nombre completo');
                        });
                    }
                    data.element.on('change',function(event){
                        data.error = helpers.checkPattern();
                        
                        if (!data.error) {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No se permiten caracteres especiales ni n\u00FAmeros en este campo"});
                            helpers.showError();
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                }
                
                if (data.type == 'firstname') {
                    settings.pattern = /^\D+$/i;
                    settings.help = "Por favor ingrese sus nombres";
                    if ($(data.element).val().length==0) {
                        $(data.element).val('Ingrese sus nombres');
                    }
                    data.element.on('change',function(event){
                        data.error = helpers.checkPattern();
                        if (!data.error) {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No se permiten caracteres especiales ni n\u00FAmeros en este campo"});
                            helpers.showError();
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                    data.element.on('change',function(event){
                        if ($(data.element).val().length==0) {
                            $(data.element).val('Ingrese sus nombres').focus(function(e){
                               $(this).val('');
                            }).blur(function(e){
                                $(this).val('Ingrese sus nombres');
                            });
                        }
                    });
                }
                
                if (data.type == 'lastname') {
                    settings.pattern = /^\D+$/i;
                    settings.help = "Por favor ingrese sus apellidos";
                    if ($(data.element).val().length==0) {
                        $(data.element).val('Ingrese sus apellidos');
                    }
                    data.element.on('change',function(event){
                        data.error = helpers.checkPattern();
                        
                        if (!data.error) {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No se permiten caracteres especiales ni n\u00FAmeros en este campo"});
                            helpers.showError();
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                    data.element.on('change',function(event){
                        if ($(data.element).val().length==0) {
                            $(data.element).val('Ingrese sus apellidos').focus(function(e){
                               $(this).val('');
                            }).blur(function(e){
                                $(this).val('Ingrese sus apellidos');
                            });
                        }
                    });
                }
                
                if (data.type == 'date') {
                    $(data.element).mask("99/99/9999",{placeholder:" "});
                    $(data.element).datepicker({
                        changeMonth: true,
                        changeYear: true
                    });
                    settings.pattern = /^(0[1-9]|[12][0-9]|3[01])+[\-\/]+(0[1-9]|1[012])+[\-\/]+(19|20)[0-9]{2}/i;
                    settings.help = "Por favor ingrese una fecha valida";
                    data.element.on('change',function(event){
                        data.error = helpers.checkPattern();
                        
                        if (!data.error) {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"Debes ingresar una fecha v\u00E1lida con formato dd/mm/yyyy"});
                            helpers.showError();
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                }
                
                if (data.type == 'email') {
                    settings.pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.(([0-9]{1,3})|([a-zA-Z]{2,4})|(aero|coop|info|museum|name))$/i;
                    arroba = $(document.createElement('b')).addClass('neco-form-arroba').text('@');
                    $(data.element).after(arroba);if ($(data.element).val().length==0) {
                        $(data.element).val('@');
                    }
                    settings.help = "Por favor ingrese una direcci\u00F3n de email v\u00E1lida";
                    settings.tip = "Las direcciones de emai ser\u00E1n validadas y de ser una direci\u00F3n inv\u00E1lida, no se procesar\u00E1 el formulario";
                    $(arroba).on('click',function(e){
                        currentValue = $(data.element).val();
                        $(data.element).val(currentValue + '@').focus();
                    });
                    //TODO: comprobar servidor y direccion de correo contra php en necoyoad
                    data.element.on('change',function(event){
                        data.error = helpers.checkPattern();
                        
                        if (!data.error) {
                            helpers.showError();
                            $(data.element).parent().find('.neco-form-error').attr({'title':"Debes ingresar una direcci\u00F3n de email v\u00E1lida y que exista realmente"});
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                }
                
                if (data.type == 'number') {
                    settings.pattern = /^\d+$/i;
                    //TODO: agregar botones para sumar o restar
                    data.element.on('change',function(event){
                        data.error = helpers.checkPattern();
                        if (!data.error) {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"Solo se permiten n\u00FAmeros en este campo"});
                            helpers.showError();
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                }
                
                if (data.type == 'money') {
                    $(data.element).autoNumeric({aSep: settings.thousands, aDec: settings.decimals});
                    if ($(data.element).val().length==0) {
                        $(data.element).val('0' + settings.decimals + '00');
                    }
                    data.element.on('change',function(event){
                        data.error = isNaN($(data.element).val());
                        
                        if (!data.error) {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"Debes ingresar un valor num\u00E9rico con dos decimales. Por ejemplo, 123,00"});
                            helpers.showError();
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                }
                
                if (data.type == 'phone') {
                    settings.pattern = /\(?(\d{4})\)? ?(\d{3})+\.(\d{2})+\.(\d{2})/i;
                    data.element.on('change',function(event){
                        data.error = helpers.checkPattern();
                        if (!data.error) {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"Debes ingresar un n\u00FAmero de tel\u00E9fono v\u00E1lido con el formato (0000) 000.00.00"});
                            helpers.showError();
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                    $(data.element).mask("(9999) 999.99.99",{placeholder:" "});
                }
                
                if (data.type == 'password') {
                    settings.pattern = /^.*(?=.{6,})(?=.*\d)(?=.*[a-zA-Z]).*$/i;
                    data.element.on('change',function(event){
                        data.error = helpers.checkPattern();
                        
                        if (!data.error) {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"Debes ingresar una contrase\u00F1a que tenga al menos una min\u00FAscula, una may\u00FAscula y un n\u00FAmero"});
                            helpers.showError();
                        } else {
                            $(data.element).parent().find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            helpers.showSuccess();
                        }
                    });
                    
                    confirmPwd = $(document.createElement('div')).addClass('property').html('<label for="confirm">Confirmar Contrase\u00F1a:</label><input type="password" name="confirm" id="confirm" value="" autocomplete="off" required="true" title="Vuelva a escribir la contrase&ntilde;a" /><span class="neco-input-required">*</span><a class="neco-form-help"><span class="neco-tooltip">Por favor repita la contrase\u00F1a</span></a><a class="neco-form-tip"><span class="neco-tooltip">Debe repetir la contrase\u00F1a para confirmar que la haya escrito bien</span></a><a class="neco-form-error" title="No hay errores en el campo"><span class="neco-tooltip"></span></a>');
                    
                    $(data.element).parent('div').after(confirmPwd);
                    
                    $(confirmPwd).on('change',function(event){
                        confirmInput = $(confirmPwd).find('input');
                        if ($(data.element).val()!=confirmInput.val()) {
                            $(confirmPwd).find('.neco-form-error').attr({'title':"La confirmaci\u00F3n de la contrase\u00F1a no coincide, por favor vuelva a escribirla"});
                            if (confirmInput.hasClass('neco-input-success')) { confirmInput.removeClass('neco-input-success') }
                            confirmInput.addClass('neco-input-error');
                        } else {
                            $(confirmPwd).find('.neco-form-error').attr({'title':"No hay errores en este campo"});
                            if (confirmInput.hasClass('neco-input-error')) { confirmInput.removeClass('neco-input-error') }
                            confirmInput.addClass('neco-input-success');
                        }
                    });
                    $(confirmPwd).find('.neco-form-error').on('mouseover',function(){
                        if ($(this).attr('title').length==0) return false;
                        $(this).find('span').text($(this).attr('title'));
                        $(this).attr('title','');
                    });               
                }
                
                if (data.type == 'confirm') {
                                       
                }
                
                if ($(data.element).attr('showquick')=='off') {
                    settings.showQuick=false; 
                }
                if (settings.showQuick) {
                    helpers.quickError();
                    helpers.quickTip();
                    helpers.quickHelp(); 
                }
                helpers.isRequired();                
                
                if (typeof settings.create == 'function') {
                    settings.create();
                }
            },
            isRequired:function() {
                var required = $(data.element).attr('required'); 
                if (required) {
                    var el = $(document.createElement('span')).text('*').addClass('neco-input-required');
                    $(data.element).after(el);
                }
                settings.required = required;
            },
            quickHelp:function(){
                if (!settings.help && $(data.element).attr('title')) {
                    settings.help = $(data.element).attr('title');
                } else if (!settings.help) {
                    settings.help = "No se pudo cargar el mensaje";
                }
                var quick = $(document.createElement('a')).attr({'title':settings.help}).text('').addClass('neco-form-help');
                $(data.element).after(quick);
                var msg = $(document.createElement('span')).addClass('neco-tooltip');
                $(quick).append(msg);
                $(quick).on('mouseover',function(e){
                    message = $(this).attr('title');
                    $(this).removeAttr('title');
                    $(msg).text(message);
                });
            },
            quickTip:function(){
                if (!settings.tip && $(data.element).attr('quicktip')) {
                    settings.tip = $(data.element).attr('quicktip');
                } else if (!settings.tip) {
                    settings.tip = "No se pudo cargar el mensaje";
                }
                var quick = $(document.createElement('a')).attr({'title':settings.tip}).text('').addClass('neco-form-tip');
                $(data.element).after(quick);
                var msg = $(document.createElement('span')).addClass('neco-tooltip');
                $(quick).append(msg);
                $(quick).on('mouseover',function(e){
                    message = $(this).attr('title');
                    $(this).removeAttr('title');
                    $(msg).text(message);
                });
            },
            quickError:function(){
                if (!settings.error) {
                    settings.error = "No hay errores en el campo";
                }
                var quick = $(document.createElement('a')).attr({'title':settings.error}).text('').addClass('neco-form-error');
                $(data.element).after(quick);
                var msg = $(document.createElement('span')).addClass('neco-tooltip');
                $(quick).append(msg);
                $(quick).on('mouseover',function(e){
                    message = $(this).attr('title');
                    $(this).removeAttr('title');
                    $(msg).text(message);
                });
            },
            setQuickHelp:function(el) {
                
            },
            showError:function(){
                if ($(data.element).hasClass('neco-input-success')) {
                    $(data.element).removeClass('neco-input-success');
                }
                $(data.element).addClass('neco-input-error');
            },
            showSuccess:function(){
                if ($(data.element).hasClass('neco-input-error')) {
                    $(data.element).removeClass('neco-input-error');
                }
                $(data.element).addClass('neco-input-success');
            },
            checkPattern:function() {
                pattern = new RegExp(settings.pattern);
                return pattern.test(data.element.val());  
            },
            _focus: function() {
                $(data.element).on('focus',function(event){
                    if (typeof settings.focus == "function") {
                        settings.focus(this);
                    }
                });
            },
            _blur: function() {
                $(data.element).on('blur',function(event){
                    if (typeof settings.blur == "function") {
                        settings.blur(this);
                    }
                });
            },
            _keydown: function() {
                $(data.element).on('change',function(event){
                    if (typeof settings.keydown == "function") {
                        settings.keydown(this);
                    }
                });
            },
            _change: function() {
                $(data.element).on('change',function(event){
                   if (settings.required) {
                        helpers.checkNoEmpty();
                    }
                    if (typeof settings.change == "function") {
                        settings.change(this);
                    }
                });
                
                
            },
            checkNoEmpty: function() {
                if (!data.element.val()) {
                    $(data.element).parent().find('.neco-form-error').attr({'title':"No puedes dejar este campo en blanco"});
                    helpers.showError();
                }
            }
        }
        
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error( 'Method "' +  method + '" does not exist in ntCarousel plugin!');
        }
    }
})(jQuery);

/**
 * NecoInput
 * Author: Yosiet Serga
 * Version: 1.0.1
 * 
 * Dual licensed under the MIT and GPL licenses
 * 
 */
(function($) {
    $.fn.ntTextArea = function(method) {
        var defaults = {
            error:      false,
            message:    false,
            pattern:     '',
            format:     '',
            showQuick:   true,
            focus:      function(){},
            blur:       function(){},
            keydown:    function(){},
            change:     function(){},
            options:    {},
            loading:    {
                title:'Comprobando...',
                image:'../loader.gif',
                classname:'neco-input-loading'
            }
        }
        
        var settings = {};
        var data = {};
        var methods = {
            init : function(options) {
                return this.each(function() {
                    settings = $.extend({}, defaults, options);
                    data.element = $(this);
                    helpers._create();
                    helpers._focus();
                    helpers._blur();
                    helpers._keydown();
                    helpers._change();
                });
            }
        }
 
        var helpers = {
            _create: function() {
                $('*', data.element).change(helpers._change);
                $('*', data.element).keydown(helpers._keydown);
                
                data.element.on('change',function(event){
                    if (settings.pattern.length > 0) {
                        data.error = helpers.checkPattern();
                    }
                    if (data.error) {
                        helpers.showError();
                    } else {
                        helpers.showSuccess();
                    }
                });
                
                if ($(data.element).attr('showquick')=='off') {
                    settings.showQuick=false; 
                }
                if (settings.showQuick) {
                    helpers.quickError();
                    helpers.quickTip();
                    helpers.quickHelp(); 
                }
                helpers.isRequired();                
                
                if (typeof settings.create == 'function') {
                    settings.create();
                }
            },
            isRequired:function() {
                var required = $(data.element).attr('required'); 
                if (required) {
                    var el = $(document.createElement('span')).text('*').addClass('neco-input-required');
                    $(data.element).after(el);
                }
                settings.required = required;
            },
            quickHelp:function(){
                if (!settings.help && $(data.element).attr('title')) {
                    settings.help = $(data.element).attr('title');
                } else if (!settings.help) {
                    settings.help = "No se pudo cargar el mensaje";
                }
                var quick = $(document.createElement('a')).attr({'title':settings.help}).text('').addClass('neco-form-help');
                $(data.element).after(quick);
                var msg = $(document.createElement('span')).addClass('neco-tooltip');
                $(quick).append(msg);
                $(quick).on('mouseover',function(e){
                    message = $(this).attr('title');
                    $(this).removeAttr('title');
                    $(msg).text(message);
                });
            },
            quickTip:function(){
                if (!settings.tip && $(data.element).attr('quicktip')) {
                    settings.tip = $(data.element).attr('quicktip');
                } else if (!settings.tip) {
                    settings.tip = "No se pudo cargar el mensaje";
                }
                var quick = $(document.createElement('a')).attr({'title':settings.tip}).text('').addClass('neco-form-tip');
                $(data.element).after(quick);
                var msg = $(document.createElement('span')).addClass('neco-tooltip');
                $(quick).append(msg);
                $(quick).on('mouseover',function(e){
                    message = $(this).attr('title');
                    $(this).removeAttr('title');
                    $(msg).text(message);
                });
            },
            quickError:function(){
                if (!settings.error) {
                    settings.error = "No hay errores en el campo";
                }
                var quick = $(document.createElement('a')).attr({'title':settings.error}).text('').addClass('neco-form-error');
                $(data.element).after(quick);
                var msg = $(document.createElement('span')).addClass('neco-tooltip');
                $(quick).append(msg);
                $(quick).on('mouseover',function(e){
                    message = $(this).attr('title');
                    $(this).removeAttr('title');
                    $(msg).text(message);
                });
            },
            showError:function(){
                if ($(data.element).hasClass('neco-input-success')) {
                    $(data.element).removeClass('neco-input-success');
                }
                $(data.element).addClass('neco-input-error');
            },
            showSuccess:function(){
                if ($(data.element).hasClass('neco-input-error')) {
                    $(data.element).removeClass('neco-input-error');
                }
                $(data.element).addClass('neco-input-success');
            },
            checkPattern:function() {
                pattern = new RegExp(settings.pattern);
                return pattern.test(data.element.val());  
            },
            _focus: function() {
                $(data.element).on('focus',function(event){
                    if (typeof settings.focus == "function") {
                        settings.focus(this);
                    }
                });
            },
            _blur: function() {
                $(data.element).on('blur',function(event){
                    if (typeof settings.blur == "function") {
                        settings.blur(this);
                    }
                });
            },
            _keydown: function() {
                $(data.element).on('change',function(event){
                    if (typeof settings.keydown == "function") {
                        settings.keydown(this);
                    }
                });
            },
            _change: function() {
                $(data.element).on('change',function(event){
                   if (settings.required) {
                        helpers.checkNoEmpty();
                    }
                    if (typeof settings.change == "function") {
                        settings.change(this);
                    }
                });
                
                
            },
            checkNoEmpty: function() {
                if (!data.element.val()) {
                    $(data.element).parent().find('.neco-form-error').attr({'title':"No puedes dejar este campo en blanco"});
                    helpers.showError();
                }
            }
        }
        
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error( 'Method "' +  method + '" does not exist in ntTextArea plugin!');
        }
    }
})(jQuery);

/**
* autoNumeric.js
* @author: Bob Knothe
* @author: Sokolov Yura aka funny_falcon
* @version: 1.7.5
*
* Created by Robert J. Knothe on 2010-10-25. Please report any bug at http://www.decorplanit.com/plugin/
* Created by Sokolov Yura on 2010-11-07. http://github.com/funny_falcon
*
* Copyright (c) 2011 Robert J. Knothe  http://www.decorplanit.com/plugin/
* Copyright (c) 2011 Sokolov Yura aka funny_falcon
*
* The MIT License (http://www.opensource.org/licenses/mit-license.php)
*
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/
(function ($) {
	/**
	* Cross browser routin for getting selected range/cursor position
	*/
	function getElementSelection(that) {
		var position = {};
		if (that.selectionStart === undefined) {
			that.focus();
			var select = document.selection.createRange();
			position.length = select.text.length;
			select.moveStart('character', -that.value.length);
			position.end = select.text.length;
			position.start = position.end - position.length;
		} else {
			position.start = that.selectionStart;
			position.end = that.selectionEnd;
			position.length = position.end - position.start;
		}
		return position;
	}
	/**
	* Cross browser routin for setting selected range/cursor position
	*/
	function setElementSelection(that, start, end) {
		if (that.selectionStart === undefined) {
			that.focus();
			var r = that.createTextRange();
			r.collapse(true);
			r.moveEnd('character', end);
			r.moveStart('character', start);
			r.select();
		} else {
			that.selectionStart = start;
			that.selectionEnd = end;
		}
	}
	/**
	* run callbacks in parameters if any
	* any parameter could be a callback:
	* - a function, which invoked with jQuery element, parameters and this parameter name and returns parameter value
	* - a name of function, attached to $.autoNumeric, which called as previous
	* - a css selector recognized by jQuery - value of input is taken as a parameter value
	*/
	function runCallbacks($this, io) {
		/**
		* loops through the io object (option array) to find the following
		* k = option name example k=aNum
		* val = option value example val=0123456789
		*/
		$.each(io, function (k, val) {
			if (typeof (val) === 'function') {
				io[k] = val($this, io, k);
			} else if (typeof (val) === 'string') {
				var kind = val.substr(0, 4);
				if (kind === 'fun:') {
					var fun = $.autoNumeric[val.substr(4)];
					if (typeof (fun) === 'function') {
						/**
						* calls the attached function from meta="{aSign:'fun:functionName'}"
						* example: $autoNumeric.functionName($this, io, optionName);
						*/
						io[k] = $.autoNumeric[val.substr(4)]($this, io, k);
					} else {
						io[k] = null;
					}
				} else if (kind === 'css:') {
					/**
					* retrieves the value by css selector meta="{mDec:'css:#decimal'}"
					* example: would assign the value to io[k] = $('#decimal').val();
					*/
					io[k] = $(val.substr(4)).val();
				}
			}
		});
	}
	function convertKeyToNumber(io, key) {
		if (typeof (io[key]) === 'string') {
			io[key] *= 1;
		}
	}
	/**
	* Preparing user defined options for further usage
	* merge them with defaults appropriatly
	*/
	function autoCode($this, options) {
		var io = $.extend({}, $.fn.autoNumeric.defaults, options);
		if ($.metadata) { /** consider declared metadata on input */
			io = $.extend(io, $this.metadata());
		}
		runCallbacks($this, io);
		var vmax = io.vMax.toString().split('.');
		var vmin = (!io.vMin && io.vMin !== 0) ? [] : io.vMin.toString().split('.');
		convertKeyToNumber(io, 'vMax');
		convertKeyToNumber(io, 'vMin');
		convertKeyToNumber(io, 'mDec');
		io.aNeg = io.vMin < 0 ? '-' : ''; /** set mDec, if not defained by user */
		if (typeof (io.mDec) !== 'number') {
			io.mDec = Math.max((vmax[1] ? vmax[1] : '').length, (vmin[1] ? vmin[1] : '').length);
		} /** set alternative decimal separator key */
		if (io.altDec === null && io.mDec > 0) {
			if (io.aDec === '.' && io.aSep !== ',') {
				io.altDec = ',';
			} else if (io.aDec === ',' && io.aSep !== '.') {
				io.altDec = '.';
			}
		} /** cache regexps for autoStrip */
		var aNegReg = io.aNeg ? '([-\\' + io.aNeg + ']?)' : '(-?)';
		io._aNegReg = aNegReg;
		io._skipFirst = new RegExp(aNegReg + '[^-' + (io.aNeg ? '\\' + io.aNeg : '') + '\\' + io.aDec + '\\d]' + '.*?(\\d|\\' + io.aDec + '\\d)');
		io._skipLast = new RegExp('(\\d\\' + io.aDec + '?)[^\\' + io.aDec + '\\d]\\D*$');
		var allowed = (io.aNeg ? io.aNeg : '-') + io.aNum + '\\' + io.aDec;
		if (io.altDec && io.altDec !== io.aSep) {
			allowed += io.altDec;
		}
		io._allowed = new RegExp('[^' + allowed + ']', 'gi');
		io._numReg = new RegExp(aNegReg + '(?:\\' + io.aDec + '?(\\d+\\' + io.aDec + '\\d+)|(\\d*(?:\\' + io.aDec + '\\d*)?))');
		return io;
	}
	/**
	* strip all unwanted characters and leave only a number
	*/
	function autoStrip(s, io, strip_zero) {
		if (io.aSign) { /** remove currency sign */
			while (s.indexOf(io.aSign) > -1) {
				s = s.replace(io.aSign, '');
			}
		}
		s = s.replace(io._skipFirst, '$1$2'); /** first replace anything before digits */
		s = s.replace(io._skipLast, '$1'); /** then replace anything after digits */
		s = s.replace(io._allowed, ''); /** then remove any uninterested characters */
		if (io.altDec) {
			s = s.replace(io.altDec, io.aDec);
		} /** get only number string */
		var m = s.match(io._numReg);
		s = m ? [m[1], m[2], m[3]].join('') : ''; /** strip zero if need */
		if (strip_zero) {
			var strip_reg = '^' + io._aNegReg + '0*(\\d' + (strip_zero === 'leading' ? ')' : '|$)');
			strip_reg = new RegExp(strip_reg);
			s = s.replace(strip_reg, '$1$2');
		}
		return s;
	}
	/**
	* truncate decimal part of a number
	*/
	function truncateDecimal(s, aDec, mDec) {
		if (aDec && mDec) {
			var parts = s.split(aDec);
			/** truncate decimal part to satisfying length
			* cause we would round it anyway */
			if (parts[1] && parts[1].length > mDec) {
				if (mDec > 0) {
					parts[1] = parts[1].substring(0, mDec);
					s = parts.join(aDec);
				} else {
					s = parts[0];
				}
			}
		}
		return s;
	}
	/**
	* prepare number string to be converted to real number
	*/
	function fixNumber(s, aDec, aNeg) {
		if (aDec && aDec !== '.') {
			s = s.replace(aDec, '.');
		}
		if (aNeg && aNeg !== '-') {
			s = s.replace(aNeg, '-');
		}
		if (!s.match(/\d/)) {
			s += '0';
		}
		return s;
	}
	/**
	* prepare real number to be converted to our format
	*/
	function presentNumber(s, aDec, aNeg) {
		if (aNeg && aNeg !== '-') {
			s = s.replace('-', aNeg);
		}
		if (aDec && aDec !== '.') {
			s = s.replace('.', aDec);
		}
		return s;
	}
	/**
	* checking that number satisfy format conditions
	* and lays between io.vMin and io.vMax
	*/
	function autoCheck(s, io) {
		s = autoStrip(s, io);
		s = truncateDecimal(s, io.aDec, io.mDec);
		s = fixNumber(s, io.aDec, io.aNeg);
		var value = +s;
		return value >= io.vMin && value <= io.vMax;
	}
	/**
	* private function to check for empty value
	*/
	function checkEmpty(iv, io, signOnEmpty) {
		if (iv === '' || iv === io.aNeg) {
			if (io.wEmpty === 'zero') {
				return iv + '0';
			} else if (io.wEmpty === 'sign' || signOnEmpty) {
				return iv + io.aSign;
			} else {
				return iv;
			}
		}
		return null;
	}
	/**
	* private function that formats our number
	*/
	function autoGroup(iv, io) {
		iv = autoStrip(iv, io);
		var empty = checkEmpty(iv, io, true);
		if (empty !== null) {
			return empty;
		}
		var digitalGroup = '';
		if (io.dGroup === 2) {
			digitalGroup = /(\d)((\d)(\d{2}?)+)$/;
		} else if (io.dGroup === 4) {
			digitalGroup = /(\d)((\d{4}?)+)$/;
		} else {
			digitalGroup = /(\d)((\d{3}?)+)$/;
		} /** splits the string at the decimal string */
		var ivSplit = iv.split(io.aDec);
		if (io.altDec && ivSplit.length === 1) {
			ivSplit = iv.split(io.altDec);
		} /** assigns the whole number to the a varibale (s) */
		var s = ivSplit[0];
		if (io.aSep) {
			while (digitalGroup.test(s)) { /**  re-inserts the thousand sepparator via a regualer expression */
				s = s.replace(digitalGroup, '$1' + io.aSep + '$2');
			}
		}
		if (io.mDec !== 0 && ivSplit.length > 1) {
			if (ivSplit[1].length > io.mDec) {
				ivSplit[1] = ivSplit[1].substring(0, io.mDec);
			} /** joins the whole number with the deciaml value */
			iv = s + io.aDec + ivSplit[1];
		} else { /** if whole numers only */
			iv = s;
		}
		if (io.aSign) {
			var has_aNeg = iv.indexOf(io.aNeg) !== -1;
			iv = iv.replace(io.aNeg, '');
			iv = io.pSign === 'p' ? io.aSign + iv : iv + io.aSign;
			if (has_aNeg) {
				iv = io.aNeg + iv;
			}
		}
		return iv;
	}
	/**
	* round number after setting by pasting or $().autoNumericSet()
	* private function for round the number
	* please note this handled as text - Javascript math function can return inaccurate values
	* also this offers multiple rounding metods that are not easily accomplished in javascript
	*/
	function autoRound(iv, mDec, mRound, aPad) { /** value to string */
		iv = (iv === '') ? '0' : iv.toString();
		var ivRounded = '';
		var i = 0;
		var nSign = '';
		var rDec = (typeof (aPad) === 'boolean' || aPad === null) ? (aPad ? mDec : 0) : +aPad;
		var truncateZeros = function (ivRounded) { /** truncate not needed zeros */
			var regex = rDec === 0 ? (/(\.[1-9]*)0*$/) : rDec === 1 ? (/(\.\d[1-9]*)0*$/) : new RegExp('(\\.\\d{' + rDec + '}[1-9]*)0*$');
			ivRounded = ivRounded.replace(regex, '$1'); /** If there are no decimal places, we don't need a decimal point at the end */
			if (rDec === 0) {
				ivRounded = ivRounded.replace(/\.$/, '');
			}
			return ivRounded;
		};
		if (iv.charAt(0) === '-') { /** Checks if the iv (input Value)is a negative value */
			nSign = '-'; /** removes the negative sign will be added back later if required */
			iv = iv.replace('-', '');
		} /** prepend a zero if first character is not a digit (then it is likely to be a dot)*/
		if (!iv.match(/^\d/)) {
			iv = '0' + iv;
		} /** determines if the value is zero - if zero no negative sign */
		if (nSign === '-' && +iv === 0) {
			nSign = '';
		} /** trims leading zero's if needed */
		if ((+iv) > 0) {
			iv = iv.replace(/^0*(\d)/, '$1');
		} /** decimal postion as an integer */
		var dPos = iv.lastIndexOf('.'); /** virtual decimal position */
		var vdPos = dPos === -1 ? iv.length - 1 : dPos; /** checks decimal places to determine if rounding is required */
		var cDec = (iv.length - 1) - vdPos; /** check if no rounding is required */
		if (cDec <= mDec) {
			ivRounded = iv; /** check if we need to pad with zeros */
			if (cDec < rDec) {
				if (dPos === -1) {
					ivRounded += '.';
				}
				while (cDec < rDec) {
					var zeros = '000000'.substring(0, rDec - cDec);
					ivRounded += zeros;
					cDec += zeros.length;
				}
			} else if (cDec > rDec) {
				ivRounded = truncateZeros(ivRounded);
			} else if (cDec === 0 && rDec === 0) {
				ivRounded = ivRounded.replace(/\.$/, '');
			}
			return nSign + ivRounded;
		} /** rounded length of the string after rounding  */
		var rLength = dPos + mDec; /** test round */
		var tRound = +iv.charAt(rLength + 1);
		var ivArray = iv.substring(0, rLength + 1).split('');
		var odd = (iv.charAt(rLength) === '.') ? (iv.charAt(rLength - 1) % 2) : (iv.charAt(rLength) % 2);
		if ((tRound > 4 && mRound === 'S') || (tRound > 4 && mRound === 'A' && nSign === '') || (tRound > 5 && mRound === 'A' && nSign === '-') || (tRound > 5 && mRound === 's') || (tRound > 5 && mRound === 'a' && nSign === '') || (tRound > 4 && mRound === 'a' && nSign === '-') || (tRound > 5 && mRound === 'B') || (tRound === 5 && mRound === 'B' && odd === 1) || (tRound > 0 && mRound === 'C' && nSign === '') || (tRound > 0 && mRound === 'F' && nSign === '-') || (tRound > 0 && mRound === 'U')) {
			/** Round up the last digit if required, and continue until no more 9's are found */
			for (i = (ivArray.length - 1); i >= 0; i -= 1) {
				if (ivArray[i] !== '.') {
					ivArray[i] = +ivArray[i] + 1;
					if (ivArray[i] < 10) {
						break;
					} else if (i > 0) {
						ivArray[i] = '0';
					}
				}
			}
		} /** Reconstruct the string, converting any 10's to 0's */
		ivArray = ivArray.slice(0, rLength + 1);
		ivRounded = truncateZeros(ivArray.join('')); /** return rounded value */
		return nSign + ivRounded;
	}
	/**
	* Holder object for field properties
	*/
	function autoNumericHolder(that, options) {
		this.options = options;
		this.that = that;
		this.$that = $(that);
		this.formatted = false;
		this.io = autoCode(this.$that, this.options);
		this.value = that.value;
	}
	autoNumericHolder.prototype = {
		init: function (e) {
			this.value = this.that.value;
			this.io = autoCode(this.$that, this.options);
			this.ctrlKey = e.ctrlKey;
			this.cmdKey = e.metaKey;
			this.shiftKey = e.shiftKey;
			this.selection = getElementSelection(this.that); /** keypress event overwrites meaningfull value of e.keyCode */
			if (e.type === 'keydown' || e.type === 'keyup') {
				this.kdCode = e.keyCode;
			}
			this.which = e.which;
			this.processed = false;
			this.formatted = false;
		},
		setSelection: function (start, end, setReal) {
			start = Math.max(start, 0);
			end = Math.min(end, this.that.value.length);
			this.selection = {
				start: start,
				end: end,
				length: end - start
			};
			if (setReal === undefined || setReal) {
				setElementSelection(this.that, start, end);
			}
		},
		setPosition: function (pos, setReal) {
			this.setSelection(pos, pos, setReal);
		},
		getBeforeAfter: function () {
			var value = this.value;
			var left = value.substring(0, this.selection.start);
			var right = value.substring(this.selection.end, value.length);
			return [left, right];
		},
		getBeforeAfterStriped: function () {
			var parts = this.getBeforeAfter();
			parts[0] = autoStrip(parts[0], this.io);
			parts[1] = autoStrip(parts[1], this.io);
			return parts;
		},
		/**
		* strip parts from excess characters and leading zeroes
		*/
		normalizeParts: function (left, right) {
			var io = this.io;
			right = autoStrip(right, io); /** if right is not empty and first character is not aDec, */
			/** we could strip all zeros, otherwise only leading */
			var strip = right.match(/^\d/) ? true : 'leading';
			left = autoStrip(left, io, strip); /** strip leading zeros from right part if left part has no digits */
			if ((left === '' || left === io.aNeg)) {
				if (right > '') {
					right = right.replace(/^0*(\d)/, '$1');
				}
			}
			var new_value = left + right; /** insert zero if has leading dot */
			if (io.aDec) {
				var m = new_value.match(new RegExp('^' + io._aNegReg + '\\' + io.aDec));
				if (m) {
					left = left.replace(m[1], m[1] + '0');
					new_value = left + right;
				}
			} /** insert zero if number is empty and io.wEmpty == 'zero' */
			if (io.wEmpty === 'zero' && (new_value === io.aNeg || new_value === '')) {
				left += '0';
			}
			return [left, right];
		},
		/**
		* set part of number to value keeping position of cursor
		*/
		setValueParts: function (left, right) {
			var io = this.io;
			var parts = this.normalizeParts(left, right);
			var new_value = parts.join('');
			var position = parts[0].length;
			if (autoCheck(new_value, io)) {
				new_value = truncateDecimal(new_value, io.aDec, io.mDec);
				if (position > new_value.length) {
					position = new_value.length;
				}
				this.value = new_value;
				this.setPosition(position, false);
				return true;
			}
			return false;
		},
		/**
		* helper function for expandSelectionOnSign
		* returns sign position of a formatted value
		*/
		signPosition: function () {
			var io = this.io, aSign = io.aSign, that = this.that;
			if (aSign) {
				var aSignLen = aSign.length;
				if (io.pSign === 'p') {
					var hasNeg = io.aNeg && that.value && that.value.charAt(0) === io.aNeg;
					return hasNeg ? [1, aSignLen + 1] : [0, aSignLen];
				} else {
					var valueLen = that.value.length;
					return [valueLen - aSignLen, valueLen];
				}
			} else {
				return [1000, -1];
			}
		},
		/**
		* expands selection to cover whole sign
		* prevents partial deletion/copying/overwritting of a sign
		*/
		expandSelectionOnSign: function (setReal) {
			var sign_position = this.signPosition();
			var selection = this.selection;
			if (selection.start < sign_position[1] && selection.end > sign_position[0]) { /** if selection catches something except sign and catches only space from sign */
				if ((selection.start < sign_position[0] || selection.end > sign_position[1]) && this.value.substring(Math.max(selection.start, sign_position[0]), Math.min(selection.end, sign_position[1])).match(/^\s*$/)) { /** then select without empty space */
					if (selection.start < sign_position[0]) {
						this.setSelection(selection.start, sign_position[0], setReal);
					} else {
						this.setSelection(sign_position[1], selection.end, setReal);
					}
				} else { /** else select with whole sign */
					this.setSelection(Math.min(selection.start, sign_position[0]), Math.max(selection.end, sign_position[1]), setReal);
				}
			}
		},
		/**
		* try to strip pasted value to digits
		*/
		checkPaste: function () {
			if (this.valuePartsBeforePaste !== undefined) {
				var parts = this.getBeforeAfter();
				var oldParts = this.valuePartsBeforePaste;
				delete this.valuePartsBeforePaste; /* try to strip pasted value first */
				parts[0] = parts[0].substr(0, oldParts[0].length) + autoStrip(parts[0].substr(oldParts[0].length), this.io);
				if (!this.setValueParts(parts[0], parts[1])) {
					this.value = oldParts.join('');
					this.setPosition(oldParts[0].length, false);
				}
			}
		},
		/**
		* process pasting, cursor moving and skipping of not interesting keys
		* if returns true, futher processing is not performed
		*/
		skipAllways: function (e) {
			var kdCode = this.kdCode, which = this.which, ctrlKey = this.ctrlKey, cmdKey = this.cmdKey; /** catch the ctrl up on ctrl-v */
			if (kdCode === 17 && e.type === 'keyup' && this.valuePartsBeforePaste !== undefined) {
				this.checkPaste();
				return false;
			}
			/** codes are taken from http://www.cambiaresearch.com/c4/702b8cd1-e5b0-42e6-83ac-25f0306e3e25/Javascript-Char-Codes-Key-Codes.aspx
			* skip Fx keys, windows keys, other special keys */
			if ((kdCode >= 112 && kdCode <= 123) || (kdCode >= 91 && kdCode <= 93) || (kdCode >= 9 && kdCode <= 31) || (kdCode < 8 && (which === 0 || which === kdCode)) || kdCode === 144 || kdCode === 145 || kdCode === 45) {
				return true;
			} /** if select all (a=65)*/
			if ((ctrlKey || cmdKey) && kdCode === 65) {
				return true;
			} /** if copy (c=67) paste (v=86) or cut (x=88) */
			if ((ctrlKey || cmdKey) && (kdCode === 67 || kdCode === 86 || kdCode === 88)) { /** replace or cut whole sign */
				if (e.type === 'keydown') {
					this.expandSelectionOnSign();
				} /** try to prevent wrong paste */
				if (kdCode === 86) {
					if (e.type === 'keydown' || e.type === 'keypress') {
						if (this.valuePartsBeforePaste === undefined) {
							this.valuePartsBeforePaste = this.getBeforeAfter();
						}
					} else {
						this.checkPaste();
					}
				}
				return e.type === 'keydown' || e.type === 'keypress' || kdCode === 67;
			}
			if (ctrlKey || cmdKey) {
				return true;
			}
			if (kdCode === 37 || kdCode === 39) { /** jump over thousand separator */
				var aSep = this.io.aSep, start = this.selection.start, value = this.that.value;
				if (e.type === 'keydown' && aSep && !this.shiftKey) {
					if (kdCode === 37 && value.charAt(start - 2) === aSep) {
						this.setPosition(start - 1);
					} else if (kdCode === 39 && value.charAt(start) === aSep) {
						this.setPosition(start + 1);
					}
				}
				return true;
			}
			if (kdCode >= 34 && kdCode <= 40) {
				return true;
			}
			return false;
		},
		/**
		* process deletion of characters alert
		* returns true if processing performed
		*/
		processAllways: function () {
			var parts; /** process backspace or delete */
			if (this.kdCode === 8 || this.kdCode === 46) {
				if (!this.selection.length) {
					parts = this.getBeforeAfterStriped();
					if (this.kdCode === 8) {
						parts[0] = parts[0].substring(0, parts[0].length - 1);
					} else {
						parts[1] = parts[1].substring(1, parts[1].length);
					}
					this.setValueParts(parts[0], parts[1]);
				} else {
					this.expandSelectionOnSign(false);
					parts = this.getBeforeAfterStriped();
					this.setValueParts(parts[0], parts[1]);
				}
				return true;
			}
			return false;
		},
		/**
		* process insertion of characters
		* returns true if processing performed
		*/
		processKeypress: function () {
			var io = this.io;
			var cCode = String.fromCharCode(this.which);
			var parts = this.getBeforeAfterStriped();
			var left = parts[0], right = parts[1]; /** start rules when the decimal charactor key is pressed */
			/** always use numeric pad dot to insert decimal separator */
			if (cCode === io.aDec || (io.altDec && cCode === io.altDec) || ((cCode === '.' || cCode === ',') && this.kdCode === 110)) { /** do not allow decimal character if no decimal part allowed */
				if (!io.mDec || !io.aDec) {
					return true;
				} /** do not allow decimal character before aNeg character */
				if (io.aNeg && right.indexOf(io.aNeg) > -1) {
					return true;
				} /** do not allow decimal character if other decimal character present */
				if (left.indexOf(io.aDec) > -1) {
					return true;
				}
				if (right.indexOf(io.aDec) > 0) {
					return true;
				}
				if (right.indexOf(io.aDec) === 0) {
					right = right.substr(1);
				}
				this.setValueParts(left + io.aDec, right);
				return true;
			} /** start rule on negative sign */
			if (cCode === '-' || cCode === '+') { /** prevent minus if not allowed */
				if (!io.aNeg) {
					return true;
				} /** carret is always after minus */
				if (left === '' && right.indexOf(io.aNeg) > -1) {
					left = io.aNeg;
					right = right.substring(1, right.length);
				} /** change sign of number, remove part if should */
				if (left.charAt(0) === io.aNeg) {
					left = left.substring(1, left.length);
				} else {
					left = (cCode === '-') ? io.aNeg + left : left;
				}
				this.setValueParts(left, right);
				return true;
			} /** digits */
			if (cCode >= '0' && cCode <= '9') { /** if try to insert digit before minus */
				if (io.aNeg && left === '' && right.indexOf(io.aNeg) > -1) {
					left = io.aNeg;
					right = right.substring(1, right.length);
				}
				this.setValueParts(left + cCode, right);
				return true;
			} /** prevent any other character */
			return true;
		},
		/**
		* formatting of just processed value with keeping of cursor position
		*/
		formatQuick: function () {
			var io = this.io;
			var parts = this.getBeforeAfterStriped();
			var value = autoGroup(this.value, this.io);
			var position = value.length;
			if (value) {
				/** prepare regexp which searches for cursor position from unformatted left part */
				var left_ar = parts[0].split('');
				var i;
				for (i = 0; i < left_ar.length; i += 1) { /** thanks Peter Kovari */
					if (!left_ar[i].match('\\d')) {
						left_ar[i] = '\\' + left_ar[i];
					}
				}
				var leftReg = new RegExp('^.*?' + left_ar.join('.*?'));
				/** search cursor position in formatted value */
				var newLeft = value.match(leftReg);
				if (newLeft) {
					position = newLeft[0].length;
					/** if we are just before sign which is in prefix position */
					if (((position === 0 && value.charAt(0) !== io.aNeg) || (position === 1 && value.charAt(0) === io.aNeg)) && io.aSign && io.pSign === 'p') {
						/** place carret after prefix sign */
						position = this.io.aSign.length + (value.charAt(0) === '-' ? 1 : 0);
					}
				} else if (io.aSign && io.pSign === 's') {
					/** if we could not find a place for cursor and have a sign as a suffix */
					/** place carret before suffix currency sign */
					position -= io.aSign.length;
				}
			}
			this.that.value = value;
			this.setPosition(position);
			this.formatted = true;
		}
	};
	function getData($that) {
		var data = $that.data('autoNumeric');
		if (!data) {
			data = {};
			$that.data('autoNumeric', data);
		}
		return data;
	}
	function getHolder($that, options) {
		var data = getData($that);
		var holder = data.holder;
		if (holder === undefined && options) {
			holder = new autoNumericHolder($that.get(0), options);
			data.holder = holder;
		}
		return holder;
	}
	function getOptions($that) {
		var data = $that.data('autoNumeric');
		if (data && data.holder) {
			return data.holder.options;
		}
		return {};
	}
	function onInit(options) {
		options = options || {};
		var iv = $(this), holder = getHolder(iv, options);
		if (holder.io.aForm && (this.value || holder.io.wEmpty !== 'empty')) {
			iv.autoNumericSet(iv.autoNumericGet(options), options);
		}
	}
	function onKeyDown(e) {
		var iv = $(e.target), holder = getHolder(iv);
		holder.init(e);
		if (holder.skipAllways(e)) {
			holder.processed = true;
			return true;
		}
		if (holder.processAllways()) {
			holder.processed = true;
			holder.formatQuick();
			e.preventDefault();
			return false;
		} else {
			holder.formatted = false;
		}
		return true;
	}
	function onKeyPress(e) {
		var iv = $(e.target), holder = getHolder(iv);
		var processed = holder.processed;
		holder.init(e);
		if (holder.skipAllways(e)) {
			return true;
		}
		if (processed) {
			e.preventDefault();
			return false;
		}
		if (holder.processAllways() || holder.processKeypress()) {
			holder.formatQuick();
			e.preventDefault();
			return false;
		} else {
			holder.formatted = false;
		}
	}
	function onKeyUp(e) {
		var iv = $(e.target), holder = getHolder(iv);
		holder.init(e);
		var skip = holder.skipAllways(e);
		holder.kdCode = 0;
		delete holder.valuePartsBeforePaste;
		if (skip) {
			return true;
		}
		if (this.value === '') {
			return true;
		}
		if (!holder.formatted) {
			holder.formatQuick();
		}
	}
	function onFocusIn(e) {
		var iv = $(e.target), holder = getHolder(iv);
		holder.inVal = iv.val();
		var onempty = checkEmpty(holder.inVal, holder.io, true);
		if (onempty !== null) {
			iv.val(onempty);
		}
	}
	/** start change - thanks to Javier P. corrected the inline onChange event  added focusout version 1.55*/
	function onFocusOut(e) {
		var iv = $(e.target), holder = getHolder(iv);
		var io = holder.io, value = iv.val(), origValue = value;
		if (value !== '') {
			value = autoStrip(value, io);
			if (checkEmpty(value, io) === null && autoCheck(value, io)) {
				value = fixNumber(value, io.aDec, io.aNeg);
				value = autoRound(value, io.mDec, io.mRound, io.aPad);
				value = presentNumber(value, io.aDec, io.aNeg);
			} else {
				value = '';
			}
		}
		var groupedValue = checkEmpty(value, io, false);
		if (groupedValue === null) {
			groupedValue = autoGroup(value, io);
		}
		if (groupedValue !== origValue) {
			iv.val(groupedValue);
		}
		if (groupedValue !== holder.inVal) {
			iv.change();
			delete holder.inVal;
		}
	}
	$.fn.autoNumeric = function (options) {
		return this.each(function () {
			onInit.call(this, options);
		}).unbind('.autoNumeric').bind({
			'keydown.autoNumeric': onKeyDown,
			'keypress.autoNumeric': onKeyPress,
			'keyup.autoNumeric': onKeyUp,
			'focusin.autoNumeric': onFocusIn,
			'focusout.autoNumeric': onFocusOut
		});
	};
	/** thanks to Anthony & Evan C */
    function autoGet(obj) {
		if (typeof (obj) === 'string') {
			obj = obj.replace(/\[/g, "\\[").replace(/\]/g, "\\]");
			obj = '#' + obj.replace(/(:|\.)/g, '\\$1');
		}
		return $(obj);
	}
	$.autoNumeric = {};
	/**
	* public function that stripes the format and converts decimal seperator to a period
	* as of 1.7.2 `options` argument is deprecated, options are taken from initializer
	*/
	$.autoNumeric.Strip = function (ii) {
		var $that = autoGet(ii);
		var options = getOptions($that);
		if (arguments[1] && typeof (arguments[1]) === 'object') {
			options = $.extend({}, options, arguments[1]);
		}
		var io = autoCode($that, options);
		var iv = autoGet(ii).val();
		iv = autoStrip(iv, io);
		iv = fixNumber(iv, io.aDec, io.aNeg);
		if (+iv === 0) {
			iv = '0';
		}
		return iv;
	};
	/**
	* public function that recieves a numeric string and formats to the target input field
	* as of 1.7.2 `options` argument is deprecated, options are taken from initializer
	*/
	$.autoNumeric.Format = function (ii, iv) {
		var $that = autoGet(ii);
		var options = getOptions($that);
		if (arguments[2] && typeof (arguments[2]) === 'object') {
			options = $.extend({}, options, arguments[2]);
		}
		iv.toString();
		var io = autoCode($that, options);
		iv = autoRound(iv, io.mDec, io.mRound, io.aPad);
		iv = presentNumber(iv, io.aDec, io.aNeg);
		if (!autoCheck(iv, io)) {
			iv = autoRound('', io.mDec, io.mRound, io.aPad);
		}
		return autoGroup(iv, io);
	};
	/**
	* get a number (as a number) from a field.
	* as of 1.7.2 argument is deprecated, options are taken from initializer
	* $('input#my').autoNumericGet()
	*/
	$.fn.autoNumericGet = function () {
		if (arguments[0]) {
			return $.autoNumeric.Strip(this, arguments[0]);
		}
		return $.autoNumeric.Strip(this);
	};
	/**
	* set a number to a field, formatting it appropriatly
	* as of 1.7.2 second argument is deprecated, options are taken from initializer
	* $('input#my').autoNumericSet(2.423)
	*/
	$.fn.autoNumericSet = function (iv) {
		if (arguments[1]) {
			return this.val($.autoNumeric.Format(this, iv, arguments[1]));
		}
		return this.val($.fn.autoNumeric.Format(this, iv));
	};
	/**
	* plugin defaults
	*/
	$.autoNumeric.defaults = {
		/**  allowed  numeric values
		* please do not modify
		*/
		aNum: '0123456789',
		/** allowed thousand separator characters
		* comma = ','
		* period "full stop" = '.'
		* apostrophe is escaped = '\''
		* space = ' '
		* none = ''
		* NOTE: do not use numeric characters
		*/
		aSep: ',',
		/** digital grouping for the thousand separator used in Format
		* dGroup: '2', results in 99,99,99,999 common in India
		* dGroup: '3', results in 999,999,999 default
		* dGroup: '4', results in 9999,9999,9999 used in some Asian countries
		*/
		dGroup: '3',
		/** allowed decimal separator characters
		* period "full stop" = '.'
		* comma = ','
		*/
		aDec: '.',
		/** allow to declare alternative decimal separator which is automatically replaced by aDec
		* developed for countries the use a comma ',' as the decimal character
		* and have keyboards\numeric pads that have a period 'full stop' as the decimal characters (Spain is an example)
		*/
		altDec: null,
		/** allowed currency symbol
		* Must be in quotes aSign: '$',
		*/
		aSign: '',
		/** placement of currency sign
		* for prefix  pSign: 'p',
		* for suffix pSign: 's',
		*/
		pSign: 'p',
		/** maximum possible value
		* value must be enclosed in quotes and use the period for the decimal point
		* value must be larger than vMin
		*/
		vMax: '999999999.99',
		/** minimum possible value
		* value must be enclosed in quotes and use the period for the decimal point
		* value must be smaller than vMax
		*/
		vMin: '0.00',
		/** max number of decimal places = used to overide deciaml places set by the vMin & vMax values
		* value must be enclosed in quotes example mDec: '3',
		* This can also set the value via a call back function mDec: 'css:#
		*/
		mDec: null,
		/** method used for rounding
		* mRound: 'S', Round-Half-Up Symmetric (default)
		* mRound: 'A', Round-Half-Up Asymmetric
		* mRound: 's', Round-Half-Down Symmetric (lower case s)
		* mRound: 'a', Round-Half-Down Asymmetric (lower case a)
		* mRound: 'B', Round-Half-Even "Bankers Rounding"
		* mRound: 'U', Round Up "Round-Away-From-Zero"
		* mRound: 'D', Round Down "Round-Toward-Zero" - same as trancate
		* mRound: 'C', Round to Ceiling "Toward Positive Infinity"
		* mRound: 'F', Round to Floor "Toward Negative Infinity"
		*/
		mRound: 'S',
		/** controls decimal padding
		* aPad: true - always Pad decimals with zeros
		* aPad: false - does not pad with zeros.
		* aPad: `some number` - pad decimals with zero to number different from mDec
		* thanks to Jonas Johansson for the suggestion
		*/
		aPad: true,
		/** Displayed on empty string
		* wEmpty: 'empty', - input can be blank
		* wEmpty: 'zero', - displays zero
		* wEmpty: 'sign', - displays the currency sign
		*/
		wEmpty: 'empty',
		/** atomatically format value "###########.##" in form
		* Please note this is a little buggy due to how each browser handles refresh
		* use with caution
		*/
		aForm: false
	}; /** deprecated way to access defaults and helper functions */
	$.fn.autoNumeric.defaults = $.autoNumeric.defaults;
	$.fn.autoNumeric.Strip = $.autoNumeric.Strip;
	$.fn.autoNumeric.Format = $.autoNumeric.Format;
})(jQuery);