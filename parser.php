<?php
$ini_array = parse_ini_file("config.ini");

$url = $ini_array['url'].'?u='.$ini_array['username'].'&p='.$ini_array['password'];

$xml = simplexml_load_file($url) or die("Error loading xml!");

//TODO: Getting last article id must be here
//Hardcoded last id (just for testing)
$last_id = 33714;

foreach ($xml as $article) {
    $id = $article->articleId;
    if($last_id >= $id)
        break;
    else {
        //TODO: Save article to database

        //Following code requires allow_url_fopen set to true
        //TODO: Change image path
        copy($article->image, '\uploads' . '/' . $id . '.jpg');

        echo $id.' ';
    }
}
