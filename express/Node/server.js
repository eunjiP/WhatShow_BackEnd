const express = require('express');
const app = express();

const server = app.listen(3000, () => {
    console.log("start server : localhost:3000");
});

//views 폴더를 import
app.set('views', __dirname + '/views'); 
app.set('view engine', 'ejs'); 

//엔진을 ejs사용, 자세한 내용은 ejs 내용 검색
app.engine('html', require('ejs').renderFile);
app.engine('php', require('ejs').renderFile);

app.get('/', function(req, res) { // 메인 접속시 나올 화면
    res.render('index.html')
})

app.get('/about', function(req, res) { // /about 접속시 나올 화면
    res.render('about.php')
})

var mysql = require('mysql');
var pool  = mysql.createPool({
  connectionLimit : 10,
  host            : 'example.org',
  user            : 'bob',
  password        : 'secret',
  database        : 'my_db'
});

app.get('/db', function(req, res) { // /about 접속시 나올 화면
    res.render('about.php')
})