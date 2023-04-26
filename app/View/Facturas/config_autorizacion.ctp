<?php
echo $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',
                      
        ),
        array('inline'=>false));
?>
<style>
    .text-white{
        color: white;
    }
</style>

<!-- Modal para agregar nueva categoria -->
<div class="modal fade" id="nueva_categoria">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-user-plus"></i>
                  Agregar nueva categoria
              </h4>
            </div>
            <?= $this->Form->create('Categoria',array('url'=>array('action'=>'add', 'controller'=>'categorias')))?>
            <?= $this->Form->hidden( 'redirectTo', array('value' => 3) ) ?>
            <div class="modal-body">
                <div class="row">
                    <?= $this->Form->input('dic_factura_id', array('type'=>'select','options'=>$categorias_facturas,'class'=>'form-control', 'div'=>'col-sm-12','label'=>'Categoría Padre', 'required'=>true)) ?>
                </div>
                <div class="row">
                    <?= $this->Form->input('nombre', array('class'=>'form-control', 'div'=>'col-sm-12','label'=>'Nombre categoria*', 'required'=>true)) ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Agregar
                </button>
            </div>
          <?= $this->Form->end()?>
      </div>
    </div>
</div>

<div id="content" class="bg-container">
    
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <!-- Asignación de categoria para facturas -->
            <div class="row mt-2">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    Categorias para facturas
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <button class="btn btn-success float-right btn-labeled" data-toggle="modal" data-target="#nueva_categoria">
                                        Agregar nueva categoria.
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12 mt-1">
                                    <table class="table table-sm" id="table_facturas">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Categoria</th>
                                                <th>Desarrollo Aplicable</th>
                                                <th>Configurar</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categorias as $categoria): ?>
                                                <tr>
                                                    <td><?= $categoria['Categoria']['id'] ?></td>
                                                    <td><?= $categoria['Categoria']['nombre'] ?></td>
                                                    <td><?= $categoria['Desarrollo']['nombre'] ?></td>
                                                    <td>
                                                        <?= $this->Html->link('<i class="fa fa-cogs"></i>',array('controller'=>'facturas','action'=>'permisos_usuarios',$categoria['Categoria']['id']),array('escape'=>false)); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('controller'=>'categorias','action' => 'delete', $categoria['Categoria']['id']), array('escape'=>false, 'confirm'=>__('Desea eliminar esta validación', $categoria['Categoria']['id']))); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<?php 
    echo $this->Html->script([
        'components',
        'custom',
        '/vendors/datatables/js/jquery.dataTables.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.colReorder.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        
    ], array('inline'=>false));
?>

<script>
    
'use strict';
function myFunction(id){
    $("#modal_cuenta_delete").modal('show')
    document.getElementById("CuentaDeleteId").value = id;
}
$(document).ready(function () {

// Duplicar el encabezado de la tabla Cotizaciones para la busqueda por columna
$('#table_facturas thead tr').clone(true).appendTo( '#table_facturas thead' );
   $('#table_facturas thead tr:eq(1) th').each( function (i) {
       var title = $(this).text();
       $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

       $( 'input', this ).on( 'keyup change', function () {
           if (table_fac.column(i).search() !== this.value ) {
               table_fac
                   .column(i)
                   .search( this.value )
                   .draw();
           }
       } );
   } );

var table_fac = $('#table_facturas').DataTable({
   dom: 'Bflr<"table-responsive"t>ip',
   orderCellsTop: true,
   autoWidth: true,
   columnDefs: [
       {targets: 0, width: '40px'},
   ],
   language: {
       sSearch: "Buscador",
       lengthMenu: '_MENU_ registros por página',
       info: 'Mostrando _TOTAL_ registro(s)',
       infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
       emptyTable: "Sin información",
       paginate: {
           previous: 'Anterior',
           next: 'Siguiente'
       },
       infoEmpty:      "0 registros",
   },
   lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
   buttons: [
       {
           extend: 'excel',
           text: '<i class="fa  fa-file-excel-o"></i> Exportar',
           filename: 'Proveedores',
           class : 'excel',
           className: 'btn-secondary',
           charset: 'utf-8',
           bom: true
       },
       {
           extend: 'print',
           text: '<i class="fa  fa-print"></i> Imprimir',
           filename: 'Proveedores',
           className: 'btn-secondary',
       },
   ]
});



$('#date_range').daterangepicker({
   autoUpdateInput: false,
   locale: {
       cancelLabel: 'Clear'
   }
});
$('#date_range').on('apply.daterangepicker', function(ev, picker) {
   $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
   return false;
});

$('#date_range').on('cancel.daterangepicker', function(ev, picker) {
   $(this).val('');
   return false;
});

$('[data-toggle="popover"]').popover()

});
</script>
