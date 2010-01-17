<?php
    require_once('db.php');

    function all_person_records() {
        $sth = mysql_query("SELECT * FROM person order by id asc limit 10"); 
        return $sth;
    }

    function format_date( $date ) {
        date_default_timezone_set("UTC");
        $formatted_date = str_replace("+00:00", "Z", gmdate("c"));

        return $formatted_date;
    }
$sth = all_person_records();

$people = array();

while($r = mysql_fetch_assoc($sth)) {
    $people[] = $r;
}

echo ("<?xml version=\"1.0\" encoding=\"UTF-8\ ?>");

 ?>

<pfif:pfif xmlns:pfif="http://zesty.ca/pfif/1.1"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://zesty.ca/pfif/1.1
                               http://zesty.ca/pfif/1.1/pfif-1.1.xsd">


<?php foreach ($people as $p) {  ?>
    <pfif:person>
        <pfif:person_record_id>haitianquake.com/<?=$p['id'] ?></pfif:person_record_id>
        <pfif:entry_date><?= format_date($p['created']) ?></pfif:entry_date>
	<!-- leaving out author_name, author_email, author_phone -->

	<pfif:source_name><?=$p['id']?></pfif:source_name>

        
    </pfif:person>
<?php } ?>
</pfif:pfif>
