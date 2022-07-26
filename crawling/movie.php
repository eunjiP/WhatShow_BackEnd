<?php
    $filep = file("./movie.txt");

    if(!$filep) {
        die("파일을 열 수 없습니다.");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>네이버 영화</title>
    <style>
        .container { margin: 10px auto;}
    </style>
</head>
<body>
    <div class="container">
        <?php
        $nm = '';
        $tnm = '';
        foreach($filep as  $line) {
            //explode(기준 문자, 분리하려는 문자열) : 기준 문자를 잘라서 배열을 만들어줌 
            $item = explode('	', $line);
            // $str = "https://movie.naver.com/";
            if($nm !== $item[1]){ 
                $nm = $item[1]; ?>
                <div><img style="width: 100px;" src="<?=$item[0]?>"> 영화관 : <?=$item[1]?></div>
                <?php } ?>
                <?php if($item[5] !== $tnm) {?>
                    <div><?=$item[5]?></div>
                    <div>
                <?php $tnm = $item[5];} ?>
            <a href="<?=$item[6]?>"><button><?=$item[3]?></button></a>
            <!-- <div><button>예매 바로가기</button></a></div> -->
            <!-- <div>제목<?=$div[0]?></div>
            <div>시간 : <?=$div[1]?></div> -->
            <!-- <img src="<?=$line?>"> -->
            <?php
            if($item[5] !== $tnm){ ?>
                </div>
            <?php } 
        }
        // fclose($filep);
        ?>
    </div>
</body>
</html> 