<?php
  $inchi = substr($_SERVER['REQUEST_URI'],2);

  print "<!-- $inchi -->\n";

  $pos = strpos($inchi, 'info:inchi/');
  if ($pos === 0) {
    $inchi = substr($inchi, 11);
  }

  print "<!-- $inchi -->\n";

  if (strlen($inchi) === 0) {
    $inchi = "InChI=1/CH4/h1H4";
  }
  if (strlen($inchi) < 8 ||
      (substr($inchi, 0,8) != "InChI=1/" &&
       substr($inchi, 0,9) != "InChI=1S/")) {
    $inchi = "InChI=1/CH4/h1H4";
  }
?>

<rdf:Description
  xmlns:owl="http://www.w3.org/2002/07/owl#"
 rdf:about="http://rdf.openmolecules.net/?<?php echo $inchi;?>">

  <dc:source>ChemSpider</dc:source>

<?

function startsWith($haystack,$needle,$case=true) {
    if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
    return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
}

        $paper_id = false;

        $safe_inchi = mysql_escape_string($inchi);

        if ($safe_inchi) {
                echo "<!-- DEBUG: inchi=".$safe_inchi." -->\n";
	        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM chemspider ";
                if (startsWith($safe_inchi, 'InChI=1S')) {
                   $where_clause = "WHERE SINCHI = '$safe_inchi'";
                } else {
          	  $where_clause = "WHERE INCHI = '$safe_inchi'";
                }

	        $query = $query.$where_clause;

	        print "<!-- DEBUG: query = $query -->\n";
        	$results = mysql_query($query);

	        $rows = mysql_num_rows($results);
	        while ($row = mysql_fetch_assoc($results)) {
                        $molid = $row['csid'];
                        print "<foaf:homepage rdf:resource=\"http://www.chemspider.com/Chemical-Structure.$molid.html\"/>\n";
                        print "<owl:sameAs rdf:resource=\"http://www.chemspider.com/Chemical-Structure.$molid.rdf#Compound\"/>\n";
		}
        }

?>

</rdf:Description>
