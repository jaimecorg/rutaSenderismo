window.addEventListener("DOMContentLoaded",principal);

let arrayFotos= ["/carrusel1.jpg", "/carrusel2.jpg", "/carrusel3.jpg"];
let posicion= 1;

function principal(){
    let direccion = document.getElementById("fotoCarrusel").src;
    let ultimabarra= direccion.lastIndexOf('/');
    let directorio= direccion.slice(0, ultimabarra);

    document.getElementById("btnIzquierda").addEventListener("click",function (){
        restar1(posicion, directorio);
    });

    document.getElementById("btnDerecha").addEventListener("click",function (){
        sumar1(posicion, directorio);
    });
}

function sumar1(valor, direccion){
    if (valor === arrayFotos.length - 1){
        valor = 0;
    }else{
        valor = valor + 1;
    }

    posicion = valor;
    document.getElementById("fotoCarrusel").src = direccion + arrayFotos[valor];
}

function restar1(valor, direccion){
    if (valor === 0){
        valor = arrayFotos.length - 1;
    }else{
        valor = valor - 1;
    }

    posicion = valor;
    document.getElementById("fotoCarrusel").src = direccion + arrayFotos[valor];
}