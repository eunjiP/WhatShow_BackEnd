const { info } = require('console');
const nodemailer = require('nodemailer');
const email = {
    host: "smtp.mailtrap.io",
  port: 2525,
  auth: {
    user: "07b51b36e69034",
    pass: "0ebcec335ac5f5"
  }

}

const send = async (Option) => {
    nodemailer.createTransport(email).sendMail(Option, (error, info) => {
        if(error){
            console.log(error);
        } else {
            console.log(info);
            return info.response;
        }
    });
    
};

let email_data = {
    from: 'michamet@naver.com',
    to: 'akuaru@gmail.com',
    subject: '테스트 메일',
    test: '메일 잘 도착함?'
}

send(email_data);