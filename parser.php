<?php

include_once "mysql.php";

$ini_array = parse_ini_file("config.ini");

$url = $ini_array['url'].'?u='.$ini_array['username'].'&p='.$ini_array['password'];

$xml = simplexml_load_file($url) or die("Error loading xml!");

$mysql->select("articleID", articles, "", "", "", "id", "DESC", "0", "1");

$last_id = $mysql->rows[0][0];

foreach ($xml as $article) {
    $id = $article->articleId;
    if($last_id >= $id)
        continue;
    else {
        $todayh = getdate();
        $d = $todayh['mday'];
        $m = $todayh['mon'];
        $y = $todayh['year'];
        $img = $id . '.jpg';
        $mysql->insert(articles, "publishdate, period, articleID, title, descr, text, pict",
            "'$y-$m-$d', '$article->periode', '$id', '".addslashes($article->headline)."', '".addslashes($article->subheadline)."',
            '".addslashes($article->text)."', '$img'");

        copy($article->image, $_SERVER['DOCUMENT_ROOT'] . '/picts' . '/' . $img);
        echo "Processing article with id " . $id . " <br>";
    }
}
echo "All done!";


