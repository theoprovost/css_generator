# Project #1 : Sprite generator

## 📖 **Abstract** :

This project is the first solo one done as part of my education at *[La Web@cadémie](https://www.webacademie.org/)*.

The subject was :

    " Au départ, nous avons un dossier contenant plusieurs images au format PNG. L’idée principale du projet est de développer un programme, qui concatène toutes ces images en un seul sprite.

    L’idée secondaire est de générer le fichier CSS représentant cette concaténation.

    Nous attendons un outil en ligne de commande uniquement. Cet outil doit fonctionner de la même manière que n’importe quelle commande UNIX et doit gérer aussi bien les options longues que les options courtes. "

The so-called manual will be explain hereinbelow. ⤵️

<br>

## 💻 CLI Project

### *Get started*
> To use this CLI project, you need installed beforehand :
> - PHP and it's dependecies
> - A CLI of your choice

> ⚠️ Please note : The project is intended to work with a minimum PHP version of PHP 8.0.0

First of all, download a copy on your machine :

    cd /the_folder_you_want
    git clone <gihub's project url>

Then, go to the project's folder and execute the appropriate command. Options cand be found later in this README or with the `[ -h | --help ]`  option :

    cd /the_project_name/cli
    php css_generator.php [options] folder/path/here


The ouputed sprite and related style sheet will be find in the `./cli/result/src` folder.

> 💡 If you want to test the programm without using your own images, just try it with the `./cli/test` folder.

Then, if you want to see the ouptputed sprite in a browser.

Launch a php server :

    php -S localhost:{PORT}

Navigate to the `index.php` file via :

    http://127.0.0.1:{PORT}/cli/result/index.php


And then use the arrows to navigate throught the different frames.


### *Manual*
Here is the manual as described in the subject :
```
MANUAL

    -h, --help
        Prints this manual.


    -r, --recursive
        Look for images into the assets_folder passed as arguement and all of its subdirectories.

    -i, --output-image=IMAGE
        Name of the generated image. If blank, the default name is « sprite.png ».

    -s, --output-style=STYLE
        Name of the generated stylesheet. If blank, the default name is « style.css ».

    -p, --padding=NUMBER
        Add padding between images of NUMBER pixels.

    -o, --override-size=SIZE
        Force each images of the sprite to fit a size of SIZExSIZE pixels.

    -c, --columns_number=NUMBER
        The maximum number of elements to be generated horizontally.
```
> Note that the last three options were part of the subject bonuses
<br>



#### Notes to myself :
- Make a generic index.php file when nothing has been generated yet :)