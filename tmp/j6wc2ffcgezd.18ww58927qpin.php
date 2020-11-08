<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendario | Archistico</title>
</head>
<body>
    <h1>Calendario</h1>
    
    <?php foreach (($anni?:[]) as $anno): ?>
        <a href="<?= ($BASE) ?><?= (Base::instance()->alias('pdf', 'anno='.$anno)) ?>" target="_blank"><?= (trim($anno)) ?></a>
    <?php endforeach; ?>    
</body>
</html>