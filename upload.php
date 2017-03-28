<?php

$ds          = DIRECTORY_SEPARATOR;
 
$storeFolder = 'uploads';
 
//Checks that there are files to be uploaded
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];           
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
     
    $targetFile =  $targetPath. $_FILES['file']['name'];
    
    $info = getimagesize($tempFile);
    if ($info == FALSE) {
        file_put_contents('php://stderr', print_r("Unable to determine image type of uplaoded file\n", TRUE));
        die("Unable to determine image type of uplaoded file");
    }
    
    if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
        file_put_contents('php://stderr', print_r("Not a gif/jpeg/png\n", TRUE));
        die("Not a gif/jpeg/png");
    }
 
    move_uploaded_file($tempFile,$targetFile);
    
    require_once 'aws/aws-autoloader.php';
    
    $bucket = 'findrim';
    $keyname = time() . "-" . $_FILES['file']['name'];
    
    $s3 = Aws\S3\S3Client::factory(array(
        'region'      => 'eu-west-2',
        'version'     => '2006-03-01',
        'credentials' => [
            'key'     => 'AKIAILUTQQD3M5U2T5EA',
            'secret'  => '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'
        ]
    ));
    
    try {
        $result = $s3->putObject(array(
            'Bucket'     => $bucket,
            'Key'        => $keyname,
            'SourceFile' => $targetFile,
            'ACL'        => 'public-read',
            'Metadata'   => array(
                'user'   => 'tbc',
                'tags'   => 'list,of,tags'
            )
        ));
        
        file_put_contents('php://stderr', print_r($result['ObjectURL'] . "\n", TRUE));
        
    } catch (Aws\S3\Exception\S3Exception $e) {
        file_put_contents('php://stderr', print_r($e->getMessage() . "\n", TRUE));
    }
    
    unlink($targetFile);
    
}

?>