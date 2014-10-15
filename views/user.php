
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
              <li><a href="#">Tidligere reservasjoner</a></li>
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
    <div class="row reservation-previous">
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
                <tr>
                  <td>Flåkoia</td>
                  <td>23.03.2013</td>
                  <td>22.03.2014</td>
                  <td class="report"><button type="button" class="btn btn-xs btn-danger">Avlegg</button></td>
                </tr>
                <tr>
                  <td>Flåkoia</td>
                  <td>23.03.2013</td>
                  <td>22.03.2014</td>
                  <td><button type="button" class="btn btn-xs btn-success">Motatt</button></td>
                </tr>
                <tr>
                  <td>Flåkoia</td>
                  <td>23.03.2013</td>
                  <td>22.03.2014</td>
                  <td><button type="button" class="btn btn-xs btn-success">Motatt</button></td>
                </tr>
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
