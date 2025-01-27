document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('#testButton');
    if (button) { // Verifica que el botón existe en el DOM
        button.addEventListener('click', () => {
            alert('Vite está funcionando correctamente 🚀');
        });
    }
});
