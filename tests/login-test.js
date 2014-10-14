
casper.test.begin('Login and logout of a user', 1, function suit (test) {
    var server = casper.cli.get("server");

    casper.start(server + '/index.php/authenticate', function() {
        test.assertTitleMatch(/NTNU/, 'NTNU ble funnet i tittelen');
    }).run(function() {
        test.done();
    });

});
