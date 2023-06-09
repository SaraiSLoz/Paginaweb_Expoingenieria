<?php
require '../databasereg.php';
session_start();

if (isset($_SESSION["usuario"])) {
    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    if ($id == null) {
        header("Location: index.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT proyecto.id_proy, proyecto.titulo, proyecto.descripcion, proyecto.poster, 
        proyecto.archivo_poster, proyecto.archivo_video,categoria.nombre_c as categoria, area_estrategica.nombre_a as area_estrategica, 
        profesores.nombre as profesor, unidad_de_formacion.nombre as unidad_formacion
        FROM proyecto 
        INNER JOIN categoria ON proyecto.id_categoria=categoria.id_c 
        INNER JOIN area_estrategica ON proyecto.id_AreaEstr=area_estrategica.id_a 
        INNER JOIN profesores ON proyecto.id_profesor = profesores.matricula
        INNER JOIN unidad_de_formacion ON proyecto.id_unidad_formacion = unidad_de_formacion.id
        WHERE id_proy = ?';
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        Database::disconnect();
    }

?>

    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" href="styleMod.css">
    </head>

    <body>
        <header>
            <table class="menu">
                <tr>
                    <td class="espacio"><a href="..\paginaInicio\index.html"><img class="logo" src="https://raw.githubusercontent.com/mikeedel/expoinge/main/logo-expo.svg"></a></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href="..\Conócenos\index.html">Conócenos</a></td>
                    <td><a href="..\Ediciones\index.html">Ediciones</a></td>
                    <td><a href="..\anucios-todos\index.html">Anuncios</a></td>
                    <td><a href="..\Contacto\index.html">Contacto</a></td>
                    <div class="iconos">
                        <td>
                            <div class="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"></path>
                                </svg>


                                <div class="dropdown-content">
                                    <a href="..\Perfil\perfil_juezinterno.php">Mi Perfil</a>
                                    <a href="..\Calificacion\index_proyectosjuezinterno.php">Calificar Proyectos</a>
                                    <a href="https://www.youtube.com/user/hubspot">Certificado</a>
                                    <a href="..\login\logout2.php">Cerrar sesión</a>
                                </div>



                            </div>
                        </td>
                    </div>


                </tr>
            </table>
        </header>
        <section class="main">
            <div class="calificacion">
                <a href="http://lab403azms01.itesm.mx/TC2005B_403_3/expoingenierias/Calificacion/index_proyectosjuezinterno.php"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back-up-double" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="black" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M13 14l-4 -4l4 -4"></path>
                        <path d="M8 14l-4 -4l4 -4"></path>
                        <path d="M9 10h7a4 4 0 1 1 0 8h-1"></path>
                    </svg></a>
                <h2>Proyecto: </h2>
            </div>
            <table class="center-table">
                <tr class="first-row">
                    <td><strong>Nombre:</strong></td>
                    <td><?php echo $data['titulo']; ?></td>
                    <td></td>
                    <td><strong>Area Estrategica:</strong></td>
                    <td><?php echo $data['area_estrategica']; ?></td>
                    <td></td>
                </tr>
                <tr class="white-row">
                    <td><strong>Profesor:</strong></td>
                    <td><?php echo $data['profesor']; ?></td>
                    <td></td>
                    <td><strong>Unidad Formación:</strong></td>
                    <td><?php echo $data['unidad_formacion']; ?></td>
                    <td></td>
                </tr>
                <tr class="white-row">
                    <td><strong>Nivel de Desarrollo:</strong></td>
                    <td><?php echo $data['categoria']; ?></td>
                    <td></td>
                    <td><strong>ID:</strong></td>
                    <td><?php echo $data['id_proy']; ?></td>
                    <td></td>
                </tr>
                <tr class="white-row">
                    <td><strong>Poster:</strong></td>
                    <td><?php echo $data['archivo_poster']; ?></td>
                    <td></td>
                    <td><strong>Video:</strong></td>
                    <td><?php echo $data['archivo_video']; ?></td>
                    <td></td>
                </tr>
                <tr class="white-row">
                    <td><strong>Descripcion:</strong></td>
                    <td><?php echo $data['descripcion']; ?></td>
                    <td></td>
                    <td><strong>Estructura Poster:</strong></td>
                    <td><?php echo ($data['poster']) ? "SI" : "NO"; ?></td>
                    <td></td>
                </tr>
            </table>

        </section>
    </body>

    </html>
<?php
} else {
    header("location:http://lab403azms01.itesm.mx/TC2005B_403_3/expoingenierias/paginaInicio/index.php");
}
?>