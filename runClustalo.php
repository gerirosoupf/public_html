<?php
/*
 * runClustalo.php
 * execution file
 */
require "globals.inc.php";

// Defining the variables and directories
$input_fasta = $input_uniprot = $input_file = $output_format = $temp_file = "";
$input_error = $output_format_error = "";
$dir_results = "results/";

// Storing field variables
if (isset($_POST["submit"])){
    $input_fasta = $_POST["fastaseq"];
    $input_uniprot = $_POST["uniprotid"];
    $input_file = $_FILES["seqfile"]["name"];
    $output_format = test_input($_POST["output_format"]);


    //Checking required fields
    if (empty($input_file) && empty($input_fasta) && empty($input_uniprot)){
        $input_error = "No input sequence, ID or file has been provided!";
    } elseif (!empty($input_fasta) && !empty($input_uniprot)){
        $input_error = "Please, introduce just one input type";
    }elseif (!empty($input_file)){
        // Storing the file
        $temp_file = $_FILES["seqfile"]["tmp_name"];
    }elseif (!empty($input_fasta)){
        // Storing the fasta sequences
        $temp_file = "temp.fa";
        $temp_fh = fopen($temp_file, "wt");

        $p = strpos($input_fasta, ">");
        if ($p){
            fwrite($temp_fh, $input_fasta);
        };
    }elseif (!empty($input_uniprot)){
        // Storing the sequences from uniprot ID
        $temp_file = "temp.fa";
        $temp_fh = fopen($temp_file, "wt");

        $ids = explode(",", $input_uniprot);
        foreach ($ids as $id){
            $url = "https://www.uniprot.org/uniprot/". $id . ".fasta";
            $file_name = $id . ".fasta";
            $sequence = file_get_contents($url);
            fwrite($temp_fh, $sequence);
        };
    };
    // Running clustal omega
    // Deleting previous results, if any
    delete_files($dir_results);

    $output_file = $dir_results . "clustalo" . $output_format;
    $cmd = "./clustalo --force -i " . $temp_file . " -o " . $output_file . " --outfmt " . $output_format;
    exec($cmd, $output, $exit_code);

    if (!empty($input_file) OR !empty($input_uniprot) OR !empty($input_file)){
        fclose($temp_fh);
    };
};

// Extra functions
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

function delete_files($dir_path){
    $path = $dir_path . "*";
    $files = glob($path);

    if (!empty($files)) {
        foreach ($files as $file){
            unlink($file);
        }
    }
};
?>