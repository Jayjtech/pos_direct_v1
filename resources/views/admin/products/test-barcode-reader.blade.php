<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
</head>

<body>

    <input type="text" id="barcodeInput" placeholder="Scan barcode...">
    <h1 class="display"></h1>
    <script src="https://unpkg.com/@zxing/library@0.18.2"></script>
    <script>
        const display = document.querySelector('.display');
        const codeReader = new ZXing.BrowserBarcodeReader();
        const barcodeInput = document.getElementById('barcodeInput');

        // Listen for barcode scan
        codeReader.decodeFromInputVideoDevice(undefined, 'video').then((result) => {
            barcodeInput.value = result.text;
        }).catch((err) => {
            console.error(err);
        });

        codeReader.getVideoInputDevices()
            .then((videoInputDevices) => {
                if (videoInputDevices.length > 0) {
                    codeReader.decodeFromInputVideoDevice(videoInputDevices[0].deviceId, 'video');
                } else {
                    console.error('No camera found');
                }
            })
            .catch((err) => {
                console.error(err);
            });
    </script>
</body>

</html>
