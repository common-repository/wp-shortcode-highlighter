(function( $ ) {
    $(function() {
        $('.wpsh-color-field').wpColorPicker({
            change: function(){
                $($(this).data('element')).css($(this).data('style'),$(this).val())
            }
        });
    });     
})( jQuery );