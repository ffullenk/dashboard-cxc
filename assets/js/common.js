$(document).ready(function(){
    $(document).on("submit",".ajaxForm",function(){
        var form=this;
        if(!form.submitting){
            form.submitting=true;
            $.ajax({
                url: form.action,
                data: $(form).serialize(),
                type: form.method,
                dataType: "json",
                success: function(response){
                    if(response.validacion){
                        if(response.redirect){
                            window.location=response.redirect;
                        }else{
                            var f=window[$(form).data("onsuccess")];
                            f(form);
                        }
                    }
                    else{
                        $(".validacion").html(response.errores);
                        $('html, body').animate({
                            scrollTop: $(".validacion").offset().top-10
                        });
                    }
                },
                complete: function(){
                    form.submitting=false;
                }
            });
        }
        return false;
    });
    
    $('#items').isotope({
        itemSelector : '.item',
        layoutMode : 'masonry',
        getSortData : {
            name : function ( $elem ) {
                return $elem.find('h3').text();
            },
            id : function ( $elem ) {
                return parseInt($elem.find('.id').text());
            },
            nusuarios : function ( $elem ) {
                return parseInt($elem.find('.nusuarios').text());
            }
        }
    });
    
    
    
    //Para que se recargue el modal siempre, y no use cache.
    $('#modalUnirseAProyecto').on('hidden', function() {
        $(this).removeData('modal');
    });
});

function modalUnirseAProyecto(proyectoId){
    $("#modal").load(site_url+"proyectos/unirse/"+proyectoId,function(){
        $("#modal").modal();
    });
    
}

function modalEditarProyecto(proyectoId){
    $("#modal").load(site_url+"proyectos/editar/"+proyectoId,function(){
        $("#modal").modal();
    });
    
}