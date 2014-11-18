
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
              <li><a id="reservation-statistics" href="#">Statistikk</a></li>
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

    <!-- Status form -->
    <div class="row status-form" style="display:none;">
        <div class="col-md-12">
            <h2 id="cabin"></h2>
            <h3>Statistikk</h3>
            <div id="stats"></div>

            <h3>Inventartstaus</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Inventar</th>
                        <th>Kommentar</th>
                        <th class="broken">Ødelagt</th>
                    </tr>
                </thead>
                <tbody class="report-inventory">
                    <!-- Inventory gets injected here -->
                </tbody>
            </table>
            <button type="button" class="btn btn-success save-report">Lagre</button>
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
