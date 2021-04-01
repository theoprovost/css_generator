<?php

function writeCss($infos, $inst) {
    $file_name = $inst['sheet_name'];
    $img_name = $inst['img_name'];
    $length = $infos['total_length'];
    $nbr = $infos['total_nbr'];


    $css = fopen('./cli/result/' . $file_name, 'w')
        or die('Erreur à la création du fichier.');

    if ($css) {
        // haven't used img tag to avoid "placeholder" grey border
        $img_css = ".sprite {\n    width: calc(400px);\n    height: calc(400px);\n    background-image: url(\"../result/$img_name\");\n    background-position: 0 0;\n    background-size: calc(100% * $nbr) 100%;\n}\n\n";

        fwrite($css, $img_css);

        foreach ($infos as $key => $val) {
            static $n = 1;

            if (is_int($key)) {
                $txt = "#img$n {\n    background-position: calc((100% / ($nbr - 1)) * ($n - 1)) 0;\n}\n\n";

                fwrite($css, $txt);
                $n++;
            };
        };

        // echo "Le fichier $file_name a été créé avec succès.\n";
        return true;
    } else {
        echo "Il y a eu une erreur au moment de l'écriture du fichier de style.\n";
        return false;
    };
};