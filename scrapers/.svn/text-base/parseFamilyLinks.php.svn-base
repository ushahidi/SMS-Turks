<?php


$host = 'dbmaster.famegame.com';
$user = 'haitiuser';
$pass = '77rescue';
$db = 'haiti';
$table = 'familylinks'; 
mysql_connect($host,$user,$pass) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());


$query = "SELECT * FROM familylinks WHERE parsed = 0 ";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());


while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $dob = $row['date_of_birth'];
    preg_match_all("/(\d*)\.(\d*)\.(\d*)/",$dob,$matches);
    $month = $matches[1][0];
    $month  = $month + 100;
    $month = substr($month, -2);
    
    $day = $matches[2][0];
    $day  = $day + 100;
    $day = substr($day, -2);
    
    $year = $matches[3][0];
    
    $age = 2009 - $year;
    
    $my_email =  $row['my_email'];
    $my_full_name =  $row['my_full_name'];
    $my_phone = $row['my_phone'];
    $my_place_of_residence = $row['my_place_of_residence'];
    $my_street = $row['my_street'];
    $my_postal_code = $row['my_postal_code'];
    $my_location = $row['my_location'];
    $my_country = $row['my_country'];
    $full_name = $row['full_name'];
    $sex = $row['sex'];
    $place_of_birth = $row['place_of_birth'];
    $place_of_residence = $row['place_of_residence'];
    $fathers_name = $row['fathers_name'];
    $mothers_name = $row['mothers_name'];
    $url = $row['url'];
    
    
    $id = idofPerson($row['url']);
    if($id != ""){
       // person is already in the DB
       // check to see if they have a searcher connected to them
       //if not add searcher
        
      if(!isSearcher($id)){
       
        $sql = 'INSERT INTO searcher (email,name,relationship,phone,person_id,place_of_residence,street,postal_code,location,country) VALUES ("' . $my_email . '","' . $my_full_name . '","","' . $my_phone . '","' . $id .'","' . $my_place_of_residence .'","' . $my_street .'","' . $my_postal_code .'","' . $my_location .'","' . $my_country .'")';
        
        print_r($sql);
        
        print "\r";
         
         $res2 = mysql_query($sql) or die('Query failed: ' . mysql_error());
      }
                
       
    }else{
        // person is not in the DB
        
         $sql = 'INSERT INTO person (firstname,fullname,age,gender,status,date_of_birth,place_of_birth,place_of_residence,fathers_name,mothers_name,source,url_link_back,created,updated) VALUES ("' . $full_name . '","' . $full_name . '","'. $age . '","' . $sex .  '","Missing","' . $year ."-" . $month . "-" . $day . '","' . $place_of_birth . '","' . $place_of_residence . '","' . $fathers_name .'","' . $mothers_name .  '","familylinks","' . $url . '","'  . time() . '","'  . time() . '")';
    
   $res3 = mysql_query($sql) or die('Query failed: ' . mysql_error());
    
    print_r($sql);
       print "\r";
       
       
        $sql = 'INSERT INTO searcher (email,name,relationship,phone,person_id,place_of_residence,street,postal_code,location,country) VALUES ("' . $my_email . '","' . $my_full_name . '","","' . $my_phone . '","' . mysql_insert_id() .'","' . $my_place_of_residence .'","' . $my_street .'","' . $my_postal_code .'","' . $my_location .'","' . $my_country .'")';
        
        print_r($sql);
        
        print "\r";
         
         $res4 = mysql_query($sql) or die('Query failed: ' . mysql_error());
       
       
        
        // add person to the DB
        // add searcher to the DB
    
    
    }

}


function idofPerson($url){
    
    $sql = 'SELECT * FROM person WHERE url_link_back = "' . $url . '"';
    
    //print "\n\n" . $sql . "\n\n";
    
    $res5 = mysql_query($sql) or die('Query failed: ' . mysql_error());
  
    if($row = mysql_fetch_array($res5, MYSQL_ASSOC)) {
  
   //     print_r("person found");
        return $row['id'];
    }else{
    
//    print_r("no person found");
        return false;
    }
} 


function isSearcher($id){
    
    $sql = 'SELECT * FROM searcher WHERE person_id = "' . $id . '"';
    
    //print "\n\n" . $sql . "\n\n";
    
    $res6 = mysql_query($sql) or die('Query failed: ' . mysql_error());
  
    if($row = mysql_fetch_array($res6, MYSQL_ASSOC)) {
  
   //     print_r("person found");
        return true;
    }else{
    
//    print_r("no person found");
        return false;
    }
} 


?>
