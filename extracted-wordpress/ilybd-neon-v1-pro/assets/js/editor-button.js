(function() {
    tinymce.PluginManager.add('cyber_mce_button', function( editor, url ) {
        editor.addButton( 'cyber_mce_button', {
            text: 'Insert Code',
            icon: false,
            onclick: function() {
                var selected_text = editor.selection.getContent();
                var return_text = '[code]' + selected_text + '[/code]';
                editor.execCommand('mceInsertContent', 0, return_text);
            }
        });
    });
})();
