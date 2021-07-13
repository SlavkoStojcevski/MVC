    <div class="modal fade" id="getinform" tabindex="-1" aria-labelledby="welcome" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content bg-transparent animate text-light">
          <div class="modal-header mt-2 pt-2">
            <h5 class="text-success w-100">Welcome</h5>
              <button type="button" class="btn-close bg-danger"
              data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mx-2 my-2 py-3 px-4">
              <label for="email" class="form-label text-primary">Email address</label>
              <input name="email" type="email" placeholder="Email address" class="form-control 
              bg-transparent text-info" id="email" aria-describedby="emailHelp">
            </div>
            <div class="mx-2 my-2 py-3 px-4">
              <label for="password" class="form-label text-primary">Password</label>
              <input type="password" name="password" placeholder="Password" class="form-control bg-transparent text-info" id="password">
            </div>
            <div class="mx-2 my-1 py-2 px-4 form-check">
              <input checked type="checkbox"id="stay"name="stay"value="1" class="form-check-input mx-3">
              <label for="stay"class="form-check-label">Stay logged in</label>
            </div>
            <div class="mx-5 my-2 py-2">
              <button id="getin" name="getin" class="btn btn-success mx-5 px-5">Getin</button>
            </div>
            <div class="container rounded py-3 my-3" id="message"></div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <footer class="fixed-bottom animate blur shade px-5 py-1">
    <span class="text-success rounded px-3 py-1 fs-5">&copy; <a class="text-success text-decoration-none fw-bolder"href="https://www.linkedin.com/in/slavko-stojchevski-6b406b155">Slavko Stojchevski</a>'s website
    </span>
    <script src="views/jquery.js"></script>
    <script src="views\bootstrap-5-beta\js\bootstrap.bundle.js"></script><!-- Modal -->
    <script>
      var x="<?php echo $x;?>";
      $("#getin").click(function() {
        var stay=(document.getElementById('stay').checked)?1:0;
        $.ajax({
          type: "POST",
          url: "actions.php?action=getin",
          data:"email="+$("#email").val()+"&password="+$("#password").val()+"&stay="+stay,
          success: function(result) {
            if (result == "1") {
              window.location.assign("http://localhost/twitter.com/MVC/index.php?login=1");
            } else {
              $("#message").html(result);
              $("#message").show();
            }
          }
        })});
      $(".follow").click(function() {
        var id = $(this).attr("data-userid");
        $.ajax({
          type: "POST",
          url: "actions.php?action=follow",
          data: "id=" + id,
          success: function(result) {
            var idc = '[data-userid="' + id + '"]';
            if (result == "unsigned") {
              $("#getinform").modal('show');
            } else {
              $(idc).toggleClass("btn-success btn-danger");
              $(idc).html(result);
            }
          }
        })});
      $("#newtweet").click(
        function() {
          $.ajax({
            type: "POST",
            url: "actions.php?action=newtweet",
            data: "tweet=" + $("#tweet").val(),
            success: function(result) {
              if(result=="1"){
                $("#reportdanger").hide();
                $("#reportsuccess").show();
                $("#reportsuccess").html("Tweet posted:<br>"+$("#tweet").val());
              } else{
                $("#reportsuccess").hide();
                $("#reportdanger").show();
                $("#reportdanger").html(result);
              }
              $("#tweet").val("");;
            }
          })
        });
    </script>
  </footer>
</html>