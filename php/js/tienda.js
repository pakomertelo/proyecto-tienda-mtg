class Producto {
    constructor(nombre, precio, cantidad = 1) {
        this.nombre = nombre;
        this.precio = parseFloat(precio);
        this.cantidad = cantidad;
    }

    subtotal() {
        return this.precio * this.cantidad;
    }
}

class ProductoConDescuento extends Producto {
    constructor(nombre, precio, cantidad = 1) {
        super(nombre, precio, cantidad);
        this.descuento = 0.10;
    }

    subtotal() {
        const base = super.subtotal();
        return base - base * this.descuento;
    }
}

let carrito = [];
const listaCarrito = document.getElementById('carrito-lista');
const totalCarrito = document.getElementById('carrito-total');
const mensajeCompra = document.getElementById('mensaje-compra');
const btnVaciar = document.getElementById('btn-vaciar');
const btnFinalizar = document.getElementById('btn-finalizar');
const btnToggleCarrito = document.getElementById('btn-toggle-carrito');
const panelCarrito = document.getElementById('carrito-section');
const textos = window.textosCarrito || {
    carrito_vacio: 'Carrito vacío.',
    producto: 'Producto',
    precio: 'Precio',
    cantidad: 'Cantidad',
    subtotal: 'Subtotal',
    acciones: 'Acciones',
    eliminar: 'Eliminar',
    total: 'Total: ',
    compra_finalizada: 'Compra finalizada el ',
    ultima_compra: 'Última compra: '
};

function cargarCarrito() {
    const guardado = localStorage.getItem('carrito');
    if (guardado) {
        carrito = JSON.parse(guardado);
    }
}

function guardarCarrito() {
    localStorage.setItem('carrito', JSON.stringify(carrito));
    document.cookie = 'carrito=' + encodeURIComponent(JSON.stringify(carrito)) + ';path=/';
}

function esConDescuento(nombre) {
    return nombre.toLowerCase().includes('sol ring');
}

function agregarProducto(nombre, precio) {
    const productoExistente = carrito.find(p => p.nombre === nombre);
    if (productoExistente) {
        productoExistente.cantidad += 1;
    } else {
        const nuevo = esConDescuento(nombre) ? new ProductoConDescuento(nombre, precio) : new Producto(nombre, precio);
        carrito.push(nuevo);
    }
    actualizarVista();
}

function eliminarProducto(nombre) {
    carrito = carrito.filter(p => p.nombre !== nombre);
    actualizarVista();
}

function cambiarCantidad(nombre, cantidad) {
    const prod = carrito.find(p => p.nombre === nombre);
    if (prod) {
        prod.cantidad = Math.max(1, parseInt(cantidad) || 1);
        actualizarVista();
    }
}

function pintarCarrito() {
    listaCarrito.innerHTML = '';

    if (carrito.length === 0) {
        listaCarrito.innerHTML = `<p>${textos.carrito_vacio}</p>`;
        return;
    }

    const lista = document.createElement('div');
    lista.classList.add('carrito-items');

    carrito.forEach(item => {
        const fila = document.createElement('div');
        fila.classList.add('carrito-item');
        fila.innerHTML = `
            <p class="carrito-item-nombre">${item.nombre}</p>
            <p class="carrito-item-precio">${item.precio.toFixed(2)} € x ${item.cantidad}</p>
            <div class="carrito-item-acciones">
                <input type="number" min="1" value="${item.cantidad}" data-producto="${item.nombre}" class="input-cantidad">
                <button class="btn-eliminar" data-producto="${item.nombre}">${textos.eliminar}</button>
            </div>
        `;
        lista.appendChild(fila);
    });
    listaCarrito.appendChild(lista);
}

function actualizarTotal() {
    let total = 0;
    carrito.forEach(item => {
        if (item.subtotal) {
            total += item.subtotal();
        } else {
            total += item.precio * item.cantidad;
        }
    });
    totalCarrito.textContent = textos.total + total.toFixed(2) + ' €';
}

function actualizarVista() {
    guardarCarrito();
    pintarCarrito();
    actualizarTotal();
}

function vaciarCarrito() {
    carrito = [];
    actualizarVista();
}

function finalizarCompra() {
    const fecha = new Date();
    localStorage.setItem('ultimaCompra', fecha.toString());
    vaciarCarrito();
    mensajeCompra.textContent = textos.compra_finalizada + fecha.toLocaleString();
}

function aplicarEventos() {
    document.querySelectorAll('.btn-carrito').forEach(boton => {
        boton.addEventListener('click', () => {
            const nombre = boton.dataset.nombre;
            const precio = parseFloat(boton.dataset.precio);
            agregarProducto(nombre, precio);
        });
    });

    listaCarrito.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-eliminar')) {
            const nombre = e.target.dataset.producto;
            eliminarProducto(nombre);
        }
    });

    listaCarrito.addEventListener('change', (e) => {
        if (e.target.classList.contains('input-cantidad')) {
            const nombre = e.target.dataset.producto;
            cambiarCantidad(nombre, e.target.value);
        }
    });

    btnVaciar.addEventListener('click', vaciarCarrito);
    btnFinalizar.addEventListener('click', finalizarCompra);
    if (btnToggleCarrito && panelCarrito) {
        btnToggleCarrito.addEventListener('click', () => {
            panelCarrito.classList.toggle('abierto');
        });
    }
}

function cargarUltimaCompra() {
    const ultima = localStorage.getItem('ultimaCompra');
    if (ultima) {
        mensajeCompra.textContent = textos.ultima_compra + ultima;
    }
}

cargarCarrito();
actualizarVista();
aplicarEventos();
cargarUltimaCompra();
