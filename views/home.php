<div class="container py-5 my-5" id="home">
  <div class="container">
    <div class="row">
      <div class="col-md-5" id="tweets">
        <h3 class="text-info text-break blur py-2 px-4 my-5 rounded position-fixed">
          <?php echo $ti;?>
        </h3><br><br><br><br>
        <?php $tw?tweets($t):profiles();?>
      </div>
      <div class="col-md-2"></div>
      <div class="col-md-5">
        <div id="new_tweet"></div>
        <strong>
          <div class="alert mt-5 alert-success text-break" id="reportsuccess"></div>
          <div class="alert mt-5 alert-danger text-break" id="reportdanger"></div>
        </strong>
        <?php newtweet();?>
      </div>
    </div>
  </div>
</div>