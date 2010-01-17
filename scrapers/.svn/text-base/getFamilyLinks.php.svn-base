<?php


$host = 'dbmaster.famegame.com';
$user = 'haitiuser';
$pass = '77rescue';
$db = 'haiti';
$table = 'familylinks'; 
mysql_connect($host,$user,$pass) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());

$hp = "http://www.familylinks.icrc.org/haiti/people";
parsethatshit($hp,0);

function parsethatshit($url,$max){
    $content = get_webpage_content($url);
    
    get_next_url_link($content,$max);
    
    $peoplelist = get_people_urls($content);
    
    foreach($peoplelist as $url){
          parse_person("http://www.familylinks.icrc.org/" . $url);
    }
    
}
function parse_person($url){
    
    if(isNotInDB($url)){  
    
    
        $person_data = get_webpage_content($url);
        
        preg_match_all("/face=\"Verdana\">([^<]*)<\/font><\/td><td width=\"\d+\" bgcolor=\"\#F7F7F7\">.?<b><font size=\"2\" face=\"Verdana\">([^<]*)<\/font>/",$person_data,$matches);
        
    //    print_r($matches);
        
       $sql = 'INSERT INTO familylinks (url,parsed,full_name,fathers_name,mothers_name,sex,date_of_birth,place_of_birth,place_of_residence,country,my_full_name,my_fathers_name,my_mothers_name,my_sex,my_date_of_birth,my_place_of_birth,my_place_of_residence,my_street,my_postal_code,my_location,my_country,my_phone,my_email,my_via) VALUES ("'. $url .'","0","'. $matches[2][0] . '","' . $matches[2][1] . '","' . $matches[2][2] . '","' . $matches[2][3] . '","' . $matches[2][4] . '","' . $matches[2][5] . '","' . $matches[2][6] . '","' . $matches[2][7] . '","' . $matches[2][8] . '","' . $matches[2][9] . '","' . $matches[2][10] . '","' . $matches[2][11] . '","' . $matches[2][12] . '","' . $matches[2][13] . '","' . $matches[2][14] . '","' . $matches[2][15] . '","' . $matches[2][16] . '","' . $matches[2][17] . '","' . $matches[2][18] . '","' . $matches[2][19] . '","' . $matches[2][20] . '","' . $matches[2][21] . '" )';
        
        
        print_r($sql);
        
        $result = mysql_query($sql) or die('Query failed: ' . mysql_error());

    }

}

function  get_webpage_content($url){
  
    print "sleeping for 1 seconds";
    sleep(1);

    $ch = curl_init ();
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch,CURLOPT_VERBOSE,1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec ($ch);
    curl_close ($ch);

    return $data;
}

function get_people_urls($homepage_data){

    preg_match_all("/WFL_HTI.NSF\/7cafc3ddbecb5354412567530027b6d6[^\"]*/",$homepage_data,$matches);

    return($matches[0]);

}

function isNotInDB($url){

    $query = "SELECT * FROM familylinks WHERE url = '" . $url . "'";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());

    if($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        return false;
    }else{
        return true;
    }

}

function get_next_url_link($content, $max){
     
     preg_match_all("/(\/WFL\_HTI\.NSF\/bottin\!OpenView)\&amp\;(Start\=)(\d+)\"><b><font size=\"1\" color=\"\#008080\" face=\"Arial\"><IMG SRC=\/WEBGRAPH\.NSF\/Graphics\/ViewNext/",$content,$matches);
     
     $nexturl = "http://www.familylinks.icrc.org" . $matches[1][0] . "&" . $matches[2][0]  . $matches[3][0];
     
     
     
     print_r($matches);
   
 //  print $nexturl;
   
   if($max != $matches[3][0]){
       parsethatshit($nexturl,$matches[3][0]);
     }
     
}

?>