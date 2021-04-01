<?php

function writeFiles($infos, $inst)
{
    $file_name = $inst['sheet_name'];
    $img_name = $inst['img_name'];
    $nbr = $infos['total_nbr'];

    $css = fopen('./result/src/' . $file_name, 'w')
        or die('Erreur à la création du fichier.');

    if ($css) {
        // haven't used img tag to avoid "placeholder" grey border
        $img_css = ".sprite {\n    width: calc(400px);\n    height: calc(400px);\n    background-image: url(\"./$img_name\");\n    background-position: 0 0;\n}\n\n";

        fwrite($css, $img_css);

        foreach ($infos as $key => $val) {
            static $n = 1;

            if (is_int($key)) {
                $width = $val[0];
                $height = $val[1];

                $txt = "#img$n {\n    background-position: $width $height;\n}\n\n";

                fwrite($css, $txt);
                $n++;
            };
        };

        fclose($css);

        // index.php file update to hava total numbers of elements
        $html = './result/index.php';
        $l = 14;

        $content = file($html, FILE_IGNORE_NEW_LINES);
        array_splice($content, 14, count($content) - 15);

        // Handles name of css file
        $content[4] = "    <link rel=\"stylesheet\" href=\"./src/$file_name\">";

        // Handles eof + make n accessible to frontend
        $n = $n - 1;
        $content[$l] = "    <script type=\"text/javascript\">\n        const t = $n;\n    </script>\n    <script src=\"./js/script.js\"></script>\n</body>\n<html>";

        // Note : <=> fopen(), fwrite() et fclose();
        file_put_contents($html, implode("\n", $content));

        echo "➡ Le fichier de style a été créé avec succès.\n";
        return true;
    } else {
        echo "Il y a eu une erreur au moment de l'écriture du fichier de style.\n";
        return false;
    };
};
