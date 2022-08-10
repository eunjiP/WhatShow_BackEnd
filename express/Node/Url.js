const axios = require('axios');
const cheerio = require('cheerio');
const fs = require('fs');

const log = console.log;
const code = '81888'

let result = [];

const getHtml = async() => {
    try {
        return await axios.get(`https://movie.naver.com/movie/bi/mi/basic.naver?code=${code}`)
    } catch(error) {
        console.error(error);
    }
};  
  
// img와 summary
getHtml()
.then((html) => {
    const $ = cheerio.load(html.data);
    const data = {
        SummaryTitle: $('#content > div.article > div.section_group.section_group_frst > div:nth-child(1) > div.video > div.story_area > h5.h_tx_story')
        .text(),
        SummaryAll: $('#content > div.article > div.section_group.section_group_frst > div:nth-child(1) > div.video > div.story_area > p.con_tx')
        .text()
    };
    const dataAll = data.SummaryTitle + data.SummaryAll
    return dataAll;
})
.then((res)=>log(res));

// console.log(getHtml);

let UrlSumfile = 'UrlMovieTxt.txt';
fs.open(UrlSumfile,'w', function(err, fd) {
    console.log('file open complete');
});

for(let k=0; k<3; k++ ){
    let resultValue = getHtml.dataAll;
    fs.appendFileSync('UrlMovieTxt.txt', resultValue + '\n', 'utf-8', function(error) {
        console.log(k+'err')
    });
}

