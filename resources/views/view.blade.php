<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col6 offset-3">
            <div action="#">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>File</span>
                        <input type="file" name="foo_file" id="foo_file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col6 offset-3">
            <div class="progress">
                <div class="determinate" style=""></div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="loaded-bytes" value=0>
<script type="text/javascript">
    var myXhr = $.ajaxSettings.xhr();
    $(document).ready(function () {
        $('#foo_file').change(function () {
            // check pack name
            var file = $('input[name="foo_file"]')[0].files[0];
            var perChunk = 104857600; // 100M
            var total = file.size;
            var start = 0;
            var end = perChunk;
            var chunk = file.slice(start, end);
            // linked list, linked all chunks together
            var linkedList = [];
            function upload(chunk)
            {
                var formData = new FormData();
                formData.append("foo_file", chunk);
                $.ajax({
                    // Your server script to process the upload
                    url: "{{route('upload')}}",
                    type: 'POST',
                    // Form data
                    data: formData,
                    // Tell jQuery not to process data or worry about content-type
                    // You *must* include these options!
                    contentType: false,
                    processData: false,
                    xhr: function () {
                        if (myXhr.upload) {
                            myXhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    var loaded = parseInt($('#loaded-bytes').val()) + e.loaded;
                                    var percent = (loaded / total * 100) > 100 ? 100 : (loaded / total * 100);
                                    var progressBar = $('.determinate');
                                    progressBar.css('width', percent + "%");
                                    // finish uploading
                                    if (percent === 100) {
                                        // union all

                                    }
                                }
                            }, false);
                        }
                        return myXhr;
                    },
                    // Custom XMLHttpRequest
                    success: function (result) {
                        if (result.status === 200) {
                            var loadedBytes = $('#loaded-bytes');
                            loadedBytes.val(parseInt(loadedBytes.val()) + chunk.size);
                            if (result.data.path !== '') {
                                linkedList.push(result.data.path);
                            }
                            start = end;
                            if (start < total) {
                                end = start + perChunk;
                                if (end >= total) {
                                    end = total;
                                }
                                chunk = file.slice(start, end);
                                upload(chunk);
                            }
                        }
                    }
                });
            }

            upload(chunk);
        });
    });
</script>
</body>
</html>