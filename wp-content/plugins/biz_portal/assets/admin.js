var BizPortal_Admin = function ($) {

    //var var_1 = false;

    /*var function_1 = function() {
    }*/

    var rootUrl = null;
	
    return {
        init: function (object) {
            // Initializing
            if (object.hasOwnProperty('rootUrl'))
                this.rootUrl = object.rootUrl;

            // Initialize elements
            $('#btn_activate').click(function() {
                $('#action').val('activate');
                $(this).parent('form').submit();
            });

            $('#btn_delete').click(function() {
               $('#action').val('delete');
                $(this).parent('form').submit(); 
            });
            
            $('#btn_deactivate').click(function() {
               $('#action').val('deactivate');
                $(this).parent('form').submit(); 
            });

            $('#btn_delete').click(function() {
               $('#action').val('delete');
                $(this).parent('form').submit(); 
            });
        }
    };
    
}(jQuery);