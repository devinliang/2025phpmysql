<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL</title>
</head>
<body>
    <h1>我的練習 php & mysql</h1>

    <p>今天是: <?= date("Y年m月d日") ?></p>
    <hr>
    <p>我的身高: <?= $h=175 ?></p>
    <p>我的體重: <?= $w=75 ?></p>
    <p>我的BMI值: <?= $w/($h/100*$h/100) ?></p>

</body>
</html>