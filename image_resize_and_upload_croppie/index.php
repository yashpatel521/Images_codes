<html lang="en">

<head>
    <title>PHP and jQuery - Crop Image and Upload using Croppie plugin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <div class="card" style="max-height: 500px;">
            <div class="card-header bg-info">PHP and jQuery - Crop Image and Upload using Croppie plugin</div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-4 text-center">
                        <div id="upload-demo"></div>
                    </div>
                    <div class="col-md-4" style="padding:5%;">
                        <strong>Select image to crop:</strong>
                        <input type="file" id="image">

                        <button class="btn btn-success btn-block btn-upload-image" style="margin-top:2%">Upload
                            Image</button>
                    </div>

                    <div class="col-md-4">
                        <div id="preview-crop-image"
                            style="background:#9d9d9d;width:300px;padding:50px 50px;height:300px;"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script type="text/javascript">
    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {
            type: contentType
        });
        return blob;
    }
    var resize = $('#upload-demo').croppie({
        enableExif: true,
        enableOrientation: true,
        viewport: { // Default { width: 100, height: 100, type: 'square' } 
            width: 200,
            height: 200,
            type: 'circle' //square
        },
        boundary: {
            width: 300,
            height: 300
        }
    });


    $('#image').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            resize.croppie('bind', {
                url: e.target.result
            }).then(function() {
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });


    $('.btn-upload-image').on('click', function(ev) {
        resize.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(img) {

            // Get the form

            var ImageURL = img;

            // Split the base64 string in data and contentType
            var block = ImageURL.split(";");
            // Get the content type
            var contentType = block[0].split(":")[1]; // In this case "image/gif"
            // get the real base64 content of the file
            var realData = block[1].split(",")[1]; // In this case "iVBORw0KGg...."

            // Convert to blob
            var blob = b64toBlob(realData, contentType);

            // Create a FormData and append the file
            var fd = new FormData();
            fd.append("image", blob);

            // Submit Form and upload file
            $.ajax({
                url: "endpoint.php",
                data: fd, // the formData function is available in almost all new browsers.
                type: "POST",
                contentType: false,
                processData: false,
                cache: false,
                dataType: "json", // Change this according to your response from the server.
                error: function(err) {
                    console.error(err);
                },
                success: function(data) {
                    console.log(data);
                },
                complete: function() {
                    console.log("Request finished.");
                }
            });

        });
    });
    </script>


</body>

</html>