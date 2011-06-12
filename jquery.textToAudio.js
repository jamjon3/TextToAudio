(function($){
    $.fn.textToAudio = function(settings) {
        settings = jQuery.extend({
            speakText: 'No text was provided',
            url: 'espeakToOggService.php',
            controls: "controls",
            autoplay: false,
            waitMessage: "Please wait while loading.."
        },settings);
        return this.each(function() {
            var element = $(this);
            element.data('audioElement',$('<audio />',{
                    controls: settings.controls
                })
                .css({
                    "display":"inline-block"
                })
                .appendTo(element)
                .hide()
            );
            element.data('waitElement',$('<span />')
                .html(settings.waitMessage)
                .appendTo(element)
                .hide()
            );
            element.data('settings',settings);
            $.ajax({
                url: element.data('settings').url,
                type: "POST",
                data : {
                    speakText : element.data('settings').speakText
                },
                dataType : "json",
                beforeSend: function(XMLHttpRequest, settings) {
                    element.data('waitElement').show();
                },
                success: function(espeakToOggServiceResponse, textStatus, XMLHttpRequest) {
                    element.data('waitElement').hide();
                    element.data('audioElement')
                    .attr("src","data:audio/ogg;base64,"+espeakToOggServiceResponse.oggaudioBase64)
                    .show();
                    if(element.data('settings').autoplay) {
                        element.data('audioElement')
                        .attr("autoplay","autoplay");
                    }
                }
            });
        });
    };
    
    
})( jQuery );