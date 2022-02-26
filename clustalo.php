<?php
require "globals.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Geriroso ClustalO</title>
  <meta name="description" content="Description of your webpage">
  <meta name="author" content="Your Name">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <h1>Clustal Omega</h1>
  <form id="clustal-form" action="runclustal.php" method="post" enctype="multipart/form-data" onsubmit="ChangeDisplay()">
    <div class="form-group">
      <p>Paste your sequences here (in <b>FASTA</b> format):</p>
        <textarea class="form-control" name="seqQuery" rows="10" cols="60" style="width:50%"></textarea><br>
    </div>
    <div>
      <p>Or provide a list of UniProt identifiers (separated by <b>commas</b>):</p>
      <input type="text" name="UniProtIDs" style="width:50%">
    </div>
    <div style="padding-top:5vh;">
      Upload sequence file: <input type="file" name="seqFile" value="" width="50" style="width:100%"/>
      <p class="error-message"><?php if (isset($_SESSION["Errormsg"])) {echo $_SESSION["Errormsg"]; unset($_SESSION["Errormsg"]);} ?></p>
    </div>
    <div>
      <p>Select output format:</p>
      <input type='radio' class="btn btn-radio" name="outFormat" value="fa" checked><label>FASTA</label>
      <input type='radio' class="btn btn-radio" name="outFormat" value="clu"><label>Clustal</label>
      <input type='radio' class="btn btn-radio" name="outFormat" value="msf"><label>MSF</label>
      <input type='radio' class="btn btn-radio" name="outFormat" value="phy"><label>Phylip</label>
      <input type='radio' class="btn btn-radio" name="outFormat" value="selex"><label>Selex</label>
      <input type='radio' class="btn btn-radio" name="outFormat" value="st"><label>Stockholm</label>
      <input type='radio' class="btn btn-radio" name="outFormat" value="vie"><label>Vienna</label>
    </div>
    <div>
      <button type='submit' class="btn btn-primary">Submit</button>
    </div>
  </form>
  <div id="loadingScreen"><p>Computing the alignment, please wait.</p></div>
  <script>
  function ChangeDisplay() {
    const loading = document.getElementById('loadingScreen');
    loading.style.display = "block";
    const clustalForm = document.getElementById('clustal-form');
    clustalForm.style.display = "none";
  }
  </script>
</body>
</html>
