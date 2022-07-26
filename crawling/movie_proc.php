<?php
    // python 실행 파일 경로입력 후 파일 위치 적기!!!!
    exec('C:\Users\Administrator\AppData\Local\Programs\Python\Python310\python.exe test2.py');
    header("Location: movie.php");
    // $data = $_POST['groupScheduleList'];
    // print_r($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <input id="btn_test" type="button" value="영화순위보기">
    <div id="result"></div>
    <script>
        const btn = document.querySelector('#btn_test');
        const result = document.querySelector('#result');
        // btn.addEventListener('click', function() {
        //     const url = 'https://movie.naver.com/movie/bi/mi/runningJson.naver';
        //     fetch(url, {
        //         method: "POST",
        //         headers: {
        //             'Content-Type': 'application/json'
        //         },
        //         body: JSON.stringify({
        //             code: 81888,
        //             regionRootCode : 10
        //         }),
        //     }).then((response) => response.json()).then((data) => {
        //     console.log(data);
        //     })
        // });

    </script>

</body>
</html>

