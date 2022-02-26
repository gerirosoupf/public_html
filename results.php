<?php
/*
 * results.php
 * Global variables and settings
 */

// Loading global variables
require "globals.inc.php";

// Take data from $_SESSION, loaded in clustalog.php

$_SESSION['queryData'] = $_REQUEST;

// Set temporary file name to a unique value to protect from concurrent runs
$query_ID = uniqId('clustalo');
$tempFile = $tmpDir . "/" . $query_ID;

// open the file
$ff = fopen($tempFile . ".query.fasta", 'wt');
$file_download=$tempFile . ".clustalo.aln";
// if it is a file upload
if ($_FILES['seqfile']['name']) {
    if (($_FILES['seqfile']['tmp_name'])) {
        $_SESSION['queryData']['input_seq'] = file_get_contents($_FILES['seqfile']['tmp_name']);
        fwrite($ff, $_SESSION['queryData']['input_seq']);
    }
}
// if there are uniprot ids
if (strlen($_SESSION['queryData']['uniprotid']) != 0) {
    if (strpos($_SESSION['queryData']['uniprotid'], ',') ) {
        $id_list = explode(",", $_SESSION['queryData']['uniprotid']);
    }
    else {
        echo '
        <script type="text/javascript">
            alert("Please, separate the ids by commas without spaces.");
            window.location.href = "../clustalo.php";
        </script>
        ';
    }
    // Now, we search for sequences in Uniprot
    foreach ($id_list as $id) {
        //print_r($id."\n");
        $_SESSION['queryData']['fastaseq'] = file_get_contents("https://www.uniprot.org/uniprot/".$id.".fasta");
        //print_r($sequence);
        if (empty($_SESSION['queryData']['fastaseq'])) {
            echo '
            <script type="text/javascript">
                alert("Some ID failed. Make sure that they are correct.");
                window.location.href = "../clustalo.php";
            </script>
            ';
        }
        else {
            fwrite($ff, $_SESSION['queryData']['fastaseq']);
        }
    }
}
// if the sequences are written
if ($_SESSION['queryData']['fastaseq']){
  fwrite($ff, $_SESSION['queryData']['fastaseq']);
}

//fclose($ff);
fclose($ff);
// execute ClustalO, command line prefix set in globals.inc.php
$cmd = "clustalo" . " -i " . $tempFile . ".query.fasta -o " . $tempFile . ".clustalo.out --outfmt ". $_POST['output_format'];
// DEBUG print command line
#print "$cmd\n";
exec($cmd);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Geriroso ClustalO</title>
  <meta content="Clustal Omega Tool" name="description">
  <meta content="Gerard Romero" name="author">
  

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon" type="image/png" sizes="32x32">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">


  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet"/>
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style_clustalo.css" rel="stylesheet">


</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="d-flex flex-column">

      <div class="profile">
        <img src="assets/img/profile-img.png" alt="" class="img-fluid rounded-circle">
        <h1 class="text-light text-center"><a href="#">Gerard Romero</a></h1>
        <div class="social-links mt-3 text-center">
          <a href="https://www.linkedin.com/in/gerard-romero-0aaaa1180/" class="linkedin"><i class="bx bxl-linkedin"></i></a>
          <a href="https://github.com/gerirosoupf" class="github"><i class="bx bxl-github"></i></a>
          <a href="https://www.instagram.com/geriroso9/" class="instagram"><i class="bx bxl-instagram"></i></a>
        </div>
      </div>

      <nav id="navbar" class="nav-menu navbar">
        <ul>
          <li><a href="home.html" class="nav-link scrollto"><i class="bx bx-home"></i> <span>Home</span></a></li>
          <li><a href="about.html" class="nav-link scrollto"><i class="bx bx-user"></i> <span>About</span></a></li>
          <li><a href="resume.html" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>Resume</span></a></li>
          <li><a href="projects.html" class="nav-link scrollto active"><i class="bx bx-server"></i> <span>Projects</span></a></li>
        </ul>
      </nav><!-- .nav-menu -->
    </div>
  </header><!-- End Header -->

    <section>
    <div class="container" id='form'>
      <div class="section-title">
        <h2>Clustal Omega</h2>
        <br>
        <h3>Results of the alignment</h3>
        <p>You can visualize the output of the alignment on the browser or download it in the button at the bottom</p>
      </div>
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10 col-xl-9">
                <p>
          <?php
          if (file_exists($tempFile . ".clustalo.aln")) {
            $fileread= file_get_contents($tempFile . ".clustalo.aln");
            $secuencia = "<pre>" . $fileread . "</pre>";
          echo $secuencia;
          };
          ?>
                </p>
                <a download = 'results.clustalo.aln' href = <?php echo './tmp/' . $query_ID . '.clustalo.aln'; ?>><button class="btn btn-primary">Download alignment</button></a>
            </div>
        </div>

    </section>

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; 2022 Copyright: Gerard Romero
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/ -->
        All rights reserved. Powered by <a href="http://mmb.irbbarcelona.org/formacio/~dbw00/">Databases and Web Development</a>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/typed.js/typed.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://kit.fontawesome.com/bdd89edb33.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script type="module">
          import Tags from "https://cdn.jsdelivr.net/gh/lekoala/bootstrap5-tags@master/tags.js";
          Tags.init("#separatorTags");
    </script>
    <script>
        function ChangeDisplay() {
            const el = document.getElementById('loading');
            el.style.display = "block";
            const el2 = document.getElementById('form');
            el2.style.display = "none";
            }
    </script>

</body>

</html>
