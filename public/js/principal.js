window.addEventListener("DOMContentLoaded",principal);

var arrayFotos=["/carrusel1.jpg","/carrusel2.jpg", "/carrusel3.jpg"];
var posicion= 1;

function principal(){
    var direccion=document.getElementById("fotoCarrusel").src;
    var ultimabarra= direccion.lastIndexOf('/');
    var directorio= direccion.slice(0, ultimabarra);

    document.getElementById("btnIzquierda").addEventListener("click",function (){
        restar1(posicion, directorio);
    });
    document.getElementById("btnDerecha").addEventListener("click",function (){
        sumar1(posicion, directorio);
    });
}

function sumar1(valor, direccion){
    if (valor===arrayFotos.length-1){
        valor=0
    }
    else{
        valor=valor+1;
    }

    posicion = valor;
    document.getElementById("fotoCarrusel").src = direccion + arrayFotos[valor];
}

function restar1(valor, direccion){
    if (valor===0){
        valor=arrayFotos.length-1;
    }
    else{
        valor=valor-1;
    }

    posicion = valor;
    document.getElementById("fotoCarrusel").src = direccion + arrayFotos[valor];
}