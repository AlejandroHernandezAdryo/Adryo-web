<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>
<div style="margin-top:5%; color:white">
    <p class="error">
            <strong>La dirección que intentas acceder, no existe o tiene un error.</strong>
            <?php printf(
                    __d('cake', 'Error: MC-01'),
                    "<strong>'{$url}'</strong>"
            ); ?>
    </p>
</div>
