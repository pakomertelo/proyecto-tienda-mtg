document.addEventListener('DOMContentLoaded', () => {
    const formularios = document.querySelectorAll('.form-voto');

    formularios.forEach((formulario) => {
        formulario.addEventListener('submit', async (evento) => {
            evento.preventDefault();

            const idProducto = formulario.dataset.id;
            const select = formulario.querySelector('select[name="cantidad"]');
            const bloqueResultado = document.getElementById('valoracion-' + idProducto);
            const datos = new FormData();

            datos.append('idPr', idProducto);
            datos.append('cantidad', select.value);

            try {
                const respuesta = await fetch('votar.php', {
                    method: 'POST',
                    body: datos
                });

                const json = await respuesta.json();

                if (!json.ok) {
                    alert(json.mensaje || 'No se pudo registrar el voto.');
                    return;
                }

                bloqueResultado.textContent = json.texto;
                formulario.querySelector('button[type="submit"]').disabled = true;
                select.disabled = true;
            } catch (error) {
                alert('No se pudo conectar con el servidor.');
            }
        });
    });
});
