<html>
    <head>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
    // has the google object loaded?
    if (window.google && window.google.load) {
        google.load("jquery", "1.6.1");
    } else {
        document.write('<script type="text/javascript" src="http://joecrawford.com/jquery-1.3.2.min.js"><\/script>');
    }
    window.onload = function() {
        $('#test').css({'border':'2px solid #f00'});
        $('div#useAudioPlugin').textToAudio({
            speakText: "I'm a jquery plugin that loads the audio from a service AJAX call!"
        });
        
        // Now let's create a form to produce anykind of text
        $('body').append(
            $('<h2 />')
            .html('This is a form usage of the JQuery plugin')
        );
        var element = $('<div />')
            .append(
                $('<span />')
                .css({
                    "display" :"inline-block",
                    "position": "relative",
                    "width": "100%"
                })
                .html('This is a form that allows you to specify any text to the JQuery plugin which will automatically play after submission.')
            )
            .appendTo('body');
        element.data('audioFormTextbox',$('<textarea />')
            .width(element.width())
            .appendTo(
                $('<div />')
                .appendTo(element)
            )
        );
        element.data('audioFormButton',$('<button />')
            .html('Click Button to Render Audio')
            .insertAfter(
                element.data('audioFormTextbox')
            )
            .click(function() {
                element.data('audioFormDiv').remove();
                element.removeData('audioFormDiv');
                element.data('audioFormDiv',$('<div />')
                    .insertAfter(
                        element.data('audioFormButton')
                    )
                );                                    
                if($.trim(element.data('audioFormTextbox').val()).length > 0) {
                    element.data('audioFormDiv').textToAudio({
                        speakText: $.trim(element.data('audioFormTextbox').val()),
                        autoplay: true
                    });
                }
            })
        );
        element.data('audioFormDiv',$('<div />')
            .insertAfter(
                element.data('audioFormButton')
            )
        );
    };
    </script>
    <script type="text/javascript" src="jquery.textToAudio.js"></script>
        
    </head> 
<body>
<?php
/*
 * Written by James Jones
 * June 12, 2011
 */

    include("espeakToOggService.php");
    
?>
<h1>Examples of Using Espeak and Oggenc via a PHP service.</h1>
<hr>
<h2>Inline PHP function call</h2>
<div id="inlineExample">
    <span style='display:inline-block;position: relative;width: 100%;'>This is an example of handling the call exclusively in PHP. There's a call to a included php function called "espeakService".</span>
    <p>
        <audio src="data:audio/ogg;base64,<?php echo base64_encode(espeak2ogg("I'm a function call that loads audio within PHP")); ?>" controls="controls">
        </audio>
    </p>
    <span style='display:inline-block;position: relative;width: 100%;'>This is an example of handling the call exclusively in PHP. There's a call to a included php function called "espeakService". This is a slight variation using the source tag. </span>
    <p>
        <audio controls="controls">
            <source src="data:audio/ogg;base64,<?php echo base64_encode(espeak2ogg("I'm a function call that loads audio within PHP")); ?>" type="audio/ogg" />
        </audio>
    </p>
</di</div>
<h2>AJAX JQuery Plugin (<a href="espeakUI.php">Check out the JQuery ui plugin - BEST and RECOMMENDED plugin!!</a>)</h2>
<div id='useAudioPlugin'>
    <p><span style='display:inline-block;position: relative;width: 100%;'>This is an example of a JQuery simple plugin that performs an AJAX call to retrieve the audio asyncronously.</span></p>
</div>
</body>
</html>