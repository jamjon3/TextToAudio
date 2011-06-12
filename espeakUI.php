<html>
    <head>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
    // has the google object loaded?
    if (window.google && window.google.load) {
        google.load("jquery", "1.6.1");
        google.load("jqueryui", "1.8.13");
    } else {
        document.write('<script type="text/javascript" src="http://dev.it.usf.edu/jquery-1.3.2.min.js"><\/script>');
    }
    window.onload = function() {
        var audioPluginElement = $('div#useAudioPlugin')
                .textToAudio({
                    speakText: "I'm a jquery ui plugin that loads the audio from a service AJAX call and I accept option updates after initialization."
                }),
            formDiv = $('<div />')
                .append(
                    $('<span />')
                    .css({
                        "display" :"inline-block",
                        "position": "relative",
                        "width": "100%"
                    })
                    .html('This is a form that allows you to specify any text to the JQuery plugin which will automatically play after submission.')
                )
                .insertAfter(audioPluginElement),
            audioFormTextbox = $('<textarea />')
                .width(formDiv.width())
                .appendTo(formDiv);
            audioFormButton = $('<button />')
                .html('Click Button to Render Audio')
                .insertAfter(audioFormTextbox)
                .click(function() {
                    if($.trim(audioFormTextbox.val()).length > 0) {
                        audioPluginElement.textToAudio('option','speakText',$.trim(audioFormTextbox.val()));
                        audioPluginElement.textToAudio('option','attributesAudio',{
                            'autoplay': 'autoplay'
                        });
                    } else {
                        alert('You must provide some text for audio to be rendered');
                    }
                });
    };
    </script>
    <script type="text/javascript" src="jquery.ui.textToAudio.js"></script>
        
    </head> 
<body>
<?php

?>
<h2>AJAX JQuery ui Plugin</h2>
<div id='useAudioPlugin'>
    <p><span style='display:inline-block;position: relative;width: 100%;'>This is an example of a JQuery simple ui plugin that performs an AJAX call to retrieve the audio asyncronously. It accepts configurable options so you can feed new text and properties via the plugin option calls (much more flexible and preferred functionality)</span></p>
</div>
<br>
<h1>How to set this up</h1>
<h2>Setting up the PHP AJAX service</h2>
<p class="classname">
    First thing is you will need to place the "espeakToOggService.php" somewhere in a web accessable path. In my example, it's in the current directory with this demo page.
</p>
<p class="classname">
    Next, you need to make SURE both "espeak" and "vorbis-tools" (specifically the "oggenc" within that package) are installed and in your path so they can be run from PHP.
</p>
<h2>Using the JQuery UI plugin</h2>
<p class="classname">
    Being a UI plugin, this plugin needs both jquery and jquery ui loaded in your page in addition to this plugin. In this demo, it's in the directory with my demo page so the script reference looks like:
</p>
<pre>
    script type="text/javascript" src="jquery.ui.textToAudio.js"
</pre>
<h3>Initializing the plugin</h3>
<p class="classname">
    It's easy to load this plugin. You'll want to give it some speach to render to audio in initializing it. Something like:
    <pre>
        $('div#test').textToAudio({
            speakText: "I'm a jquery ui plugin that loads the audio from a service AJAX call and I accept option updates after initialization."
        });
    </pre>
</p>
<p class="classname">
    You can pass two additional parameters to this being: url and attributesAudio
    <p class="classname">
        The attributesAudio allows you to set additional attributes to the audio tag. One useful one would be "autoplay". You can do that something like:
    <pre>
        $('div#test').textToAudio({
            speakText: "I'm a jquery ui plugin that loads the audio from a service AJAX call and I accept option updates after initialization.",
            attributesAudio: {
                "autoplay": "autoplay"
            }
        });
    </pre>
        ... and then the rendered sound will automatically play after loading from the ajax call
    </p>
    <p class="classname">
        The "url" option specifies the url of the service call. By default, it's simply 'espeakToOggService.php' as, in this demo, it's in the same directory with this demo.
        However, if it's on some other path, you'll need to specify it. You can use it by doing something like:
    <pre>
        $('div#test').textToAudio({
            speakText: "I'm a jquery ui plugin that loads the audio from a service AJAX call and I accept option updates after initialization.",
            url: '/someotherpath/espeakToOggService.php'
        });
    </pre>
        
    </p>
</p>
<h3>Post-initialization</h3>
<p class="classname">
    Like any other JQuery ui plugin, it's designed to allow you to pass options after the fact that is already bound to an element and initialized. Some examples would be:
    <pre>
        $('div#test').textToAudio("option","speakText","I'm rendering new text for the audio as this is written"); // This renders new audio for the already bound element
        $('div#test').textToAudio("option","url","/anotherplace/espeakToOggService.php"); // This changes the service url
        $('div#test').textToAudio("option","attributesAudio", {
                "autoplay": "autoplay"
        }); // Now, I just modified the attributes for the audio element to turn on autoplay so the loaded sound will immediately start playing
        $('div#test').textToAudio("option","removeAudioAttribute","autoplay"); // Allows you to remove an audio attribute where this one would turn off "autoplay"
    </pre>
    
</p>
<h3>
    Final thoughts
</h3>
<p class="classname">
    This plugin is very basic and can and probably should be extended. However, it is a functional proof of concept that works very well with the proof of concept service backing it.
</p>
</body>
</html>