<?php

function scanFolder($inst) {
    
        if (is_dir($input)) {

            // PHP 8
            if (!str_ends_with($input, '/')) {
                $folder = rtrim($input, '/');
            };
            
            // Contains imgs to process
            $files = [];
            $wrong = [];

            // Rec folder iterator
            function iterate($folder, $rec = false) {
                global $files, $wrong;

                foreach (glob($folder . '/*') as $filename) {
                    if ($rec == true) {
                        if (is_dir($filename)) {
                            iterate($filename, true);
                        };
                    };
    
                    if (mime_content_type($filename) == 'image/png') {
                        $files[] = $filename;
                    };

                    if (mime_content_type($filename) != 'image/png' && !is_dir($filename)) {
                        $wrong[] = $filename;
                    };
                };

                return [$files, $wrong];
            };

            // Handles rec option
            if ($inst['recursive']) {
                $result = iterate($folder, true);
            } else $result = iterate($folder);
            $files = $result[0];
            $wrong = $result[1];
            

            if ($files > 0) {
                if ($wrong > 0) {
                    $c = count(($wrong));
                    if ($c == 1) {
                        echo "Votre dossier contient un fichier qui n'est pas au format PNG. il sera ignoré.\n";
                    } else {
                        echo "Votre dossier contient $c fichiers qui ne sont pas au format PNG. Ils seront ignorés.\n";
                    };
                };

                // return only the first n files (specified by -c option)
                return $files = $inst['columns'] == null ? $files : array_slice($files, 0, $inst['columns']);
            } else {
                echo "Le dossier donné ne contient aucun fichier sous le format PNG.";
                return;
            };

        } else if (strpos($input, '-') != false || strpos($input, '--') != false) {
            echo "\033[31m". "En plus des options, votre commande doit contenir un fichier.\n";
            return false;
        } else {
            return false;
        };
};