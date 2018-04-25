
(function ($) {
    "use strict";
    
    /*==================================================================
    [ Validate ]*/
    $('.validate-form .input2').each(function(){
        $(this).focus(function(){
           hideValidate(this);
       });
    });

    $('#submit').click(function(){
        var check = true;
        var name = $('#name').val().trim();
        var image = $('#image').val().trim();
        var message = $('#message').val().trim();
        if(name == ''){
            showValidate($('#name'));
            check=false;
        }

        if(image == ''){
            showValidate($('#image'));
            check=false;
        }

        if(message == ''){
            showValidate($('#message'));
            check=false;
        }

        if (check) {
            $.post("../SaveCsv.php", {
                name: name,
                image: image,
                message: message
            },function (rs) {
                rs = JSON.parse(rs);
                if (rs.status == 'SUCCESS') {
                    $('.input2').val('');
                }
                alert(rs.status + "\n" + rs.message + "\n\n" + rs.data);
            });
        }
        
    });

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    

})(jQuery);