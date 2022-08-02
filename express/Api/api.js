//참고글 : https://velog.io/@gwak2837/Node.js-%EB%B0%B1%EC%97%94%EB%93%9C-%EA%B0%9C%EB%B0%9C
//백엔드 서버 키는법, 터미널에서 node api.js 입력

const express = require('express'); //npm install된 express import
const app = express(); 
const uuidAPIKey = require('uuid-apikey'); //npm install된 uuid 생성패키지 import

const server = app.listen(3001, () => { //백엔드 서버 연결, 성공시 콘솔 출력
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
        if(rank == 'daily'){
            let data = [//임시로 만든 객체, 차후 DB랑 연동해서 크롤링한 내용 보여줌
                {title:"한산:용의 출현", release:"2022-07-27", sales:"23,394,725,692"},
                {title:"미니언즈2", release:"2022-07-20", sales:"14,691,881,707"},
                {title:"탑건:매버릭", release:"2022-06-22", sales:"75,252,574,786"},
                {title:"외계+인 1부", release:"2022-07-20", sales:"14,200,700,032"},
                {title:"뽀로로 극장판 드래곤캐슬 대모험", release:"2022-07-28", sales:"1,634,845,635"}
            ];
            res.send(data);
        } else if (rank == 'weekly'){
            let data = [
                {title:"한산:용의 출현", release:"2022-07-27", sales:"23,394,725,692"},
                {title:"미니언즈2", release:"2022-07-20", sales:"14,691,881,707"},
                {title:"탑건:매버릭", release:"2022-06-22", sales:"75,252,574,786"},
                {title:"외계+인 1부", release:"2022-07-20", sales:"14,200,700,032"},
                {title:"뽀로로 극장판 드래곤캐슬 대모험", release:"2022-07-28", sales:"1,634,845,635"}
            ]
            res.send(data);
        } else {
                res.send('error');
            }
    }

    
        
    
})