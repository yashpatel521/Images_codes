<!DOCTYPE html>
<html lang="en">

<head>
    <title>crop with resize image using the croppie plugin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.css">

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-4 col-lg-8">
                <h2>Image Upload</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-4 col-lg-8">
                <div id="upload_image" style="background:#e1e1e1;width:300px;padding:30px;height:300px;"></div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-offset-5 col-lg-7">
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Add
                    Image</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Upload image</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div id="select_image" style="width:350px"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="pwd">Select Image::</label>
                            <input type="file" id="upload">
                        </div>
                        <div class="col-lg-4">
                            <button class="btn btn-success upload_result">Upload Image</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
    $uploadCrop = $('#select_image').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });


    $('#upload').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function() {
                console.log('jQuery bind complete');
            });

        }
        reader.readAsDataURL(this.files[0]);
    });


    $('.upload_result').on('click', function(ev) {
        $uploadCrop.croppie('result', {
            type: 'blob',
            size: 'viewport',
            circle: false
        }).then(function(resp) {
            var fd = new FormData();
            fd.append("image", resp);

            $.ajax({
                url: "upload.php",
                type: "POST",
                data: fd,
                contentType: false,
                processData: false,
                cache: false,
                dataType: "json",
                success: function(data) {
                    html = '<img src="' + resp + '" />';
                    $("#upload_image").html(html);
                    $("#myModal").modal("hide");
                }
            });
        });
    });
    </script>
</body>

</html>