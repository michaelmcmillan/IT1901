
<div class="container">

     <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Reservasjon</span>
            </button>
            <a class="navbar-brand" href="#">Reservasjon</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a id="reservation-previous" href="#">Tidligere reservasjoner</a></li>
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

    <!-- Report a stay -->
    <div class="modal reservation-report">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Rapport</h4>
                </div>

                <div class="modal-body">
                    <p>
                        Hvis noe ble ødelagt under oppholdet må det rapporteres under.
                        Dersom du har noen kommentarer legger du det til.
                    </p>

                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Inventar</th>
                          <th>Kommentar</th>
                          <th class="broken">Ødelagt</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>Piano</td>
                              <td class="comment"><input type="text" class="form-control input-xs"></td>
                              <td class="broken"><input type="checkbox"></td>
                          </tr>
                      </tbody>
                    </table>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Lukk</button>
                    <button type="button" class="btn btn-success">Lagre</button>
                </div>
            </div>
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

    <!-- Reservation form -->
    <div class="row reservation-form" style="display:none;">

        <div class="col-md-4">
            <fieldset>
                <div class="input-daterange">
                    <div class="form-group">
                        <input class="form-control date" name="from" placeholder="Fra dato" required />
                    </div>

                    <div class="form-group">
                        <input class="form-control date" name="to" placeholder="Til dato" required />
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-md-4">
            <fieldset>
                <div class="form-group">
                    <input class="form-control" placeholder="Antall senger" min="1" name="beds" type="number" required>
                </div>

                <div class="form-group">
                    <input type="hidden" name="cabin">
                    <input class="btn btn btn-success btn-block" name="reserve" type="submit" value="Reserver">
                </div>
            </fieldset>
        </div>

    </div>
</div>
