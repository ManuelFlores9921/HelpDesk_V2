// This file contains the JavaScript code that handles the form submission for the login project.

document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var position = document.getElementById('position').value;
    var password = document.getElementById('password').value;

    // Aquí puedes agregar la lógica para autenticar al usuario

    // Enviar notificación por correo electrónico
    fetch('php/sendEmail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email: email, name: name, position: position })
    }).then(response => {
        if (response.ok) {
            alert('Inicio de sesión exitoso. Se ha enviado una notificación a su correo electrónico.');
        } else {
            alert('Error al enviar la notificación por correo electrónico.');
        }
    }).catch(error => {
        console.error('Error:', error);
    });
});