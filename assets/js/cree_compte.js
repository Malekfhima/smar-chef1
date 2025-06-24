function verif() {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    if (!/^[a-zA-Z0-9]{3,20}$/.test(username)) {
        Swal.fire({
            icon: 'error',
            title: 'Nom invalide',
            text: '3-20 caractères (lettres, chiffres)',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }
    const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/i;
    if (!emailRegex.test(email)) {
        Swal.fire({
            icon: 'error',
            title: 'Email non valide',
            text: 'Seules les adresses Gmail (@gmail.com) sont acceptées',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }
    if (password.length < 8) {
        Swal.fire({
            icon: 'error',
            title: 'Mot de passe faible',
            text: '8 caractères minimum requis',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }
    if (!/[A-Z]/.test(password)) {
        Swal.fire({
            icon: 'error',
            title: 'Mot de passe incomplet',
            text: 'Au moins une majuscule requise',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }
    if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        Swal.fire({
            icon: 'error',
            title: 'Mot de passe incomplet',
            text: 'Au moins un symbole spécial requis',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }
    if ((password.match(/\d/g) || []).length < 3) {
        Swal.fire({
            icon: 'error',
            title: 'Mot de passe incomplet',
            text: 'Au moins 3 chiffres requis',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }
    if (password !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur de confirmation',
            text: 'Les mots de passe ne correspondent pas',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }
    Swal.fire({
        icon: 'success',
        title: 'Formulaire valide !',
        text: 'Vos informations sont correctes',
        confirmButtonColor: '#3085d6',
        timer: 2000,
        timerProgressBar: true
    }).then(() => {
        document.querySelector('form').submit();
    });
    return false;
}
function affiche_pass() {
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('confirm-password');
    const showCheckbox = document.getElementById('show-password');
    if (showCheckbox.checked) {
        passwordField.type = 'text';
        confirmField.type = 'text';
    } else {
        passwordField.type = 'password';
        confirmField.type = 'password';
    }
}