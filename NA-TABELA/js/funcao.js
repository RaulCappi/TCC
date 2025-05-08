function confirmaExclusaoPub(id) {
    if (confirm("Deseja excluir a publicação?")) {
        //alert("Esse é o id: " + id);
        window.location.href = "../config/pub-delete.php?id=" + id;
    }

}

function confirmaExclusaoUser(id) {
    if (confirm("Deseja excluir o perfil?")) {
        //alert("Esse é o id: " + id);
        window.location.href = "../config/usu-delete.php?id=" + id;
    }

}

function confirmaExclusaoAtl(id) {
    if (confirm("Deseja excluir o atleta?")) {
        //alert("Esse é o id: " + id);
        window.location.href = "../config/atl-delete.php?id=" + id;
    }

}

function admconfirmaExclusaoUser(id) {
    if (confirm("Deseja excluir o perfil?")) {
        //alert("Esse é o id: " + id);
        window.location.href = "../usu-delete.php?id=" + id;
    }

}

function admconfirmaExclusaoPub(id) {
    if (confirm("Deseja excluir o perfil?")) {
        //alert("Esse é o id: " + id);
        window.location.href = "../pub-delete.php?id=" + id;
    }

}

function admconfirmaExclusaoAtl(id) {
    if (confirm("Deseja excluir o atleta?")) {
        //alert("Esse é o id: " + id);
        window.location.href = "../adm-delete-atl.php?id=" + id;
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
