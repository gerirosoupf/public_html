<?php
/*
 * clustalog.php
 * main form
 */

 // Loading global variables and DB connection
require "globals.inc.php";
require "runClustalo.php";

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

    <div class="row justify-content-center" style="margin-top: +200px; margin-bottom: +200px; display:none;" id="loading">
        <h2 class="text-center py-5">Your request is being processed...<br>Please wait.</h2>
        <div class="d-flex justify-content-center py-5">
            <div class="spinner-border" role="status">
                <span class="sr-only py-5" >Loading...</span>
            </div>
        </div>
    </div>

    <section>
    <div class="container" id='form'>
      <div class="section-title">
        <h2>Clustal Omega</h2>
        <br>
        <h3>Multiple Sequence Alignment </h3>
        <p>Clustal Omega is a new multiple sequence alignment program that uses seeded guide trees and HMM profile-profile techniques to generate alignments between three or more sequences. For more information, please visit the following link: <a href="http://www.clustal.org/omega/">Clustal Omega</a></p>
      </div>
      <form name="ClustalForm" action="results2.php" method="POST" enctype="multipart/form-data" onsubmit="ChangeDisplay()">
          <fieldset>
            <legend>STEP 1 - Enter your input sequences</legend>
            <div class="row">
              <div class="col">
              <label for="prot-seq" class="form-label">Introduce a protein or a set of protein sequences in FASTA format</label>
                <textarea class="form-control" id="fastaseq" rows="8" name="fastaseq"></textarea>
              </div>
            </div> 
            <div class="row">
              <div class="col">
                <label for="uniprot-id" class="form-label">Or, introduce the UniProt id/s separated by commas and without spaces</label>
                <textarea class="form-control" id="uniprotid" rows="2" name="uniprotid"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="fileinput" class="form-label">Or, upload a file:</p>
                <input class="form-control" id="seqfile" type="file" name="seqfile" value="">
              </div>
            </div>
          </fieldset>
          <br>
          <br>
          <fieldset>
            <legend>STEP 2 - Set your parameters</legend>
            <div class="row">
              <div class="col">
                <p for="output_format" class="form-label">Output format:</p>
                <select class="form-select" name="output_format">
                  <option selected value="fa">FASTA</option>
                  <option value="clu">Clustal</option>
                  <option value="msf">MSF</option>
                  <option value="phy">Phylip</option>
                  <option value="selex">Selex</option>
                  <option value="st">Stockholm</option>
                  <option value="vie">Vienna</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <button class="btn btn-primary" type="submit" name="submit">Submit form</button>
                <button class="btn btn-outline-dark" type="reset">Reset</button>
              </div>
            </div>
          </fieldset>
          </form>
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