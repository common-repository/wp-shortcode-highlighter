(function() {    
    var isEnabled = true;
    getShortcodes = function(content,unique){
        if(content.match(/\[([^\[\]]+)\]/g)){
            if(typeof unique !== 'undefined')
                return jQuery.unique(content.match(/\[([^\[\]]+)\]/g));
            return content.match(/\[([^\[\]]+)\]/g);
        }
        return false;
    }
    getParameters = function(content){
        if((content.match(/("|')(.*?)\1/g)))
            return jQuery.unique(content.match(/("|')(.*?)\1/g));
        return false;
    }
    cleanMarkup = function(content){
        var $content = jQuery('<div/>').html('<div>' + content + "</div>").contents(); 
        $content.find('.shortcode-highlighter').contents().unwrap();
        return $content.html();
    }
    addMarkup = function(content){

        var matches = getShortcodes(content,true); 
        for (var i = 0; i < matches.length; i++) {            
            var parameterMatches = getParameters(matches[i]);
            if(parameterMatches) for (var j = 0; j < parameterMatches.length; j++) { 
                k = parameterMatches[j].replace(/\[/,'\\[').replace(/\]/,'\\]');
                content = content.replace(new RegExp(k,"g"), '<span class="shortcode-highlighter shortcode-highlighter-parameter">'+k.replace(/\\/g,'')+'</span>');
            }   
        }
        var matches = getShortcodes(content,true);
        if(matches) for (var i = 0; i < matches.length; i++) {
            m = matches[i].replace(/\[/,'\\[').replace(/\]/,'\\]');
            content = content.replace(new RegExp(m,"g"), '<span class="shortcode-highlighter shortcode-highlighter-container">'+m.replace(/\\/g,'')+'</span>');
        }
        return content;    
    }
    tinymce.create('tinymce.plugins.ShortcodeHighlighter', {
        init : function(ed, url) {
            var editor = tinyMCE.activeEditor;

            jQuery(".wp-editor-wrap").on("click","#wpsh-refresh-shortcodes",function(){
                if(isEnabled){
                    var content = editor.getContent();
                    content = cleanMarkup(content);
                    content = addMarkup(content);
                    editor.setContent(content);
                }
            });
            
            jQuery(".wp-editor-wrap").on("click","#wpsh-disable-shortcodes",function(){

                var content = editor.getContent();
                if(jQuery(this).data('state') == 'enabled'){
                    isEnabled = false;  
                    jQuery("#wpsh-refresh-shortcodes").hide();
                    jQuery(this).text('Enable Highlighting');     
                    jQuery(this).data('state','disabled');
                    content = cleanMarkup(content); 
                    editor.setContent(content);
                } else {
                    isEnabled = true; 
                    jQuery("#wpsh-refresh-shortcodes").show();
                    jQuery(this).text('Disable Highlighting');  
                    jQuery(this).data('state','enabled');
                    content = cleanMarkup(content);
                    content = addMarkup(content);
                    editor.setContent(content);  
                }
            })
            jQuery(".wp-editor-wrap").on("click","#content-html",function(){
                var content = editor.getContent();
                editor.setContent( cleanMarkup(content) );
                jQuery(".wp-editor-area").val( cleanMarkup(jQuery(".wp-editor-area").val()) );
            }) 
            ed.on("focus", function(ed, e) {
                if(isEnabled){
                    var content = editor.getContent();
                    content = cleanMarkup(content);
                    content = addMarkup(content);
                    editor.setContent(content);
                }
            });           
            ed.on('LoadContent', function(ed, e){
                if(isEnabled){
                    var content = editor.getContent(); 
                    content = cleanMarkup(content);                
                    content = addMarkup(content);                
                    editor.setContent(content);
                }
            });         
        }
    });
    tinymce.PluginManager.add( 'shortcode_highlighter', tinymce.plugins.ShortcodeHighlighter );
})();