const db = require('../models');
const User = db.user;


checkUsernameAndEmail = (req, res, next) =>{

    //Check Username
    User.findOne({
        where : {
            username : req.body.username
        }
    }).then(user => {
        if(user){
            res.status(400).send({
                message : "Failed! Username is already in use!"
            });
            return
        }
        //Check Email
        User.findOne({
            where : {
                email : req.body.email
            }
        }).then(user=>{
            if(user){
                res.status(400).send({
                    message : "Failed! Email is already in use!"
                })
                return;
            }
            next();
        });
    });
};

checkRegex = (req, res, next) =>{
    if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(req.body.email))){
        return res.status(400).send({message : "Your Email is Invalid!"})
    }

    if(!(/^\w+$/.test(req.body.username))){
        return res.status(400).send({message : "Your Username is Invalid! Username Must be Combination Alphanumeric and underscore"})
    }

    next();
}

module.exports = {
    isRegexTrue : checkRegex,
    isExists    : checkUsernameAndEmail
};

