
<div class="container">

     <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Administrasjon</span>
            </button>
            <a class="navbar-brand" href="#">Administrasjon</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a id="reservation-previous" href="#">Statistikk</a></li>
              <li><a href="<?php echo $url?>/index.php/logout">Logg ut</a></li>
            </ul>
          </div>
        </div>
      </div>

    <div class="row map">
        <div class="col-md-12">
            <div id="map-canvas"></div>
        </div>
    </div>

    <!-- Previous reservations list -->
    <div class="row reservation-previous" style="display:none;">
        <div class="col-md-12">
            <table class="table table-hover reservation-table">
              <thead>
                <tr>
                  <th>Koie</th>
                  <th>Fra ...</th>
                  <th>Til</th>
                  <th>Rapporter</th>
                </tr>
              </thead>
              <tbody>
                  <!-- Reservations will be appended here -->
              </tbody>
            </table>
        </div>
    </div>
</div>
