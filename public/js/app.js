const createUserUrl = '/user/create';

const btnDelete = document.querySelector("#btn-delete");


document.addEventListener('DOMContentLoaded', function() {
    const topBar = document.getElementById('top-bar');

    topBar.addEventListener('click', function(event) {
        if (event.target.matches('#btn-register')) {
            window.location.href = createUserUrl;
        }  else if (event.target.matches('#btn-close')) {
            window.location.href = '/logout';
            alert("You close the account successful");
        } else if (event.target.matches('#btn-edit')) {
            window.location.href = '/edit';
        } else if (event.target.matches('#btn-delete')) {
            window.location.href = '/delete';
        }
    });
});

