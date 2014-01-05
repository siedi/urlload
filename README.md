URLLoad
=======

Small script to run CURL requests to specified URLs and save the results to graphite.

Sometimes you do not want to run full blown performance tools like webpagtetest, keynote or load test like jmeter just to measure simple changes in your infrastructure.

Measures:
        'http_code',
        'header_size',
        'request_size',
        'total_time',
        'namelookup_time',
        'connect_time',
        'pretransfer_time',
        'size_download',
        'speed_download',
        'redirect_count',
        'starttransfer_time',
        'redirect_time'


Put in your cron and let it run every 5 minutes or so:

```bash
*/5 * * * * php /path/to/urlload/bin/run.php -c urlload.conf
```

Configuration
=============

Specify a config file by passing -c:
```bash
php run.php -c /path/to/my.conf
```

By default, looks for an urlload.conf in the conf/ folder. A sample file is given. Format is json.
