function verif() {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;
    let isValid = true;
    if (!/^[a-zA-Z0-9]+$/.test(username)) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Le nom d\'utilisateur ne doit contenir que des lettres et chiffres',
            confirmButtonColor: '#3085d6'
        });
        isValid = false;
    }
    if (password.length < 8) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Le mot de passe doit contenir au moins 8 caractères',
            confirmButtonColor: '#3085d6'
        });
        isValid = false;
    } else if (!/[A-Z]/.test(password)) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Le mot de passe doit contenir au moins une lettre majuscule',
            confirmButtonColor: '#3085d6'
        });
        isValid = false;
    } else if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Le mot de passe doit contenir au moins un symbole',
            confirmButtonColor: '#3085d6'
        });
        isValid = false;
    } else if ((password.match(/\d/g) || []).length < 3) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Le mot de passe doit contenir au moins 3 chiffres',
            confirmButtonColor: '#3085d6'
        });
        isValid = false;
    }
    if (isValid) {
        Swal.fire({
            icon: 'success',
            title: 'Validation réussie',
            text: 'Tous les champs sont valides !',
            confirmButtonColor: '#3085d6',
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            document.querySelector('form').submit();
        });
    }
    return isValid;
}
function affiche_pass() {
    const passwordField = document.getElementById('password');
    const showPasswordCheckbox = document.getElementById('show-password');
    if (showPasswordCheckbox.checked) {
        passwordField.type = 'text';
    } else {
        passwordField.type = 'password';
    }
}