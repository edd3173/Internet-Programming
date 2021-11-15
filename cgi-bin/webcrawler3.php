
<html>
<body>

<?php

include('simplehtmldom_1_9_1/simple_html_dom.php');

// Create DOM from URL or file
// echo file_get_html('http://www.chosun.com/')->plaintext;

$COUNT = 0;

$Domains = array();
$Anchors = array();

$AnchPos = 0;


$url = $_POST["url"];
echo $url."<br>" ;

$html  =  file_get_html($url);

array_push($Domains,GetDomain($html));

array_push($Anchors,$url);
//array_push($urlArr,$url);

echo " ANCHOR START <br> ";

echo $COUNT; echo ". "; echo $url.'<br>';
$COUNT++;

while(1){
        // Get $html
        
        foreach($html->find('a') as $element){

                // STEP 1 : Get Anchor 

                //Get Current Anchor
                $CurAnch=$element->href;

                //Echo it if needed
                //echo $CurAnch, "<br>";

                // Filter Reliable Anchors
                if(strncmp("https://", $CurAnch, 8) == 0 || strncmp("http://", $CurAnch, 7) == 0){
                        
                        //STEP 2 : Get Current Domain
                        $CurDomain = GetDomain($CurAnch);
                        
                        //Echo it if needed
                        //echo($CurDomain. "<br>");
                 

                        //STEP 3 : Filter And Cook

                        //If current Anchor's Domain is NOT Duplicate
                        if(CheckDuplicates($Domains,$CurDomain)==0){

                                //echo "Non-Duplicate! <br>";

                                //Push it into Domain List
                                array_push($Domains,$CurDomain);
                                
 
                                //Push it into Anchor List, since we maybe need to come back
                                array_push($Anchors,$CurAnch);
                                //Echo it  if needed
                                echo $COUNT; echo ". "; echo $CurAnch.'<br>';


                                //Update url,html for next iteration
                                $url=$CurAnch;
                                $html  =  file_get_html($url);
                                
                                // Like stack, we update Position
                                $AnchPos++;
                                
                                //Update COUNT
                                $COUNT++;

                                //Echo if needed
                                //echo "COUNT:";
                                //echo ($COUNT. "<br>");

                         }

                        //If current Anchor's Domain is Duplicate
                        // Do Nothing
                }

                // Escape 
                if($COUNT==20){
                        break;
                }
        }
        // Happens when url's 1st anchor has less than 20 anchors
        
        // We pop, and return to latest Anchor we visited
        array_pop($Anchors);

        // latest Anchor
        $AnchPos--;

        //update url and html
        $url = $Anchors[$AnchPos];
        $html = file_get_html($url);


        //Escape Condition
        if($COUNT==20){
                break;
        }
}

echo " ANCHOR DONE <br> ";

/*
echo "<br> 20 Anchors? <br>";
for($i=0; $i<count($Anchors); $i++){
        echo ($Anchors[$i]. "<br>");
}
*/


//Function To Check Duplicates
function CheckDuplicates($Array,$Val){
        for($i=0;$i<count($Array);$i++){
                if($Array[$i]==$Val){
                        return 1;
                }
        }
        return 0;
}

// Function To Get Domain using parse_url
function GetDomain($URL){
        $parsedURL = parse_url($URL);
        return $parsedURL['host'];
}

?>

</body>
</html>

