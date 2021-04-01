<?php

include_once('./php/get_instructions.php');
include_once('./php/scan_folder.php');
include_once('./php/generate_sprite.php');
include_once('./php/write_files.php');


function main()
{
    $inst = getInstructions();
    if ($inst) {
        $input_files = scanFolder($inst);
        if ($input_files) {

            // Init src folder
            $dir_content = glob('*/src/*');
            if (!empty($dir_content) || $dir_content !== FALSE) {
                foreach ($dir_content as $content) {
                    $content = realpath($content);
                    unlink($content);
                };
            };

            $infos = generateSprite($input_files, $inst);
            if ($infos) {
                $css = writeFiles($infos, $inst);
                if ($css) {

                    $img_name = $inst["img_name"];
                    $sheet_name = $inst["sheet_name"];
                    $t_size = $infos["total_wdith"] . "x" . $infos["total_height"];
                    $weight = $infos["weight"];

                    echo "\nFichier de style : ./result/src/$sheet_name\nFichier sprite : ./result/src/$img_name\nTaille totale : ${t_size}px - $weight\n";
                    echo "\n\n✨ La génération du sprite et l'écriture du fichier de style sont terminés.";
                } else {
                    echo "\n\n/!\Il y a eu erreur innatendue.";
                    return;
                };
            } else return;
        } else return;
    } else return;
};

main();
