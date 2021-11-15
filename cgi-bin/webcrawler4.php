<html>
<body>
<?php
include('simplehtmldom_1_9_1/simple_html_dom.php');

// Create DOM from URL or file
// echo file_get_html('http://www.chosun.com/')->plaintext;
$url = $_POST["url"];
echo "1. "; echo $url."<br>";

$domain = getDomain($url);
$domainArr = array($domain);
$html = file_get_html($url);

$count = 1;
$flag = 0;
$urlArr = array($url);
$urlpos = 0;
while(1){
        foreach($html->find('a') as $element){
                if(strncmp("https://", $element->href, 8) == 0 || strncmp("http://", $element->href, 7) == 0){
                        $anchor = $element->href;
                        $domainNew = getDomain($anchor);
                        for($i=0;$i<$count;$i++)
                                if($domainArr[$i] == $domainNew)
                                        $flag = 1;
                        if($flag == 1)
                                $flag = 0;
                        else{
                                array_push($domainArr, $domainNew);
                                echo $count+1; echo ". "; echo $element->href.'<br>';
                                $url = $element->href;
                                $html = file_get_html($url);
                                array_push($urlArr, $url);
                                $urlpos++;
                                $count++;
                                if($count == 20){
                                        break;
                                }
                        }
                }
        }
        if($count == 20){
                break;
        }
        if($urlpos == 0)
                break;
        array_pop($urlArr);
        $urlpos--;
        $url = $urlArr[$urlpos];
        $html = file_get_html($url);
}

function getDomain($url){
        $parse = parse_url($url);
        return $parse['host'];
}
?>
</body>
</html>