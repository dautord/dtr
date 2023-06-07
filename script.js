let scanner = null;

// the function to be called when the scanner decodes a QR code
function onQRCodeScanned(data) {
  document.getElementById('employee_qrcode').value = data;
  document.getElementById('employee_qrcode').dispatchEvent(new Event('input', { bubbles: true }));
  document.querySelector('.form-harizontal').submit();
}

// the function to stop the scanner
function stopScanner() {
  scanner.stop();
  scanner = null;
}

// the function to start the scanner
function startScanner() {
  Instascan.Camera.getCameras().then(cameras => {
    if (cameras.length > 0) {
      scanner = new Instascan.Scanner({ video: document.getElementById('test'), scanPeriod: 5 });
      scanner.addListener('scan', onQRCodeScanned);
      scanner.start(cameras[0]);
    } else {
      console.error('No cameras found.');
    }
  }).catch(e => {
    console.error(e);
  });
}

window.addEventListener('load', () => {
  startScanner();
});

// disable keyboard
document.addEventListener('keydown', function (event) {
  if (event.ctrlKey || event.altKey || event.shiftKey) {
    event.preventDefault();
  }
});



