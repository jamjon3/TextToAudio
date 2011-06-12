<?php
    if(isset($_POST['speakText'])) {
        /* soak in the passed variable or set our own */
        $speakText = isset($_POST['speakText']) ? $_POST['speakText'] : 'No text was provided';
        header('Content-type: application/json');
        echo json_encode(array('oggaudioBase64'=>base64_encode(espeak2ogg($speakText))));        
    }
    
    // Depreciated - Using the pipe between the commands works faster and handles large segments of text where I was seeing the problem in this incarnation
    function espeakService($textToSpeak) {
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
           1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
           2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
        );
        // define current working directory where files would be stored
        $cwd = '/tmp' ;
        $env = array();
        $oggOutput = 'error';
        // open espeak process    
        $process = proc_open('espeak --stdin --stdout', $descriptorspec, $pipes, $cwd, $env);
        if (is_resource($process)) {
            // anatomy of $pipes: 0 => stdin, 1 => stdout, 2 => error log
            // send the text to stdin of espeak
            fwrite($pipes[0], $textToSpeak) ;
            fclose($pipes[0]) ;
            // get the wav binary output from stdout of espeak
            $wavOutput = stream_get_contents($pipes[1]) ;    
            // close process
            $return_value = proc_close($process);
        }
        $process = proc_open('oggenc -', $descriptorspec, $pipes, $cwd, $env);
        // open oggenc process    
        if (is_resource($process)) {
            // anatomy of $pipes: 0 => stdin, 1 => stdout, 2 => error log
            // send the wav output of speak to stdin of oggenc    
            fwrite($pipes[0], $wavOutput) ;
            fclose($pipes[0]) ;
            // get the ogg binary output from stdout of oggenc    
            $oggOutput = stream_get_contents($pipes[1]) ;
            // close process
            $return_value = proc_close($process);
        }
        // return the ogg output    
        return $oggOutput;
    }
    

    function espeak2ogg($textToSpeak) {
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
           1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
           // 2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
           2 => array("pipe", "w") // stderr is a pipe that the child will write to (use "a" to append)
        );
        // define current working directory where files would be stored
        $cwd = '/tmp' ;
        $env = array();
        $oggOutput = 'error';
        // open espeak process
        if (PHP_OS === 'WINNT') {
            $process = proc_open('espeak.exe --stdin --stdout | oggenc.exe -', $descriptorspec, $pipes, $cwd, $env);
        } else {
            $process = proc_open('espeak --stdin --stdout | oggenc -', $descriptorspec, $pipes, $cwd, $env);
        }
        if (is_resource($process)) {
            // anatomy of $pipes: 0 => stdin, 1 => stdout, 2 => error log
            // send the text to stdin of espeak
            fwrite($pipes[0], $textToSpeak) ;
            fclose($pipes[0]) ;
            // get the ogg binary output from stdout of espeak piped to oggenc
            $oggOutput = stream_get_contents($pipes[1]) ;    
            // close process
            $return_value = proc_close($process);
        }
        // return the ogg output    
        return $oggOutput;
    }
    
?>