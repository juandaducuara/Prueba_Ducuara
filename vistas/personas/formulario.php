<div class="card">
    <div class="card-header"><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?></div>
    <div class="card-body">
        <div id="aviso"></div>
        <form id="formPersona" data-accion="<?php echo htmlspecialchars($accion, ENT_QUOTES, 'UTF-8'); ?>" class="row g-3">
            <input type="hidden" id="IdPersona" name="IdPersona">
            <div class="col-md-6"><label class="form-label" for="Nombres">Nombres</label><input class="form-control" id="Nombres" name="Nombres" maxlength="100" required></div>
            <div class="col-md-6"><label class="form-label" for="Apellidos">Apellidos</label><input class="form-control" id="Apellidos" name="Apellidos" maxlength="100" required></div>
            <div class="col-md-4"><label class="form-label" for="Identificacion">Identificación</label><input class="form-control" id="Identificacion" name="Identificacion" maxlength="30" required></div>
            <div class="col-md-4"><label class="form-label" for="Genero">Género</label><select class="form-select" id="Genero" name="Genero" required>
                    <option value="">Selecciona</option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select></div>
            <div class="col-md-4"><label class="form-label" for="FechaNacimiento">Fecha de nacimiento</label><input class="form-control" type="date" id="FechaNacimiento" name="FechaNacimiento" required></div>
            <div class="col-md-6"><label class="form-label" for="Contrasena">Contraseña <span class="text-muted" id="ayudaContrasena"></span></label><input class="form-control" type="password" id="Contrasena" name="Contrasena" minlength="4"></div>
            <div class="col-md-3"><label class="form-label" for="Activo">Estado</label><select class="form-select" id="Activo" name="Activo">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select></div>
            <div class="col-12"><button class="btn btn-primary" type="submit">Guardar</button> <a class="btn btn-secondary" href="index.php">Volver al listado</a></div>
        </form>
    </div>
</div>