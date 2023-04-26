<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar row">
      <div class="col-lg-12">
        <h4 class="nav_top_align"><i class="fa fa-inbox"></i> Bandeja de entrada</h4>
      </div>
    </div>
  </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="card">
                <div class="card-block">
                    <?php setlocale(LC_TIME, "spanish"); ?>
                    <?php $tu_fecha = date('Y-m-d'); ?>
                    <?php echo ucwords(strftime("%d/%B/%Y - %A", strtotime(date("d-m-Y", strtotime($tu_fecha))))); ?>
                </div>
            </div>
        </div>
    </div>
</div>
