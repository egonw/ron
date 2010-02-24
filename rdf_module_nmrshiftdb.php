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

  <dc:source>NMRShiftDB</dc:source>

<?

        $paper_id = false;

        $safe_inchi = mysql_escape_string($inchi);

        if ($safe_inchi) {
                echo "<!-- DEBUG: inchi=".$safe_inchi." -->\n";
	        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM nmrshiftdb ";
        	$where_clause = "WHERE INCHI = '$safe_inchi'";

	        $query = $query.$where_clause;

	        print "<!-- DEBUG: query = $query -->\n";
        	$results = mysql_query($query);

	        $rows = mysql_num_rows($results);
	        while ($row = mysql_fetch_assoc($results)) {
                        $molid = $row['MOLECULE_ID'];
                        print "<rdfomn:nmrmolid>$molid</rdfomn:nmrmolid>\n";
                        print "<owl:sameAs rdf:resource=\"http://pele.farmbio.uu.se/nmrshiftdb/?moleculeId=$molid\"/>\n";
		}
        }

?>

</rdf:Description>
