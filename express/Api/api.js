//참고글 : https://velog.io/@gwak2837/Node.js-%EB%B0%B1%EC%97%94%EB%93%9C-%EA%B0%9C%EB%B0%9C
//백엔드 서버 키는법, 터미널에서 node api.js 입력

const express = require('express'); //npm install된 express import
const app = express(); 
const uuidAPIKey = require('uuid-apikey'); //npm install된 uuid 생성패키지 import

const mysql = require('mysql');
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '506greendg@',
    database: 'shop' 
});

const server = app.listen(3001, () => { //백엔드 서버 만듬, 성공시 콘솔 출력
    console.log('Start Server : localhost:3001');
});

//console.log(uuidAPIKey.create()); uuid키 생성(테스트라 콘솔로 출력했음, 직접 사용시 DB랑 연결해야됨)
const key = { //생성된 uuid 정의
    apiKey: 'N624RC7-G5647YE-MKQVWZE-9N1P8A9',
    uuid: 'a9844c30-814c-43f9-a4ef-be7d4d436429'
}


app.get('/api/movie/:apikey/:rank', async (req, res) => { 
    //부메랑으로 http://localhost:3001/api/movie/부여받은앱키/daily or weekly입력시 api 서버 연결
    let {
        apikey,
        rank
    } = req.params;
    console.log(rank);

    if(!uuidAPIKey.isAPIKey(apikey) || !uuidAPIKey.check(apikey, key.uuid)){ //api키를 체크 틀리면 오류, 맞으면 보여줌
        res.send('apikey is not valid.');
    } else {
        if(rank == 'computer'){
            connection.connect();//DB 커넥션
            connection.query('SELECT * from t_category WHERE cate2="컴퓨터"', (error, rows, fields) => {
                if (error) throw error;
                console.log('User info is : ', rows);
                res.send(rows);
                connection.end();
            });
            
            
        } else if (rank == 'appliances'){
            connection.connect();//DB 커넥션//
            connection.query('SELECT * from t_category WHERE cate2="가전제품"', (error, rows, fields) => {
                if (error) throw error;
                console.log('User info is : ', rows);
                res.send(rows);
                connection.end();
            });
        } else {
                res.send('error');
            }
    }

    
        
    
})