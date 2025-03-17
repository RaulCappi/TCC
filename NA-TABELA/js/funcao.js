function confirmaExclusaoUser(id) {
    if (confirm("Deseja excluir o registro?")) {
        //alert("Esse é o id: " + id)
        window.location.href = "../usu-delete.php?id=" + id;
    }

}

function togglePassword() {
    const senhaInput = document.getElementById('senha');
    const mostrarSenhaCheckbox = document.getElementById('mostrarSenha');

    if (senhaInput.type === 'password') {
        senhaInput.setAttribute('type','text');
        mostrarSenhaCheckbox.classList.replace('bi-eye-slash-fill' , 'bi-eye-fill');
    } else {
        senhaInput.setAttribute('type','password');
        mostrarSenhaCheckbox.classList.replace('bi-eye-fill' , 'bi-eye-slash-fill');
    }
}
