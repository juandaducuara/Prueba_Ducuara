<?php

class PersonaModel
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function listar()
    {
        $consulta = $this->conexion->query(
            'SELECT IdPersona, Nombres, Apellidos, Identificacion, Genero, FechaNacimiento, Activo
             FROM persona ORDER BY IdPersona DESC'
        );
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id)
    {
        $consulta = $this->conexion->prepare(
            'SELECT IdPersona, Nombres, Apellidos, Identificacion, Genero, FechaNacimiento, Activo
             FROM persona WHERE IdPersona = ?'
        );
        $consulta->execute(array($id));
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos)
    {
        $consulta = $this->conexion->prepare(
            'INSERT INTO persona
                (Nombres, Apellidos, Identificacion, Genero, FechaNacimiento, Contrasena, Activo)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $consulta->execute(array(
            $datos['nombres'], $datos['apellidos'], $datos['identificacion'],
            $datos['genero'], $datos['fecha'],
            password_hash($datos['contrasena'], PASSWORD_DEFAULT), $datos['activo']
        ));
    }

    public function actualizar($id, $datos)
    {
        if ($datos['contrasena'] !== '') {
            $consulta = $this->conexion->prepare(
                'UPDATE persona
                 SET Nombres=?, Apellidos=?, Identificacion=?, Genero=?, FechaNacimiento=?, Contrasena=?, Activo=?
                 WHERE IdPersona=?'
            );
            $valores = array(
                $datos['nombres'], $datos['apellidos'], $datos['identificacion'], $datos['genero'],
                $datos['fecha'], password_hash($datos['contrasena'], PASSWORD_DEFAULT), $datos['activo'], $id
            );
        } else {
            $consulta = $this->conexion->prepare(
                'UPDATE persona
                 SET Nombres=?, Apellidos=?, Identificacion=?, Genero=?, FechaNacimiento=?, Activo=?
                 WHERE IdPersona=?'
            );
            $valores = array(
                $datos['nombres'], $datos['apellidos'], $datos['identificacion'],
                $datos['genero'], $datos['fecha'], $datos['activo'], $id
            );
        }
        $consulta->execute($valores);
    }

    public function cambiarEstado($id, $activo)
    {
        $consulta = $this->conexion->prepare('UPDATE persona SET Activo = ? WHERE IdPersona = ?');
        $consulta->execute(array($activo, $id));
    }
}
