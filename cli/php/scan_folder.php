<?php

function scanFolder($inst)
{
    global $argc, $argv;

    if ($argc > 1) {
        $input = $argv[$argc - 1];

        if (is_dir($input)) {

            // PHP 8
            if (!str_ends_with($input, '/')) {
                $folder = rtrim($input, '/');
            } else {
                // The el is not a folder and then should be ignored
                echo "Le répértoire spécifié n'est pas un dossier.\n";
                return;
            }

            // Contains imgs to process // DELETE ??
            // $files = [];
            // $wrong = [];

            // Rec folder iterator
            function iterate($folder, $rec = false)
            {
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
                        echo "❗Votre dossier contient un fichier qui n'est pas au format PNG. Il sera ignoré.\n";
                    } else {
                        echo "❗Votre dossier contient $c fichiers qui ne sont pas au format PNG. Ils seront ignorés.\n";
                    };
                };

                return $files;
            } else {
                echo "Le dossier donné ne contient aucun fichier sous le format PNG.";
                return;
            };
        } else if (strpos($input, '-') != false || strpos($input, '--') != false) {
            echo "\033[31m" . "En plus des options, votre commande doit contenir un fichier.\n";
            return false;
        } else {
            echo "\033[31m" . "Le dernier élèment \"$input\" n'est pas un dossier.\nVeuillez renseigner une commande sous ce format : SCRIPT [OTPION(S)] DOSSIER.\n";
            return false;
        };
    } else {
        echo "\033[31m" . "Vous devez renseigner un dossier contenant vos images.\n";
        return false;
    };
};
