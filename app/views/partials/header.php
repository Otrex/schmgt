<!DOCTYPE html>
<html lang ="en-US">
<head>
    <meta charset="utf-8" >

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- For extra meta addition from setup part -->
    <?php if(isset($metaExtra)) : ?>
        <?php foreach ($metaExtra as $meta) : ?>
            <?=$meta; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <title><?=ucfirst($title) ?></title>

    <!-- This is been added because all pages of schoolmgt uses them -->
    <link rel="stylesheet" href="../dependencies/bootstrap/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->
    
    <?php foreach ($JSHeaderSources as $src): ?>
        <script src="<?=$src; ?>" rel="stylesheet"></script>
    <?php endforeach; ?>

    <script src="../dependencies/jquery/jquery.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
    crossorigin="anonymous"></script> -->
    
    <script src="../dependencies/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" 
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" 
    crossorigin="anonymous"></script> -->

    <!-- Add General JS files -->
    <?php foreach ($CSSsources as $href): ?>
        <link href="<?=$href; ?>" rel="stylesheet" />
    <?php endforeach; ?>

    

    </head>
    <body>

    <!-- Incase you want to add new attributes -->
    <div 
        <?php foreach ($BodyAttr as $attr => $value): ?>
            <?=$attr;?> = "<?=$value; ?>" 
        <?php endforeach; ?> 
    >