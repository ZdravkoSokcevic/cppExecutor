<?php
    #file to compile

    require 'File.php';

   

   $FILE_PATH= 'nes.cpp';
   $output_file='nesto';
    $compiler=exec("which g++",$buff);
    $comp= $buff[0];

    $exec_command= $buff[0].' -o '.$output_file.' '.$FILE_PATH;

    $file=new File('nes.cpp','nesto');
    $file->execute();
    var_dump($file->getOutput());
    // var_dump($exec_command) or die();
    // exec($exec_command,$out);
    // exec('./'.$output_file,$out);
    // print_r($out);
    // die();
    var_dump('out')or die();

?>