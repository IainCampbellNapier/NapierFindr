<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Drag & Drop Uploading</title>
    
    <link rel="stylesheet" href="dropzone.css" type="text/css" />
    <!--<link rel="stylesheet" href="global.css">-->
    
    <script src="dropzone.js"></script>
    <script type="text/javascript">
    // Changes the dropzone's default attributes to: disable automatic file uploading,
    // display a button to remove each file, and accepted file types
      Dropzone.options.upload = {
        autoProcessQueue: false,
        addRemoveLinks: true,
        acceptedFiles: "image/*,.gif,.jpeg,.png",
        init: function() {
          // Uploads images via upload-button
          var submitBtn = document.querySelector("#upload-button");
          myDropzone = this;
          submitBtn.addEventListener("click", function() {
            myDropzone.processQueue();
          });
        }
      }
    </script>
</head>
<body>
    
    <!--<div id="dropzone">-->
      <!--Displays dropzone and upload button-->
      <form action="upload.php" class="dropzone" enctype='multipart/form-data' id="upload"></form>
      <button id="upload-button">Upload Images</button>
    
</body>
</html>
