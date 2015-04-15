#!/bin/sh

git clone -b 1.3.4 git://github.com/phalcon/cphalcon.git --depth=1
cd cphalcon/ext; export CFLAGS="-g3 -O1 -fno-delete-null-pointer-checks -Wall"; phpize && ./configure --enable-phalcon && make -j4 && sudo make install && phpenv config-add ./spec/phalcon.ini