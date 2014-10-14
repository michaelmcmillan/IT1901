
casper.test.begin('Login and logout of a user', 1, function suit (test) {
    var server = casper.cli.get("server");

    casper.start(server + '/index.php/authenticate');

    /* Start the stopwatch */
    casper.then(function () {
        test.assertVisible('input.btn', 'Login button is present');
    });

    casper.run(function() {
        test.done();
    });
});
