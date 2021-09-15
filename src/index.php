<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker - Minimal PHP/Apache services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title">Docker - Minimal PHP/Apache services</h1>
            <div class="content">
                <?php
                    date_default_timezone_set('Europe/Brussels');
                    printf('<h2>%s</h2>', date('l, F jS Y G:i:s'));
                    printf('<h2>%s</h2>', 'PHP v' . phpversion());
                ?>
            </div>
        </div>
    </section>
</body>
</html>
