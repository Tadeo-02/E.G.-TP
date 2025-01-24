<div class="container is-fluid mb-6">
    <h1 class="title">Locales</h1>
    <h2 class="subtitle">Lista de locales</h2>
</div>

<!-- <div class="container pb-6 pt-6">

    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Nombre de Local</th>
                    <th>Rubro Local</th>
                    <th>Ubicación Local</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="has-text-centered" >
					<td>1</td>
                    <td>nombreLocal</td>
                    <td>rubroLocal</td>
                    <td>ubicacionLocal</td>
                    <td>
                        <a href="#" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="#" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>

                <tr class="has-text-centered" >
                    <td colspan="7">
                        <a href="#" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>

                <tr class="has-text-centered" >
                    <td colspan="7">
                        No hay registros en el sistema
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <p class="has-text-right">Mostrando locales <strong>1</strong> al <strong>9</strong> de un <strong>total de 9</strong></p>

    <nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
        <a class="pagination-previous" href="#">Anterior</a>

        <ul class="pagination-list">
            <li><a class="pagination-link" href="#">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link is-current" href="#">2</a></li>
            <li><a class="pagination-link" href="#">3</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link" href="#">3</a></li>
        </ul>

        <a class="pagination-next" href="#">Siguiente</a>
    </nav>

</div>
 -->

 <div class="container pb-6 pt-6">  

   <?php
        require_once(__DIR__ . '/../php/main.php');

        # Eliminar locales #
        // if(isset($_GET['user_id_del'])){
        //     require_once "./php/usuario_eliminar.php";
        // }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="/TP ENTORNOS/Page/vistas/localsList.php?page=";
        $registros=1;
        $busqueda="";

        # Paginador locales #
        require_once (__DIR__. '/../php/listaLocales.php');
    
    ?>
</div> 