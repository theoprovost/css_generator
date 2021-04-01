<?php
require_once '../php/generate_sprite.php';
require_once '../php/scan_folder.php';
require_once '../php/write_css.php';

function main($folder, $inst) {
        $input_files = scanFolder($inst);
        if ($input_files) {
            $infos = generateSprite($input_files, $inst);
            if ($infos) {
                $css = writeCss($infos, $inst);
                if ($css) {
                    echo "\n\nLa génération du sprite et l'écriture du fichier de style sont terminés.";
                    
                    $n = 3;

                } else {
                    echo "\n\n/!\Il y a eu erreur innatendue.";
                    return;
                };
            } else return;
        } else {
            echo "N'est pas un fichier";
            return;
        }

};
