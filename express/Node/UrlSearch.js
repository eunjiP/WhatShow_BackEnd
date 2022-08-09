const axios = require('axios');
const cheerio = require('cheerio');
const log = console.log;

const getHtml = async() => {
    try {
        return await axios.get('https://movie.naver.com/movie/bi/mi/basic.naver?code=191634')
    } catch(error) {
        console.error(error);
    }
};

// img와 summary
getHtml()
.then((html) => {
    const $ = cheerio.load(html.data);
    const param = {
        imgSrc: $('#content > div.article > div.mv_info_area > div.poster > a > img')
        .attr('src')
        .replace(/\?.*/,'')
        ,
        TxtTitle: $('#content > div.article > div.section_group.section_group_frst > div:nth-child(1) > div.video > div.story_area > h5.h_tx_story')
        .text(),
        TxtAll: $('#content > div.article > div.section_group.section_group_frst > div:nth-child(1) > div.video > div.story_area > p.con_tx')
        .text(),
    };
    return data;
})
.then((res)=>log(res));

console.log(getHtml);




