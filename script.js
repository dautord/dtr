function startTime() {
    var today = new Date();
    var hr = today.getHours();
    var min = today.getMinutes();
    var sec = today.getSeconds();
    ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
    hr = (hr == 0) ? 12 : hr;
    hr = (hr > 12) ? hr - 12 : hr;
    //Add a zero in front of numbers<10
    hr = checkTime(hr);
    min = checkTime(min);
    sec = checkTime(sec);
    document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;
    
    var time = setTimeout(function(){ startTime() }, 500);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

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



