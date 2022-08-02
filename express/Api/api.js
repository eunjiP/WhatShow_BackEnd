const express = require('express'); //express import
const app = express(); 
const uuidAPIKey = require('uuid-apikey'); //uuid 생성 npm import

const server = app.listen(3001, () => { //백엔드 서버 연결, 성공시 콘솔 출력 //내용 변경 ㄱㄱㄱ
    console.log('Start Server : localhost:3001');
});

const key = { //uuid 확인
    apiKey: 'N624RC7-G5647YE-MKQVWZE-9N1P8A9',
  uuid: 'a9844c30-814c-43f9-a4ef-be7d4d436429'
}

//console.log(uuidAPIKey.create()); uuid키 생성

app.get('/api/movie/:apikey/:rank', async (req, res) => {
    let {
        apikey,
        rank
    } = req.params;
    console.log(rank);

    if(!uuidAPIKey.isAPIKey(apikey) || !uuidAPIKey.check(apikey, key.uuid)){ //api키를 체크 틀리면 오류, 맞으면 보여줌
        res.send('apikey is not valid.');
    } else {
        if(rank == 'daily'){
            let data = [
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