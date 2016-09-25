<?php

// when browsing to page, will force a download of the zip file
// assumes the file imgs.zip is located in spnov.com/html

$file_url = '/nfs/c12/h01/mnt/215537/domains/spnov.com/html/imgs.zip';

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"imgs.zip\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($file_url));
ob_end_flush();
@readfile($file_url);

?>
