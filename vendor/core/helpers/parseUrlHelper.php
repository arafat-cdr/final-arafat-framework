<?php

function php_native_url_parser($url = 'http://username:password@hostname:9090/path?arg=value#anchor'){
    echo "for parse_url() <br/>";
    pr(parse_url($url));
    echo "for PHP_URL_SCHEME <br/>";
    pr(parse_url($url, PHP_URL_SCHEME));
    echo "for PHP_URL_USER <br/>";
    pr(parse_url($url, PHP_URL_USER));
    echo "for PHP_URL_PASS <br/>";
    pr(parse_url($url, PHP_URL_PASS));
    echo "for PHP_URL_HOST <br/>";
    pr(parse_url($url, PHP_URL_HOST));
    echo "for PHP_URL_PORT <br/>";
    pr(parse_url($url, PHP_URL_PORT));
    echo "for PHP_URL_PATH <br/>";
    pr(parse_url($url, PHP_URL_PATH));
    echo "for PHP_URL_QUERY <br/>";
    pr(parse_url($url, PHP_URL_QUERY));
    echo "for PHP_URL_FRAGMENT <br/>";
    pr(parse_url($url, PHP_URL_FRAGMENT));
}