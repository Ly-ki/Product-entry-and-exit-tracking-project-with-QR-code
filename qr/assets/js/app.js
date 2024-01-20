$(document).ready(function () {
    var table = $('#myTable').DataTable({
        rowReorder: {
            selector: 'td:nth-child(1)'
        },
        responsive: true,
        pageLength: 5,
        lengthMenu: [[5], [5]],
        "dom": '<"html5buttons"B>lTfgitp',
        "language": {
            "url": "./assets/js/turkishlang.json"
        }
    })
    var table = $('#myTable_2').DataTable({
        rowReorder: {
            selector: 'td:nth-child(1)'
        }, pageLength: 5,
        lengthMenu: [[5], [5]],
        responsive: true,
        "dom": '<"html5buttons"B>lTfgitp',
        "language": {
            "url": "./assets/js/turkishlang.json"
        }
    })
});
const leftSidebar = document.getElementsByClassName("leftSidebar");
if (innerWidth <= 1366) {
    leftSidebar[0].style.overflowY = "scroll";
}
else {
    leftSidebar[0].style.overflowY = "inherit";
}
const offline = document.getElementById("offline");

window.addEventListener("online", () => {
    offline.style.display = "none";
    bttn[0].style.display = "block";
    scanner.start();
})
window.addEventListener("offline", () => {
    offline.style.display = "block";
    bttn[0].style.display = "none";
    scanner.stop();
})

let scanner = new Instascan.Scanner({
    video: document.getElementById('preview'),
    continuous: true,
    mirror: true,
    captureImage: true,
    backgroundScan: true,
    refractoryPeriod: 10000,
    scanPeriod: 15
});

scanner.addListener('scan', function (content, image) {
    if (scanner > "0") {
        var links = document.getElementById("links");
        var bttn = document.getElementById("bttn");
        var cont = `
       <input style="display:none;" type="text" value="${content}" name="products" placeholder="${content}">
       <i class="fa fa-cart-shopping shop"></i>
       <p>${content}</p>
       <button name="send" id="bttn" type="submit">Ekle</button>
       `;
        links.innerHTML = cont;
    }
});

let cameraList = [];
Instascan.Camera.getCameras().then(function (cameras) {
    this.cameraList = cameras;
    cameras.forEach(element => {
        let cameraList = document.getElementById("cameras");
        let option = document.createElement("option");
        option.text = element.name;
        option.value = element.id;
        cameraList.add(option);
        scanner.start(cameras[0])
    });
}).catch(() => console.error(e));

document.getElementById("cameras").addEventListener("change", event => {
    scanner.start(this.cameraList.find(c => c.id == event.target.value));
})
lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true
})