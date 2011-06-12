(function($) {

    $.widget("ui.textToAudio", {
        options: {
            speakText: 'No text was provided',
            url: 'espeakToOggService.php',
            attributesAudio: {
                controls: 'controls'    
            }
        },
        _create: function() {
            var self = this,
                o = self.options,
                el = self.element,
                uiTextToAudio = $(self.uiTextToAudio = $("<div></div>"))
                    .appendTo(el)
                audioElement = $(self.audioElement = $('<audio />',o.attributesAudio))
                    .appendTo(uiTextToAudio)
                    .hide(),
                waitElement = $(self.waitElement = $('<span />'))
                    .css({
                        'display': 'inline-block'
                    })
                    .appendTo(uiTextToAudio)
                    .hide();
            self._loadAudio();
            self._trigger("added", null, uiTextToAudio);
        },
        _loadAudio: function() {
            var self = this,
                o = self.options,
                el = self.element,
                au = self.audioElement,
                wait = self.waitElement;
            $.ajax({
                url: o.url,
                type: "POST",
                data : {
                    speakText : o.speakText
                },
                dataType : "json",
                beforeSend: function(XMLHttpRequest, settings) {
                    wait.show();
                },
                success: function(espeakToOggServiceResponse, textStatus, XMLHttpRequest) {
                    wait.hide();                    
                    au.attr("src","data:audio/ogg;base64,"+espeakToOggServiceResponse.oggaudioBase64)
                    .show();
                }
            });
            
        },
        destroy: function() {
            this.audioElement.remove();
            this.waitElement.remove();
        },
        _setOption: function(option, value) {
            $.Widget.prototype._setOption.apply( this, arguments );

            var self = this,
                el = self.element,
                o = self.options,
                au = self.audioElement;

            switch (option) {
                case "speakText":
                    o.speakText = value;
                    self._loadAudio();
                    break;
                case "attributesAudio":
                    o.attributesAudio = $.extend({},o.attributesAudio,value);                    
                    $.each(o.attributesAudio,function(key,value) {
                        au.attr(key,value);
                    });
                    break;
                case "removeAudioAttribute":
                    delete o.attributesAudio[value];
                    au.removeAttr(value);                    
                    break;
                case "url":
                    o.url = value;
                    break;
            }
        }        
    });
})(jQuery);        