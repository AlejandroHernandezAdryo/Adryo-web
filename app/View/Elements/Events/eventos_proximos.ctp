<style>
    .table th, .table td {
        border-top: 1px solid #dbdbdb !important;
    }
</style>

<?= $this->element('Events/eventos_abc'); ?>
<table class="table table-sm">
    <tbody>
        <?php foreach($eventos as $evento): ?>
            <tr>
                <td>
                
                <div class="col-sm-12">
                    <span style="text-transform: uppercase;">
                        <i class = "fa fa-<?= $evento['icon'] ?>" ></i>
                        <?= $evento['titulo'] ?>
                        de 
                        <?= $evento['asesor'] ?>
                    </span>
                    
                    <?php if( $evento['tipo_tarea'] <= 1 ): ?>
                        <i class="fa fa-map-marker"></i> <?= $evento['ubicacion'] ?>
                    <?php endif; ?>
                </div>
                
                <div class="col-sm-12">

                    <?php if( $evento['tipo_tarea'] == 0 ): ?>
                        <span class="float-xl-right">
                        
                            <?php
                                switch( $evento['status'] ){
                                    case 0:
                                        echo "<a class='pointer' rel='noreferrer' onclick='cancelarEvent(".$evento['id_evento'].");' data-toggle ='tooltip' title='CANCELAR'> <i class='fa fa-close'></i></a>

                                        <a class='pointer' rel='noreferrer' onclick='confirmarEvent(".$evento['id_evento'].");' data-toggle  ='tooltip' title='CONFIRMAR'> <i class='fa fa-check'></i></a>";
                                    break;
                                    case 1:
                                        echo "<a class='pointer' rel='noreferrer' onclick='cancelarEvent(".$evento['id_evento'].");' data-toggle ='tooltip' title='CANCELAR'> <i class='fa fa-close'></i></a>
                                        
                                        <a class='pointer' rel='noreferrer' onclick='confirmarEvent(".$evento['id_evento'].");' data-toggle  ='tooltip' title='CONFIRMAR'> <i class='fa fa-check'></i></a>";
                                    break;
                                }
                            ?>

                            <a class='pointer' rel='noreferrer' onclick="<?= $evento['url'] ?>" data-toggle  ='tooltip' title='Ver'> <i class='fa fa-eye'></i></a>
                            

                        </span>
                    <?php endif; ?>

                    <span class="tag tag-pill" style="background-color: <?= $evento['color'] ?>; color: <?= $evento['textColor'] ?>">
                        <i class ="fa fa-clock-o fa-lg"> <?= $evento['fecha_inicio_format'] ?></i>
                    </span>

                </div>
                    


                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
