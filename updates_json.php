<?php
    require_once('db.php');

    function last_ten_created() {
    $sth = mysql_query("SELECT firstname,lastname,city,id FROM person order by created desc limit 10");
    return $sth;
}

$sth = last_ten_created();

$rows = array();

while($r = mysql_fetch_assoc($sth)) {
    $rows[] = $r;
}

print json_encode($rows);

?> 
