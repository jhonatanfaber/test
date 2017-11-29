function showForm(form) {
    if(form ==="antenna"){
        $("#member").hide(1000);
    }else{
        $("#member").show(1000);
    }
}

function validar(clase) {
    var validated=true;
    $("."+clase).each(function () {
        if($(this).val().length === 0){
            $(this).css('border', 'solid red');
            validated=false;
        }else {
            $(this).css('border', 'none');
        }

    });
    return validated;
}
