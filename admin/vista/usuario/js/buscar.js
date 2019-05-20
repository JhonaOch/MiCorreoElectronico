function buscar(input) {
    let text = input.value.trim()
    //console.log(text)
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest()
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("data").innerHTML = this.responseText
        }
    };
    xmlhttp.open("GET", "../../controladores/user/buscar.php?key=" + text, true)
    xmlhttp.send()
}


function openWindow(id, txt, code) {
    console.log(code)

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest()
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("floatWindow").innerHTML = this.responseText
        }
    };
    xmlhttp.open("GET", "../../controladores/user/readMsj.php?id=" + id + "&dest=" + txt + "&code=" + code, true)
    xmlhttp.send()

    let windowFloat = document.getElementById("floatWindow")
    windowFloat.style.display = "block"

}

function cluseWindow() {
    let windowFloat = document.getElementById("floatWindow")
    windowFloat.style.display = "none"
}