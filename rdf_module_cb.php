<? include("../cb.openmolecules.net/functions.php"); ?>
<? include("../cb.openmolecules.net/inchi_functions.php"); ?>

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
 rdf:about="http://rdf.openmolecules.net/?<?php echo $inchi;?>">

  <dc:source>Chemical blogspace</dc:source>

<?

        $paper_id = false;

        $safe_inchi = mysql_escape_string($inchi);
        $safe_id = mysql_escape_string($_GET["id"]);

        if ($safe_inchi) {
                # echo "<!-- DEBUG: inchi=".$safe_inchi." -->\n";
                $inchis = get_inchis("added_on", array("inchi" => $safe_inchi, "limit" => 1));
        } else {
                # print "<!-- DEBUG: id=".$safe_id." -->\n";
                $inchis = get_inchis("added_on", array("id" => $safe_id, "limit" => 1));
        }
        # echo "<!-- entries found: " . sizeof($inchis) . " -->";

        foreach ($inchis as $inchiData) {
            $cid = $inchiData['cid'];
            $key = $inchiData['inchikey'];
        }

        if ($inchikey) {
            echo "cb:inchiKey xmlns:cb=\"http://cb.openmolecules.net/#\">".$inchikey."</cb:inchikey>\n";
        }

        if ($cid) {
            echo "<pubchem:cid xmlns:pubchem=\"http://pubchem.ncbi.nlm.nih.gov/#\">$cid</pubchem:cid>\n";
            echo "<pubchem:name xmlns:pubchem=\"http://pubchem.ncbi.nlm.nih.gov/#\">".$inchiData['name']."</pubchem:name>\n";
        }

        $posts = get_posts_for_inchi($inchi);

        if ($posts) {
                foreach ($posts as $post) {
                    echo "<cb:discussedBy xmlns:cb=\"http://cb.openmolecules.net/#\">".$post['url']."</cb:discussedBy>\n";
                }
        }

?>

</rdf:Description>
