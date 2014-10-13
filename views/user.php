
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
              <li><a href="#">Logg ut</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

    <div class="row map">
        <div class="col-md-12">
            <div id="map-canvas"></div>
        </div>
    </div>

    <div class="row reservation-form" style="display:none;">

        <div class="col-md-4">
            <fieldset>
                <div class="input-daterange">
                    <div class="form-group">
                        <input class="form-control date" name="from" placeholder="Fra dato" />
                    </div>

                    <div class="form-group">
                        <input class="form-control date" name="to" placeholder="Til dato" />
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-md-4">
            <fieldset>
                <div class="form-group">
                    <input class="form-control" placeholder="Antall senger" min="1" name="beds" type="number">
                </div>

                <div class="form-group">
                    <input type="hidden" name="cabin">
                    <input class="btn btn btn-success btn-block" name="reserve" type="submit" value="Reserver">
                </div>
            </fieldset>
        </div>

    </div>
</div>
