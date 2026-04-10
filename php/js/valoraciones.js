document.addEventListener('DOMContentLoaded', () => {
    const formularios = document.querySelectorAll('.form-voto');

    formularios.forEach((formulario) => {
        const estrellas = formulario.querySelectorAll('.estrella-voto');

        estrellas.forEach((estrella) => {
            estrella.addEventListener('click', async () => {
                const idProducto = formulario.dataset.id;
                const cantidad = estrella.dataset.voto;
                const bloqueResultado = document.getElementById('valoracion-' + idProducto);
                const datos = new FormData();

                datos.append('idPr', idProducto);
                datos.append('cantidad', cantidad);

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
                    estrellas.forEach((btn) => {
                        btn.disabled = true;
                        btn.classList.remove('activa');
                    });
                } catch (error) {
                    alert('No se pudo conectar con el servidor.');
                }
            });

            estrella.addEventListener('mouseenter', () => {
                const valor = parseInt(estrella.dataset.voto, 10);
                estrellas.forEach((btn) => {
                    btn.classList.toggle('activa', parseInt(btn.dataset.voto, 10) <= valor);
                });
            });
        });

        formulario.addEventListener('mouseleave', () => {
            estrellas.forEach((btn) => btn.classList.remove('activa'));
        });
    });
});
