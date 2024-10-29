@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nuevo Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Nuevo USUARIO</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Formulario de Nuevo USUARIO</h3>
                    </div>
                    <form action="{{ route('usuario.store') }}" method="post" onsubmit="return validateForm()">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Ingrese el nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Ingrese el email" required>
                            <small id="emailHelp" class="form-text text-muted">El email debe contener el símbolo @.</small>
                            <div id="email-error-message" style="color: red; display: none;"></div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese el password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">👁️</span>
                                </div>
                            </div>
                            <small id="passwordHelp" class="form-text text-muted">La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula y un número.</small>
                            <div id="password-error-message" style="color: red; display: none;"></div>
                        </div>
                        <div class="form-group">
                            <label for="role">Rol</label>
                            <select class="form-control" name="role" id="role" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <a href="{{ route('usuario.index') }}" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function validateForm() {
    const emailValid = validateEmail();
    const passwordValid = validatePassword();
    return emailValid && passwordValid; // Solo permite el envío si ambas validaciones son exitosas
}

function validateEmail() {
    const email = document.getElementById('email').value;
    const emailErrorMessage = document.getElementById('email-error-message');
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!regexEmail.test(email)) {
        emailErrorMessage.style.display = 'block';
        emailErrorMessage.innerHTML = 'El email debe contener el símbolo @ y ser válido.';
        return false;
    } else {
        emailErrorMessage.style.display = 'none';
    }
    
    return true;
}

function validatePassword() {
    const password = document.getElementById('password').value;
    const passwordErrorMessage = document.getElementById('password-error-message');
    const regexPassword = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/; // Al menos 8 caracteres, una mayúscula y un número

    if (!regexPassword.test(password)) {
        passwordErrorMessage.style.display = 'block';
        passwordErrorMessage.innerHTML = 'La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula y un número.';
        return false;
    } else {
        passwordErrorMessage.style.display = 'none';
    }
    
    return true;
}

// Función para mostrar/ocultar la contraseña
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.textContent = type === 'password' ? '👁️' : '🙈'; // Cambia el ícono
});
</script>

@endsection
