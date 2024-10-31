;(function( $ ) {
    tinymce.PluginManager.add('qcpnd_shortcode_btn', function( editor,url )
    {
        var shortcodeValues = [];

        editor.addButton('qcpnd_shortcode_btn', {
			title : 'Add SBD Shortcode',
            text: '',
            icon: 'icon phone-directory',
            onclick : function(e){
                $.post(
                    ajaxurl,
                    {
                        action : 'show_qcpnd_shortcodes'
                        
                    },
                    function(data){
                        $('#wpwrap').append(data);
                    }
                )
            },
            values: shortcodeValues
        });
    });

    

}(jQuery));
