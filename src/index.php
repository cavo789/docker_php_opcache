<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker - PHP - OpCache optimization</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Docker - PHP - OpCache optimization</h1>
            <div class="content">
                <?php
                    date_default_timezone_set('Europe/Brussels');
                    printf('<h2>%s</h2>', date('l, F jS Y G:i:s'));
                    printf('<h2>%s</h2>', 'PHP v' . phpversion());

                    // Is OpCache installed in the image/on the server?
                    if (!extension_loaded('Zend OPcache')) {
                        printf(
                            '<div style="padding:10px;" class="has-background-danger-dark has-text-white"><p>%s</p>' .
                            '<ol><li>%s</li><li>%s</li><li>%s</li><li>%s</li></ol></div>',
                            'Zend OPcache IS NOT INSTALLED. Please make sure:',
                            "you've an .env file (otherwise run `cp .env.example .env`),",
                            'the INSTALL_OPCACHE variable in your .env file is set to true,',
                            'rebuild the image bu running "./docker-down.sh ; ./docker-up.sh" in a console,',
                            'refresh this page.'
                        );
                        die();
                    }

                    // Ok, well installed but is it enabled?
                    $arr=opcache_get_configuration();

                    if (1 !== intval($arr['directives']['opcache.enable'])) {
                        printf(
                            '<div style="padding:10px;" class="has-background-danger-dark has-text-white"><p>%s</p>' .
                            '<ol><li>%s</li><li>%s</li><li>%s</li><li>%s</li></ol></div>',
                            'Zend OPcache is well installed BUT IS NOT ENABLED. Please make sure:',
                            "you've an .env file (otherwise run `cp .env.example .env`),",
                            'the OPCACHE_ENABLE variable in your .env file is set to true,',
                            'recreate the image by running "docker-compose up -d" in a console),',
                            'refresh this page.'
                        );
                        die();
                    }

                    printf(
                        '<div style="padding:10px;" class="has-background-primary-dark has-text-white"><p>%s</p></div>',
                        'Congratulations, '.$arr['version']['opcache_product_name'] . ' v' . $arr['version']['version'] . ' IS INSTALLED AND ENABLED.',
                    );

                    echo '<h2>Run benchmarking with / without</h2>';
                    echo '<p>Run "docker exec -it myDockerApp_php php bench.php" on the command '.
                        'line to get the time needed to run the script. Enable OpCache_Cli (see .env OPCACHE_ENABLE_CLI variable ) and try again.</p>';

                        if (1 !== intval($arr['directives']['opcache.enable_cli'])) {
                            printf(
                                '<div style="padding:10px;" class="has-background-info-dark has-text-white"><p>%s</p>' .
                                '<ol><li>%s</li><li>%s</li><li>%s</li><li>%s</li></ol></div>',
                                'Zend OPcache is not enabled for CLI scripts:',
                                "you've an .env file (otherwise run `cp .env.example .env`),",
                                'the OPCACHE_ENABLE_CLI variable in your .env file is set to true,',
                                'recreate the image by running "docker-compose up -d" in a console),',
                                'refresh this page.'
                            );
                        }
                    echo '<h2>Configuration items</h2>';

                    echo '<pre>'. print_r($arr,true).'</pre>';
                ?>
            </div>
        </div>
    </section>
</body>
</html>
