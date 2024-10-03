<?php
include "include/encabezado.php";
include "../Servidor/conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) {
        $alert = '<p class"error">Todo los campos son requeridos</p>';
    } else {
        $idusuario = $_GET['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        $rol = $_POST['rol'];

        $sql_update = mysqli_query($conexion, "UPDATE usuarios SET nomusu= '$nombre', correo = '$correo' , contra = '$usuario', idtipo= $rol WHERE idusu = $idusuario");
        $alert = '<p>Usuario Actualizado</p>';
        header("Location:usuarios.php");
    }
}

// Mostrar Datos

if (empty($_REQUEST['id'])) {
    header("Location:usuarios.php");
}
$idusuario = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE idusu= $idusuario");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location:usuarios.php");
} else {
    if ($data = mysqli_fetch_array($sql)) {
        $idcliente = $data['idusu'];
        $nombre = $data['nomusu'];
        $correo = $data['correo'];
        $usuario = $data['contra'];
        $rol = $data['idtipo'];
    }
}
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 m-auto">
            <form class="" action="" method="post">
                <?php echo isset($alert) ? $alert : ''; ?>
                <input type="hidden" name="id" value="<?php echo $idusuario; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" placeholder="Ingrese nombre" class="form-control" name="nombre" id="nombre"
                        value="<?php echo $nombre; ?>">

                </div>
                <div class="form-group">
                    <label for="correo">Correo: </label>
                    <input type="text" placeholder="Ingrese correo" class="form-control" name="correo" id="correo"
                        value="<?php echo $correo; ?>">

                </div>
                <div class="form-group">
                    <label for="usuario">Contraseña:</label>
                    <input type="text" placeholder="Ingrese usuario" class="form-control" name="usuario" id="usuario"
                        value="<?php echo $usuario; ?>">

                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select name="rol" id="rol" class="form-control">
                        <option value="1" <?php
                                            if ($rol == 1) {
                                                echo "selected";
                                            }
                                            ?>>Administrador</option>
                        <option value="2" <?php
                                            if ($rol == 2) {
                                                echo "selected";
                                            }
                                            ?>>Supervisor</option>
                        <option value="3" <?php
                                            if ($rol == 3) {
                                                echo "selected";
                                            }
                                            ?>>Vendedor</option>
                    </select>
                </div>
                <a href="usuarios.php"><button type="button" class="btn btn-primary"><i class="fas fa-user-edit"></i>
                        Cancelar</button></a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Editar
                    Usuario</button>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "../Cliente/include/pie.php"; ?>