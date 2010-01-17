<?php
// This code provides basic localization by means of an array containing translations and functions
// to concisely access the elements of the array

// This variable should be set by the user (probably by clicking on a flag icon),
// but I'm a noob and don't know how - ericc
// Here's a basic handler for it, we just need some links (flags) added. We probably make this a cookie instead of just a global variable. -Gar
global $LANG;
if (isset($_COOKIE['lang']))
	$LANG = $_COOKIE['lang'];
if (isset($_GET['lang']))
{
	$LANG = $_GET['lang'];
	setcookie("lang",$LANG);
	//header('Location: /');
}
else if (!isset($LANG))
{
	$LANG = "en_US";
	//setcookie("lang",$LANG);
	//header('Location: /');
}

function msg($s) {
    global $LANG;
    global $messages;
    
	if (isset($messages[$LANG][$s])){
	    $str = $messages[$LANG][$s];
        $str = htmlentities($str);
        $str = preg_replace('/&lt;/', '<', $str);
        $str = preg_replace('/&gt;/', '>', $str);
        
	return $str;
    }else{
		return $s; //error_log("l10n error:LANG:"."$lang,message:'$s'");
       }
}

function pmsg($s) {
    print msg($s);
}

$messages = array (
    'en_US'=> array(
		'index_page_title' => 'Haitian Quake Person Database',
		'index_logo_name' => 'Haitian Earthquake Registry',
		'index_intro' => 'This site is for locating people who have been<br />
			affected by the <a href=http://en.wikipedia.org/wiki/2010_Haiti_earthquake>earthquake in Haiti</a>. Please search<br />
			before you add, to avoid duplicate records. Please<br />
			<a href=mailto:haitianquake@gmail.com>contact us</a> if you have any site issues or questions.<br />
			<div style=float:right><a href=mailto:haitianquake@gmail.com>--- HaitianQuake.com team</a></div>',
		'search_intro' => 'If you don\'t see who you are looking for, you can <a href=add_record.php>add them to the database.</a>',
		'index_totalrecords1' => 'There are currently ',
		'index_totalrecords2' => ' available records.',
		'search_nothing_found' => 'No results found. <a href=/index.php>Search again</a>',
		'View All Records' => 'View All Records',
		'Search for someone' => 'Search for someone',
		'Name' => 'Name',
		'City' => 'City',
		'Recently Added' => 'Recently Added',
		'Last Name' => 'Family Name',
		'First Name' => 'Given Name',
		'Status' => 'Status',
		'Haitian Quake' => 'Haitian Quake',
		'Last Updated at ' => 'Last Updated at ',
		'Enter information' => 'Enter information',
		'Age' => 'Age',
		'Gender' => 'Gender',
		'Address' => 'Address',
		'Department' => 'Department',
		'Current location' => 'Current location',
		'Current contact information' => 'Current contact information',
		'Url link back' => 'Url link back',
		'Source' => 'Source',
		'Data entry initials' => 'Data entry initials',
		'person_my_information' => '<h3>My Information (optional)</h3><em>If you submit your information, we will try to contact you if this person is located.</em>',
		'Missing' => 'Missing',
		'Wounded' => 'Wounded',
		'Survived' => 'Survived',
		'Deceased' => 'Deceased',
		'Other' => 'Other',
		'Email' => 'Email',
		'Phone' => 'Phone',
		'Relationship to Missing Person' => 'Relationship to Missing Person',
		'Photos' => 'Photos',
		'View full photo' => 'View full photo',
		'Add a Photo' => 'Add a Photo',
		'Notes' => 'Notes',
		'Add A Note' => 'Add A Note',
		'Changes Made' => 'Changes Made',
		'Change' => 'Change',
		'Old Version' => 'Old Version',
		'New Version' => 'New Version',
		'Time' => 'Time',
		'Your Name:' => 'Your Name:',
		'Note:' => 'Note:',
		'Search' => 'Search',
		'Submit' => 'Submit',
		'Browse' => 'Browse',
		'Upload' => 'Upload',
		'Send Comment' => 'Send Comment',
		'Showing Results' => 'Showing Results',
		'to' => 'to',
		'of' => 'of',
		'Search Results' => 'Search Results',
		'Add A Record' => 'Add A Record',
		'Upload Images' => 'Upload Images',
		'Sources We Aggregate' => 'Sources We Aggregate',
		'Primary Language' => 'Primary Language',
		'Total Records' => 'Total Records',
		'Recent Successes' => 'Recent Successes'
    ),


	// these should be Haitian translations on the right
	'ht'=> array(
		'index_page_title' => 'Lis moun nan tranbleman tè Ayiti a',
		'index_logo_name' => 'Rejis moun nan tranbleman tè Ayiti a',
		'index_intro' => '<p>Sèvi ak sit entènèt sa a pou w pataje enfòmasyon sou moun ou konnen viktim tranbleman tè Ayiti a.</p>
			<p>Tanpri, se pou w chèche moun lan anvan ou mete enfòmasyon sou li nan lis la. Ekri n nan <a href=mailto:haitianquake@gmail.com>haitianquake@gmail.com</a> pou w fè yon rapò si sit entènèt la gen pwoblèm.</p>',
		'search_intro' => 'Si w pa wè moun w ap chèche a, ou ka <a href=add_record.html>mete non l nan lis la.</a>',
		'search_nothing_found' => 'Pa jwenn anyen. <a href=/index.php>Chèche ankò</a>',
		'View All Records' => 'Wè tout enfòmasyon yo',
		'Search for someone' => 'Chèche yon moun',
		'Name' => 'Non',
		'City' => 'Vil',
		'Recently Added' => 'Fèk ajoute',
		'Last Name' => 'Siyati',
		'First Name' => 'Non',
		'Status' => 'Pozisyon',
		'Haitian Quake' => 'Tranbleman tè Ayiti',
		'Last Updated at ' => 'Mete ajou dènye fwa ',
		'Enter information' => 'Mete enfòmasyon an',
		'Age' => 'Laj',
		'Gender' => 'Gason/Fi',
		'Address' => 'Adrès',
		'Department' => 'Depatman',
		'Current location' => 'Kote li ye kounye la',
		'Current contact information' => 'Kijan pou pran kontak ak li kounye a',
		'person_my_information' => '<h3>Enfòmasyon sou mwen (pa obligatwa)</h3><em>Si w mete enfòmasyon sou ou, konnen n ap eseye pran kontak ak ou si n jwenn moun ou an.</em>',
		'Missing' => 'Pèdi',
		'Wounded' => 'Blese',
		'Survived' => 'Vivan',
		'Deceased' => 'Mouri',
		'Other' => 'Lòt',
		'Email' => 'Adrès imel',
		'Phone' => 'Nimewo telefòn',
		'Relationship to Missing Person' => 'Sa w ye pou moun ki pèdi a',
		'Photos' => 'Foto',
		'View full photo' => 'Wè tout foto a',
		'Add a Photo' => 'Mete yon lòt foto',
		'Notes' => 'Nòt',
		'Add A Note' => 'Ekri yon ti nòt',
		'Changes Made' => 'Chanjman yo fèt',
		'Change' => 'Chanje',
		'Old Version' => 'Ansyen enfòmasyon',
		'New Version' => 'Nouvo enfòmasyon',
		'Time' => 'Ki lè li ye',
		'Your Name:' => 'Kijan ou rele:',
		'Note:' => 'Nòt:',
		'Search' => 'Chèche',
		'Submit' => 'Soumèt',
		'Browse' => 'Gade',
		'Upload' => 'Telechaje',
		'Add A Record' => 'Ekri yon enfòmasyon yo',
		'Send Comment' => 'Mete yon kòmantè',
		'Showing Results' => 'Montre rezilta yo',
		'to' => 'pou',
		'of' => '',
		'Search Results' => 'Rezilta rechèch la'
	),

    // these should be french translations on the right
	'fr'=> array(
		'index_page_title' => 'Base de données des Personnes - Tremblement Haïtien',
		'index_logo_name' => 'Enregistrement du Tremblement Haïtien',
		'index_intro' => '<p>Utilisez ce site pour partager des informations des gens qui vous connaissez qui sont affectés par le tremblement de terre à Haïti.</p>
			<p>S\'il vous plait, cherchez son nom avant d\'ajouter l\'information dÕune personne. Vous pouvez nous contacter à <a href=mailto:haitianquake@gmail.com>haitianquake@gmail.com</a> pour rapporter des problmes avec le site.</p>',
		'search_intro' => 'Si vous ne voyez pas la personne qui vous cherchez, vous pouvez  <a href=add_record.html> lui ajouter à la base de données.</a>',
		'search_nothing_found' => 'Aucuns résultats trouvés. <a href=/index.php>Chercher encore</a>',
		'View All Records' => 'Regarder tous les rapports',
		'Search for someone' => 'Chercher quelqu\'un',
		'Name' => 'Nom',
		'City' => 'Ville',
		'Recently Added' => 'Ajouté récemment',
		'Last Name' => 'Nom de famille',
		'First Name' => 'Prénom',
		'Status' => 'Le statut le plus récemment connu',
		'Haitian Quake' => 'Tremblement Haïtien',
		'Last Updated at ' => 'Le plus récemment mis à jour à: ',
		'Enter information' => 'Enregistrer des informations',
		'Age' => 'Age',
		'Gender' => 'Sexe',
		'Address' => 'Adresse',
		'Department' => 'Départment',
		'Current location' => 'Emplacement actuel',
		'Current contact information' => 'Les informations actuelles de contact',
		'person_my_information' => '<h3>Mes informations (pas exigés)</h3><em>Si vous soumettez vos informations, nous essayerons de vous contacter si cette personne est localisée.</em>',
		'Missing' => 'Disparu',
		'Wounded' => 'Blessé',
		'Survived' => 'Survécu',
		'Deceased' => 'Mort',
		'Other' => 'Autre',
		'Email' => 'Courriel',
		'Phone' => 'Téléphone',
		'Relationship to Missing Person' => 'Relation à la personne disparue',
		'Photos' => 'Photos',
		'View full photo' => 'Voyez le photo entier',
		'Add a Photo' => 'Ajouter un photo',
		'Notes' => 'Notes',
		'Add A Note' => 'Ajouter une note',
		'Changes Made' => 'Changes faits',
		'Change' => 'Changez',
		'Old Version' => 'Version précédente',
		'New Version' => 'Version actuelle',
		'Time' => 'Heure',
		'Your Name:' => 'Votre nom:',
		'Note:' => 'Note:',
		'Search' => 'Chercher',
		'Submit' => 'Soumetter',
		'Browse' => 'Brouter',
		'Upload' => 'Télécharger',
		'Add A Record' => 'Ajouter une registre',
		'Send Comment' => 'Envoyer une commentaire',
		'Showing Results' => 'Afficher des résultats',
		'to' => 'à',
		'of' => 'de',
		'Search Results' => 'Résultats de la recherche'
    )
);
?>
