@push('script')
    <script>
        "use-strict";
        const previewLogo = () => {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("logo").files[0]);

            oFReader.onload = function(oFREvent) {
                // CREATE NEW IMAGE OBJECT
                var img = new Image();
                img.onload = function() {
                    // RESIZE IMAGE
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    var new_width = 400;
                    var new_height = 400;
                    canvas.width = new_width;
                    canvas.height = new_height;
                    ctx.drawImage(img, 0, 0, new_width, new_height);

                    // SET PREVIEW IMAGE SOURCE
                    document.getElementById("logoPreview").src = canvas.toDataURL();

                    // CLEAN UP
                    canvas = null;
                    img = null;
                };
                img.src = oFREvent.target.result;
            };
        };

        // Preview signature
        const previewSignature = () => {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("signature").files[0]);

            oFReader.onload = function(oFREvent) {
                // CREATE NEW IMAGE OBJECT
                var img = new Image();
                img.onload = function() {
                    // RESIZE IMAGE
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    var new_width = 400;
                    var new_height = 400;
                    canvas.width = new_width;
                    canvas.height = new_height;
                    ctx.drawImage(img, 0, 0, new_width, new_height);

                    // SET PREVIEW IMAGE SOURCE
                    document.getElementById("signaturePreview").src = canvas.toDataURL();

                    // CLEAN UP
                    canvas = null;
                    img = null;
                };
                img.src = oFREvent.target.result;
            };
        };
    </script>
@endpush
