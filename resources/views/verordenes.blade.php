<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/agregarServicio.css">
    <link rel="stylesheet" type="text/css" href="public/css/vehiculos.css">
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <title>Ver orden vehículos</title>
</head>

<body>
    <div class="widthview">
        <div class="btntitlebtn">
            <a class="btnbasic" href="index.php?c=Auxiliares&a=vehiculos">Nueva orden</a>
            <h2 style="text-align: center; padding: 10px;">VEHÍCULOS</h2>
            <a class="btnbasic" href="index.php?c=Auxiliares&a=vehiculostb" id="verArchivosBtn">Ver archivos</a>
        </div>
        <div class="tablaVehiculos">
            <table id="agenciaTable" class='tablaAg'>
                <thead>
                    <tr>
                        <th>
                            <p>No. Orden</p>
                        </th>
                        <th>
                            <p>No. Económico</p>
                        </th>
                        <th>
                            <p>Agencia</p>
                        </th>
                        <th>
                            <p>Fecha</p>
                        </th>
                        <th>
                            <p>Escaneo</p>
                        </th>
                        <th>
                            <p>Archivos</p>
                        </th>
                        <th>
                            <p>500</p>
                        </th>
                        <th>
                            <p>Estatus</p>
                        </th>
                        <th>
                            <p>Comentario</p>
                        </th>
                        <th>
                            <p>Opciones</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12345</td>
                        <td>ECO-589</td>
                        <td>Mérida CFE</td>
                        <td>08-11-2023</td>
                        <td>
                            <form action="#" method="post" enctype="multipart/form-data" class="formsubirserv">
                                <input type="file" id="btn-file" name="archivo" accept=".xlsx, .xls, .pdf">
                                <input type="hidden" name="id" value="12345">
                                <button id="btn-file" type="submit" class="btn">Subir</button>
                            </form>
                        </td>
                        <td>
                            <div class="variosArch">
                                <a class='btnbasicicon' style='background-color: cadetblue;' target='_blank' href='#' title='Documento'>Doc</a>
                                <a class='btnbasicicon' style='background-color: #45a049;' target='_blank' href='#' title='Escaneado'>Scan</a>
                            </div>
                        </td>
                        <td><a class='btnOrden500si' href='#'>500</a></td>
                        <td><a href='#' class='clase-entrega' title='Cambiar Estado'>Entrega en SG</a></td>
                        <td>Reparación de motor</td>
                        <td>
                            <div class='acciones'>
                                <a class='btnbasicicon green' href='#'><i class='bx bx-edit'></i></a>
                                <a class='btnbasicicon red delete-link' href='#'><i class='bx bx-trash'></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>12346</td>
                        <td>ECO-590</td>
                        <td>Progreso</td>
                        <td>07-11-2023</td>
                        <td>
                            <form action="#" method="post" enctype="multipart/form-data" class="formsubirserv">
                                <input type="file" id="btn-file" name="archivo" accept=".xlsx, .xls, .pdf">
                                <input type="hidden" name="id" value="12346">
                                <button id="btn-file" type="submit" class="btn">Subir</button>
                            </form>
                        </td>
                        <td>
                            <div class="variosArch">
                                <a class='btnbasicicon' style='background-color: cadetblue;' target='_blank' href='#' title='Documento'>Doc</a>
                                <a class='btnbasicicon' style='background-color: gray;' title='Sin escaneo'>Sin escaneo</a>
                            </div>
                        </td>
                        <td><p class='btnOrden500si'>500</p></td>
                        <td><a href='#' class='clase-taller' title='Cambiar Estado'>Taller</a></td>
                        <td>Revisión de frenos</td>
                        <td>
                            <div class='acciones'>
                                <a class='btnbasicicon green' href='#'><i class='bx bx-edit'></i></a>
                                <a class='btnbasicicon red delete-link' href='#'><i class='bx bx-trash'></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>12347</td>
                        <td>ECO-591</td>
                        <td>Cancún</td>
                        <td>06-11-2023</td>
                        <td>
                            <form action="#" method="post" enctype="multipart/form-data" class="formsubirserv">
                                <input type="file" id="btn-file" name="archivo" accept=".xlsx, .xls, .pdf">
                                <input type="hidden" name="id" value="12347">
                                <button id="btn-file" type="submit" class="btn">Subir</button>
                            </form>
                        </td>
                        <td>
                            <div class="variosArch">
                                <a class='btnbasicicon' style='background-color: cadetblue;' target='_blank' href='#' title='Documento'>Doc</a>
                                <a class='btnbasicicon' style='background-color: #45a049;' target='_blank' href='#' title='Escaneado'>Scan</a>
                            </div>
                        </td>
                        <td>No</td>
                        <td><a href='#' class='clase-entregado' title='Cambiar Estado'>Entregado</a></td>
                        <td>Cambio de llantas</td>
                        <td>
                            <div class='acciones'>
                                <a class='btnbasicicon green' href='#'><i class='bx bx-edit'></i></a>
                                <a class='btnbasicicon red delete-link' href='#'><i class='bx bx-trash'></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </body>

</html>
