<?php

function generateSprite($files, $inst)
{

    $imgs = [];
    $w = 0;
    $h = 0;

    foreach ($files as $file) {
        static $i = 0;

        // Create image ressource and crop surplus
        $imgs[] = [$file = imagecropauto(imagecreatefrompng($file), IMG_CROP_TRANSPARENT), imagesx($file), imagesy($file)]
            or die('Erreur à la récuppération des images.');

        // Gets the largest/tallest size of imgs
        $w = $w > $imgs[$i][1] ? $w : $imgs[$i][1];
        $h = $h > $imgs[$i][2] ? $h : $imgs[$i][2];

        $i++;
    };

    $count = count($imgs);

    // Padding opt
    $pad = $inst['padding'] == null ? 0 : $inst['padding'];

    // Columns_number opt
    $c = $inst['columns'] == null ? $count : $inst['columns'];

    // By default : size of each element is equal to the biggest side of all ressources
    $max = $w > $h ? $w : $h;
    $square = $inst['size'] == null ? $max : $inst['size'];

    // Make sure the width will be the smallest value btw total and specified opt -c
    if ($c > count($imgs)) {
        $c = $count;
    };

    // Size of the new image/sprite
    $width = ($square + ($pad * 2)) * $c;
    $height = ($square + ($pad * 2)) * (ceil(($count / $c)));

    // Create sprite w/ transparent background
    $sprite = imagecreatetruecolor($width, $height);
    imagealphablending($sprite, false);
    imagesavealpha($sprite, true);
    $background = imagecolorallocatealpha($sprite, 255, 255, 255, 127);
    imagefill($sprite, 0, 0, $background);

    $infos = [];

    static $j = 0;
    static $b = 0;
    foreach ($imgs as $img) {
        $old_x          =   $img[1];
        $old_y          =   $img[2];

        $new_width = $new_height = $square;

        // Resize operations
        if ($old_x > $old_y) {

            $dest_w = $new_width;
            $dest_h = $old_y * ($new_height / $old_x);
        } else if ($old_x < $old_y) {

            $dest_w = $old_x * ($new_width / $old_y);
            $dest_h = $new_height;
        } else if ($old_x == $old_y) {

            $dest_w = $new_width;
            $dest_h = $new_height;
        };

        // Iteration pattern
        if ($j == $c) {
            $j = 0;
            $b++;
        }

        // Defines the left interval
        $margin_left = $j * ($square + ($pad * 2));

        // Defines the top interval
        $margin_top = $b * ($square + ($pad * 2));

        // Add new images into the sprite
        imagecopyresized($sprite, $img[0], $margin_left + $pad, $margin_top + $pad, 0, 0, $dest_w, $dest_h, $old_x, $old_y);

        $j++;

        array_push($infos, [$margin_left, $margin_top]);
    };

    // Pass infos for css file generation
    $infos['total_nbr'] = $count;
    $infos['total_wdith'] = imagesx($sprite);
    $infos['total_height'] = imagesy($sprite);

    // Actually create and save new sprite
    $name = $inst['img_name'];
    $sprite = imagepng($sprite, "./result/src/$name");

    // Human friendly size convector
    function convertBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        };

        return $bytes;
    };

    $infos['weight'] = convertBytes(filesize("./result/src/$name"));

    // Frees memory associated w/ images
    foreach ($imgs as $img) {
        imagedestroy($img[0]);
    };

    if ($sprite) {
        echo "➡️ Le fichier de sprite été créé avec succès.\n";
        return $infos;
    } else {
        echo "\033[31m" . "Erreur lors de la création du sprite.";
        return false;
    };
};
