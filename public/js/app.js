const createUserUrl = '/user/create';
const inconHouse = document.querySelector('#icon-house');
const btnDelete = document.querySelector("#btn-delete");
const btnAddNumber = document.querySelector("#btn-add-number");
const containerAux = document.querySelector("#container-aux");
const btnRemoveNumber = document.querySelector("#btn-remove-number");
const iconEmail = document.querySelector('#icon-email');
const btnEmail = document.querySelector("#btn-send-email");


document.addEventListener('DOMContentLoaded', function() {
    const topBar = document.getElementById('top-bar');

    topBar.addEventListener('click', function(event) {
        if (event.target.matches('#btn-register')) {
            window.location.href = createUserUrl;
        }  else if (event.target.matches('#btn-close')) {
            if (confirm("Are you sure you want to logout?")) { 
                window.location.href = '/logout'; 
            }
        } else if (event.target.matches('#btn-edit')) {
            window.location.href = '/edit';
        } else if (event.target.matches('#btn-delete')) {
            window.location.href = '/delete';
        } else if (event.target.matches('#btn-login')) {
            window.location.href = '/showLogin';
        } else if (event.target.matches('.icon-email')) {
            window.location.href = '/mailBox';
        } else if (event.target.matches('#icon-house')) {
            window.location.href = '/user';
        } else if (event.target.matches('#btn-send-email')) {
            window.location.href = '/email';
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    // Inicializar todos los inputs con la clase "phone-input"
    const phoneInputs = document.querySelectorAll(".phone-input");

    phoneInputs.forEach(input => {
        window.intlTelInput(input, {
            separateDialCode: true,
            preferredCountries: ["us", "mx", "es", "fr", "ve"], // Países preferidos
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });
    });

    // Botón para agregar un nuevo número dinámicamente
    const phoneContainer = document.getElementById("phoneContainer");

    btnAddNumber.addEventListener("click", function () {
        // Crear un nuevo input
        const newInput = document.createElement("input");
        newInput.type = "tel";
        newInput.name = "phone_numbers[]";
        newInput.classList.add("phone-input");
        newInput.required = true;

        // Agregar el nuevo input al contenedor
        phoneContainer.appendChild(newInput);

        // Inicializar intl-tel-input en el nuevo input
        window.intlTelInput(newInput, {
            separateDialCode: true,
            preferredCountries: ["us", "mx", "es", "fr", "ve"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });
    });

    btnRemoveNumber.addEventListener("click", function () {
        // Obtener el último elemento agregado en phoneContainer
        const lastInput = phoneContainer.lastElementChild;

        // Verificar si hay elementos en el contenedor
        if (lastInput) {
            phoneContainer.removeChild(lastInput);
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const readButtons = document.querySelectorAll('.btn-read');

    readButtons.forEach(button => {
        button.addEventListener('click', function () {
            const messageId = this.dataset.messageId;

            fetch(`/markAsRead/${messageId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Message marked as read.');
                    this.disabled = true; // Deshabilitar el botón
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while marking the message as read.');
            });
        });
    });
});

