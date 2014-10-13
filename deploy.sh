wget \
  --header='Authorization: token 9f8cf3c903e73c10218150d82a35de4abece9a67' \
  https://api.github.com/repos/michaelmcmillan/IT1901/tarball/production \
  -O production.tar;
tar -xvf 'production.tar' --strip-components=1;
rm 'production.tar';
