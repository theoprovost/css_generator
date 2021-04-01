<?php

function getInstructions() {
    global $argc;

    // Default values
    $instructions = [
        'recursive' => NULL, 
        'img_name' => 'sprite.png',
        'sheet_name' => 'style.css',
        'size' => NULL,
        'columns' => NULL,
        'padding' => NULL
    ];

    // handles man
    if ($argc == 2) {
        
        $help = getopt('h', ['help']);
        if (key_exists('h', $help) || key_exists('help', $help)) {
            man:

            echo "\nHELP MANUAL :\n\n";
            echo("    -h, --help\n            Display help.\n\n    -r, --recursive\n            Look for images into the assets_folder passed as arguement and all of its subdirectories.\n\n    -i, --output-image=IMAGE
            Name of the generated image. If blank, the default name is « sprite.png ».\n\n    -s, --output-style=STYLE
            Name of the generated stylesheet. If blank, the default name is « style.css ».\n\n    -o, --override-size=SIZE\n            Force each images of the sprite to fit a size of SIZExSIZE pixels.\n\n    -c, --columns_number=NUMBER\n            The maximum number of elements to be generated horizontally.\n\n\n");

            return;
        };
    };

    // Gets options from CLI
    if ($argc == 1) {
        goto man;
    } else if ($argc > 2) {
        $opt = getopt('hri:s:o:c:p:', ['help', 'recursive', 'output-image:', 'output-style:', 'override-size:', 'columns_number:', 'padding:']);

        if (isset($opt) && $opt > 0) {
            // Print the manual
            if (key_exists('h', $opt) || key_exists('help', $opt)) {
                goto man;
            };

            // Handles the 'recursivness' 
            if (key_exists('r', $opt) || key_exists('recursive', $opt)) {
                $instructions['recursive'] = true;
            };

            // Handles the output file name
            if (key_exists('i', $opt) || key_exists('output-image', $opt)) {
                $val = key_exists('i', $opt) ? $opt['i'] : $opt['output-image'];
                if (!str_ends_with($val, '.png')) {
                    $val .= '.png';
                };
                $instructions['img_name'] = $val;
            };
            
            // Handles the stylesheet name
            if (key_exists('s', $opt) || key_exists('output-style', $opt)) {
                $val = key_exists('s', $opt) ? $opt['s'] : $opt['output-style'];
                if (!str_ends_with($val, '.css')) {
                    $val .= '.css';
                };
                $instructions['sheet_name'] = $val;
            };

            // Handles the size of each element 
            if (key_exists('o', $opt) || key_exists('override-size', $opt)) {
                $val = key_exists('o', $opt) ? $opt['o'] : $opt['override-size'];
                $val = (int)$val;
               
                // Parsed user input (== 0 if not correctly casted)
                if ($val !== 0) {
                    $instructions['size'] = $val;
                } else {
                    echo "La taille doit être un nombre entier et être supérieur à 0.\n";
                    return;
                };
            };

            // Handles max n of columns
            if (key_exists('c', $opt) || key_exists('columns_number', $opt)) {
                $val = key_exists('c', $opt) ? $opt['c'] : $opt['columns_number'];
                $val = (int)$val;

                if ($val !== 0) {
                    $instructions['columns'] = $val;
                } else {
                    echo "Le nombre d'élément doit être un nombre entier et être supérieur à 0.\n";
                    return;
                };
            };

            // Handles padding option
            if (key_exists('p', $opt) || key_exists('padding', $opt)) {
                $val = key_exists('p', $opt) ? $opt['p'] : $opt['padding'];
                $val = (int)$val;

                if ($val !== 0) {
                    $instructions['padding'] = $val;
                } else {
                    echo "Le padding doit être un nombre entier et être supérieur à 0.\n";
                    return;
                };
            };
        };
    };

    return $instructions;
};