<?php

function generateSprite($files, $inst) {
    
    $imgs = [];
    $w = 0;
    $h = 0;

    foreach ($files as $file) {
        static $i = 0;

        // Create image ressource and crop surplus
        $imgs[] = [$file = imagecropauto(imagecreatefrompng($file), IMG_CROP_SIDES), imagesx($file), imagesy($file)]
        or die('Erreur à la récuppération des images.');
        // Gets the largest/tallest size of imgs
        $w = $w > $imgs[$i][1] ? $w : $imgs[$i][1];
        $h = $h > $imgs[$i][2] ? $h : $imgs[$i][2];

        $i++;
    };

    // By default : size of each element is equal to the biggest side of all ressources
    $max = $w > $h ? $w : $h;
    $square = $inst['size'] == null ? $max : $inst['size'];

    // Padding opt
    $pad = $inst['padding'] == null ? 0 : $inst['padding'];

    // Create sprite w/ transparent background
    $sprite = imagecreatetruecolor($square * count($imgs), $square);
    $background = imagecolorallocatealpha($sprite, 255, 255, 255, 127);
    imagefill($sprite, 0, 0, $background);
    imagealphablending($sprite, false);
    imagesavealpha($sprite, true);

    $infos = [];

    static $j = 0;
    static $margin_left = 0;
    foreach ($imgs as $img) {
        $old_x          =   $img[1];
        $old_y          =   $img[2];

        $new_width = $new_height = $square - $pad;

        // Resize operations
        if($old_x > $old_y) {

            $dest_w = $new_width;
            $dest_h = $old_y * ($new_height / $old_x);

        } else if ($old_x < $old_y) {

            $dest_w = $old_x * ($new_width / $old_y);
            $dest_h = $new_height;

        } else if ($old_x == $old_y) {

            $dest_w = $new_width;
            $dest_h = $new_height;
        };

        $margin_left = $j * $square;

        // Add new images into the sprite
        imagecopyresized($sprite, $img[0], $margin_left + ($pad / 2), 0 + ($pad / 2), 0, 0, $dest_w, $dest_h, $old_x, $old_y);

        // Add a constant interval to x axis point
        array_push($infos, $margin_left);
        $j++;
    };

    // Pass infos for css file generation
    $infos['total_nbr'] = count($imgs);
    $infos['total_length'] = $square * $infos['total_nbr'];
    
    // Actually create and save new sprite
    $name = $inst['img_name'];
    $sprite = imagepng($sprite, "./cli/result/$name");
    foreach ($imgs as $img) {
        imagedestroy($img[0]);
    };

    if ($sprite) {
        return $infos;
    } else {
        echo "\033[31m" . "Erreur lors de la création du sprite.";
        return false;
    };
};
