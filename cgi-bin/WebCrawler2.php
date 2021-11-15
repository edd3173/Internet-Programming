
<html>
<body>
<?php

include('simplehtmldom_1_9_1/simple_html_dom.php');

// Create DOM from URL or file
// echo file_get_html('http://www.chosun.com/')->plaintext;

$url = $_POST["url"];
echo $url."<br>" ;

$tag = $_POST["tag"];
echo $tag."<br>" ;


$html  =  file_get_html($url);

/*
echo " SCRIPTS <br> " ;

// Find all images
foreach($html->find('script') as $element)
        echo $element->src . '<br>';

echo "  <br> SCRIPTS DONE <br> <br>";

echo " ANCHOR <br> ";

// Find all links
foreach($html->find('a') as $element)
       echo $element->href . '<br>';

echo " <br> ANCHOR DONE <br> <br>";
*/

echo "*** $tag START ***<br>" ;

foreach($html->find($tag) as $element)
    echo $element . '<br>';
        //echo $element->src . '<br>';


echo "*** $tag DONE***<br>" ;


?>

</body>
</html>

