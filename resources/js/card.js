import * as htmltoimage from 'html-to-image';
window.htmltoimage = htmltoimage;

window.addEventListener("load", function () {

    // Formateamos los textos en listados
    for (let elem of document.getElementsByTagName('td')) {
        elem.innerHTML = elem.innerHTML
            .replaceAll(/\{(.*?)\|(.*?)}/gmi, "<span class='skill skill-$1 skill-td'>$2</span>")
            .replaceAll(/\[(.*?)\|(.*?)]/gmi, "<span class='trait trait-$1 trait-td'>$2</span>")
            .replaceAll(/\*(.*?)\*/gmi, "<span class='bold bold-td'>$1</span>")
            .replaceAll(/#atk#/gmi, "<span class='atk atk-td'>&nbsp;&nbsp;</span>")
            .replaceAll(/#def#/gmi, "<span class='def atk-td'>&nbsp;&nbsp;</span>")
        ;
    }

    // Formateamos textos en cajas de texto de cartas
    for (let elem of document.getElementsByClassName('text')) {
        elem.innerHTML = elem.innerHTML
            .replaceAll(/\{(.*?)\|(.*?)}/gmi, "<span class='skill skill-$1'>$2</span>")
            .replaceAll(/\[(.*?)\|(.*?)]/gmi, "<span class='trait trait-$1'>$2</span>")
            .replaceAll(/\*(.*?)\*/gmi, "<span class='bold'>$1</span>")
            .replaceAll(/#atk#/gmi, "<span class='atk'>&nbsp;&nbsp;</span>")
            .replaceAll(/#def#/gmi, "<span class='def'>&nbsp;&nbsp;</span>")
            .replaceAll(/\+/gmi, "<span class='plus'>+</span>")
    }

}, false);
