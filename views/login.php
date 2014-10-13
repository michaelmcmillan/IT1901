
<!--    <form method="post" action="index.php/authentication">
        <input type="text" name="username">
        <input type="password" name="password">
        <input type="submit" value="Logg inn!!">
    </form>
-->

<div class="container">
    <div class="row ">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">

                <div class="panel-heading">
			    	<h3 class="panel-title">Logg inn</h3>
			 	</div>

                  <div class="panel-body">
			    	<form method="post" action="authenticate" role="form">
                        <fieldset>
                            <div class="form-group">
    			    		    <input class="form-control" placeholder="E-post" name="username" type="email">
    			    		</div>

                            <div class="form-group">
    			    			<input class="form-control" placeholder="Passord" name="password" type="password" value="">
    			    		</div>

                            <div class="checkbox">
    			    	    	<label>
    			    	    		<input name="remember" type="checkbox" value="remember"> Husk meg
    			    	    	</label>
    			    	    </div>

    			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Logg inn">
    			    	</fieldset>
			      	</form>
			    </div>

			</div>
		</div>
	</div>
</div>
