PRUEBA PHP - JUAN DUCUARA

Requisitos
- XAMPP con Apache, MySQL o MariaDB, y PHP 7.x.
- Extensión PDO MySQL habilitada en PHP.
- Conexión a Internet para cargar Bootstrap y jQuery desde sus CDN.

Instalación en XAMPP
1. Copia esta carpeta dentro de C:\xampp\htdocs\Prueba_Ducuara.
2. Inicia Apache y MySQL desde el panel de XAMPP.
3. Abre http://localhost/phpmyadmin e importa database.sql. El script crea la
   base de datos, la tabla y cuatro registros de ejemplo.
4. Si MySQL tiene contraseña, actualiza $clave en conexion.php.
5. Abre http://localhost/Prueba_Ducuara/. La página se abre desde
   vistas/personas/index.php.

Uso
- Las vistas están en vistas/personas: el listado (index.php), crear (crear.php)
  y editar (editar.php?id=...). Al guardar o editar vuelve al listado.
- PersonaController.php recibe las acciones AJAX y valida los datos.
- PersonaModel.php concentra las consultas SQL. El controlador llama sus métodos
  para listar, obtener, crear, actualizar y cambiar el estado.
- Los botones Activar y Desactivar cambian el campo Activo entre 1 y 0; no borran la fila.
- El JavaScript y los estilos están fuera de las páginas, en assets/js y assets/css.
- En edición, deja la contraseña vacía para conservar la existente.
- Para crear una copia de los registros, ejecuta en phpMyAdmin:
  USE JuanDB_Ducuara;
  CALL copiar_personas();
  La copia queda en la tabla persona_copia. Cada ejecución la vuelve a crear.

Base de datos: JuanDB_Ducuara
Tabla principal: persona
Aplicación: Prueba_Ducuara
Versión objetivo: PHP 7.x (usando PDO y password_hash).
