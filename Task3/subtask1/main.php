<?php
    // check source string in command-line arguments
    if($argc < 2){
        die("\033[31mSpecify source string in command-line arguments!\033[39m\n");
    }
    // using pattern for find 'number'
    $pattern = '/\'(\d+)\'/';
    // source string from command-line arguments
    $source_string = $argv[1];
    // get result string by replacing every pattern-number
    $result_string = preg_replace_callback(
        $pattern,
        // using anonymous function
        function ($matches){
            return '\'' . $matches[1] * 2 . '\'';
        },
        $source_string
    );
    echo "Source: " . $source_string . "\n";
    echo "Result: " . $result_string . "\n";