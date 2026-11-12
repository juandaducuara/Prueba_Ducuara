<?php
require_once 'conexion.php';
require_once 'PersonaModel.php';

class PersonaController
{
    private $personas;

    public function __construct($conexion)
    {
        $this->personas = new PersonaModel($conexion);
    }

    private function responder($ok, $mensaje, $datos = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('ok' => $ok, 'mensaje' => $mensaje, 'datos' => $datos), JSON_UNESCAPED_UNICODE);
        exit;
    }

    private function datosValidos($actualizar = false)
    {
        $datos = array(
            'nombres' => trim(isset($_POST['Nombres']) ? $_POST['Nombres'] : ''),
            'apellidos' => trim(isset($_POST['Apellidos']) ? $_POST['Apellidos'] : ''),
            'identificacion' => trim(isset($_POST['Identificacion']) ? $_POST['Identificacion'] : ''),
            'genero' => isset($_POST['Genero']) ? $_POST['Genero'] : '',
            'fecha' => isset($_POST['FechaNacimiento']) ? $_POST['FechaNacimiento'] : '',
            'contrasena' => isset($_POST['Contrasena']) ? $_POST['Contrasena'] : '',
            'activo' => isset($_POST['Activo']) ? (int) $_POST['Activo'] : 1
        );
        if (
            $datos['nombres'] === '' || $datos['apellidos'] === '' || $datos['identificacion'] === '' ||
            !in_array($datos['genero'], array('M', 'F'), true) || $datos['fecha'] === '' ||
            (!$actualizar && $datos['contrasena'] === '') || !in_array($datos['activo'], array(0, 1), true)
        ) {
            $this->responder(false, 'Revisa los campos obligatorios.');
        }
        if ($datos['contrasena'] !== '' && strlen($datos['contrasena']) < 4) {
            $this->responder(false, 'La contraseña debe tener al menos 4 caracteres.');
        }
        return $datos;
    }

    public function listar()
    {
        try {
            $this->responder(true, 'Listado cargado.', $this->personas->listar());
        } catch (PDOException $e) {
            http_response_code(500);
            $this->responder(false, 'No se pudo cargar el listado.');
        }
    }

    public function obtener()
    {
        try {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            $persona = $this->personas->obtener($id);
            if (!$persona) {
                $this->responder(false, 'No se encontró la persona.');
            }
            $this->responder(true, 'Persona cargada.', $persona);
        } catch (PDOException $e) {
            http_response_code(500);
            $this->responder(false, 'No se pudo cargar la persona.');
        }
    }

    public function crear()
    {
        $datos = $this->datosValidos();
        try {
            $this->personas->crear($datos);
            $this->responder(true, 'Persona creada.');
        } catch (PDOException $e) {
            $this->errorGuardar($e, 'crear');
        }
    }

    public function actualizar()
    {
        $id = isset($_POST['IdPersona']) ? (int) $_POST['IdPersona'] : 0;
        if ($id < 1) {
            $this->responder(false, 'No se recibió una persona válida.');
        }
        $datos = $this->datosValidos(true);
        try {
            $this->personas->actualizar($id, $datos);
            $this->responder(true, 'Persona actualizada.');
        } catch (PDOException $e) {
            $this->errorGuardar($e, 'actualizar');
        }
    }

    public function cambiarEstado()
    {
        $id = isset($_POST['IdPersona']) ? (int) $_POST['IdPersona'] : 0;
        $activo = isset($_POST['Activo']) ? (int) $_POST['Activo'] : -1;
        if ($id < 1 || !in_array($activo, array(0, 1), true)) {
            $this->responder(false, 'No se recibió un estado válido.');
        }
        try {
            $this->personas->cambiarEstado($id, $activo);
            $mensaje = $activo === 1 ? 'Persona activada.' : 'Persona marcada como inactiva.';
            $this->responder(true, $mensaje);
        } catch (PDOException $e) {
            http_response_code(500);
            $this->responder(false, 'Ocurrió un error al cambiar el estado.');
        }
    }

    private function errorGuardar($error, $accion)
    {
        if ($error->getCode() === '23000') {
            $this->responder(false, 'La identificación ya está registrada.');
        }
        http_response_code(500);
        $this->responder(false, 'Ocurrió un error al ' . $accion . ' la persona.');
    }
}

$controlador = new PersonaController($conexion);
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
if (!in_array($accion, array('listar', 'obtener', 'crear', 'actualizar', 'cambiarEstado'), true)) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('ok' => false, 'mensaje' => 'Acción no válida.'));
    exit;
}
$controlador->$accion();
