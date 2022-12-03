require('dotenv').config();
const db = require('../models');
const User = db.user;
const Song = db.song;
const soap = require('soap');
const urlSOAP = "http://localhost:8080/api/SubscriptionService?wsdl";
//Controller lagu

//Create Lagu
exports.createLagu = (req, res) =>{
    const judul = req.body.judul;
    const penyanyi = req.body.penyanyi;
    const audioPath = req.body.audio_path;

    Song.sync({alter : true})
    .then(() =>{
        return Song.create({
            judul : judul,
            penyanyi : penyanyi,
            audio_path : audioPath
        })
    })
    .then(song => {
        res.status(200).send({message: "Song Successfully added", song})
    })
    .catch(err => {
        res.status(500).send({message : err.message});
    })
}

//Read Semua Lagu
exports.allSong = (req, res) => {
    Song.sync({alter : true})
    .then(() => {
        return Song.findAll({raw : true});
    })
    .then(song => {
        res.status(200).send(song);
    })
    .catch(err => {
        res.status(500).send({message : err.message});
    })
}

//Read Beberapa Lagu
exports.someSong = (req, res) => {
    const query= req.query; // menerima [/query?penyanyi=&judul, /query?id=, /query?penyanyi=, /query?judul=, /query?path=]

    if(query.penyanyi && query.judul){
        const intValue = parseInt(query.penyanyi, 10)
        const stringValue = query.judul.replace("%20", " ");
        Song.sync({alter : true})
        .then(() => {
            return Song.findAll({raw : true, where : {penyanyi : intValue, judul : stringValue}});
        })
        .then(song => {
            res.status(200).send(song);
        })
        .catch(err => {
            res.status(500).send({message : err.message});
        })
    }
    else if(query.id){
        const intValue = parseInt(query.id, 10)
        Song.sync({alter : true})
        .then(() => {
            return Song.findAll({raw : true, where : {song_id : intValue}});
        })
        .then(song => {
            res.status(200).send(song);
        })
        .catch(err => {
            res.status(500).send({message : err.message});
        })
    }else if(query.penyanyi){
        const intValue = parseInt(query.penyanyi, 10)
        Song.sync({alter : true})
        .then(() => {
            return Song.findAll({raw : true, where : {penyanyi : intValue}});
        })
        .then(song => {
            res.status(200).send(song);
        })
        .catch(err => {
            res.status(500).send({message : err.message});
        })
    }else if(query.judul){
        const stringValue = query.judul.replace("%20", " ");
        Song.sync({alter : true})
        .then(() => {
            return Song.findAll({raw : true, where : {judul : stringValue}});
        })
        .then(song => {
            res.status(200).send(song);
        })
        .catch(err => {
            res.status(500).send({message : err.message});
        })
    }else if(query.path){
        const stringValue = query.path.replace("%20", " ");
        Song.sync({alter : true})
        .then(() => {
            return Song.findAll({raw : true, where : {audio_path : stringValue}});
        })
        .then(song => {
            res.status(200).send(song);
        })
        .catch(err => {
            res.status(500).send({message : err.message});
        })
    }
}

//Update
exports.updateSong = (req, res) =>{
    const idSong = req.query.id; //Hanya Menerima ID => /query?id=
    const judul = req.body.judul;
    const path = req.body.audio_path;

    if(judul && path){
        Song.sync({alter : true})
        .then(() => {
            return Song.update({
                judul : judul,
                audio_path : path
            },
            {
                raw : true, 
                where : {
                    song_id : parseInt(idSong)
                }
            });
        })
        .then(() => {
            res.status(200).send({message : "Judul and audio_path successfully updated"});
        })
        .catch(err => {
            res.status(500).send({message : err.message});
        })
    }else if(judul){
        Song.sync({alter : true})
        .then(() => {
            return Song.update({
                judul : judul
            },
            {
                raw : true, 
                where : {
                    song_id : parseInt(idSong)
                }
            });
        })
        .then(() => {
            res.status(200).send({message : "Judul successfully updated"});
        })
        .catch(err => {
            res.status(500).send({message : err.message});
        })
    }else if(path){
        Song.sync({alter : true})
        .then(() => {
            return Song.update({
                audio_path : path
            },
            {
                raw : true, 
                where : {
                    song_id : parseInt(idSong)
                }
            });
        })
        .then(()=> {
            res.status(200).send({message : "Audio_path successfully updated"});
        })
        .catch(err => {
            res.status(500).send({message : err.message});
        })
    }
}

exports.deleteSong = (req, res) => {
    const idSong = req.query.id //Hanya Menerima ID => /query?id=

    Song.sync({alter : true})
        .then(() => {
            return Song.destroy({
                where : {
                    song_id : parseInt(idSong)
                }
            });
        })
        .then(() => {
            res.status(200).send({message : "Song successfully deleted"});
        })
        .catch(err => {
            res.status(500).send({message : err.message});
        })
}

//Read Penyanyi
exports.allSinger = (req, res) =>{
    User.sync({alter : true})
    .then(()=> {
        return User.findAll({
            attributes : ['user_id', 'name', 'email', 'username', 'createdAt', 'updatedAt'],
            raw : true,
            where :{
                isAdmin : 0
            }
        })
    })
    .then(user => {
        res.status(200).send(user);
    })
    .catch(err => {
        res.status(500).send({message : err.message})
    })
}



//Penyanyi dan Lagunya
exports.singerSong = (req,res) => {
    db.sequelize.sync({alter : true})
    .then(async () => {
        return await User.findAll({
            attributes : ['user_id', 'name', 'email', 'username', 'createdAt', 'updatedAt'],
            raw : true,
            where : {
                user_id : [2,3] //user_id
            }
        })
    })
    .then(async (users) => {
        for (const user of users){
            user.song = await Song.findAll({
                raw : true,
                attributes : ['song_id', 'judul', 'audio_path', 'createdAt', 'updatedAt'],
                where : {
                    penyanyi : user.user_id
                }
            })
        }
        res.status(200).send(users)
    })
}

exports.getAllRequestSubs = (req, res) => {
    const apiKey = process.env.KEY;

    soap.createClient(urlSOAP, {}, (err, client) => {
        if(err){
            res.status(500).send({message : "Error connect to SOAP"});
        }

        client.getAll({"api" : apiKey}, (err, result) => {
            if(err){
                res.status(500).send({message: "SQL Error"});
            }

            res.status(200).send(result);
        })
    })
}

exports.getAllPending = (req, res) => {
    const apiKey = process.env.KEY;

    soap.createClient(urlSOAP, {}, (err, client) => {
        if(err){
            res.status(500).send({message : "Error connect to SOAP"});
        }

        client.getAllStatusPending({"api" : apiKey}, (err, result) => {
            if(err){
                res.status(500).send({message: "SQL Error"});
            }

            res.status(200).send(result);
        })
    })
}

exports.acceptSubs = (req, res) => {
    const creator_id = req.body.creatorId;
    const creator_name = req.body.creatorName;
    const subscriber_id = req.body.subscriberId;
    const subscriber_name = req.body.subsriberName;
    const apiKey = process.env.KEY;

    soap.createClient(urlSOAP, {}, (err, client) => {
        if(err){
            res.status(500).send({message : "Error connect to SOAP"});
        }

        client.acceptSubs({
            "creatorId": creator_id, 
            "creatorName" : creator_name,
            "subsId" : subscriber_id, 
            "subsName" : subscriber_name,
            "status":"PENDING",
            "apiKey" : apiKey
        }, (err, result) => {
            if(err){
                res.status(500).send({message: "SQL Error"});
            }

            res.status(200).send(result);
        })
    })
}

exports.rejectSubs = (req, res) => {
    const creator_id = req.body.creatorId;
    const creator_name = req.body.creatorName;
    const subscriber_id = req.body.subscriberId;
    const subscriber_name = req.body.subsriberName;
    const apiKey = process.env.KEY;

    soap.createClient(urlSOAP, {}, (err, client) => {
        if(err){
            res.status(500).send({message : "Error connect to SOAP"});
        }

        client.rejectSubs({
            "creatorId": creator_id, 
            "creatorName" : creator_name,
            "subsId" : subscriber_id, 
            "subsName" : subscriber_name,
            "status":"PENDING",
            "apiKey" : apiKey
        }, (err, result) => {
            if(err){
                res.status(500).send({message: "SQL Error"});
            }

            res.status(200).send(result);
        })
    })
}


// exports.userBoard = (req, res)=>{
//     res.status(200).send({message : 'User Board'});
// }

// exports.adminBoard = (req, res)=>{
//     db.sequelize.sync({alter : true})
//     .then(async () => {
//         const user = await User.findByPK({
//             raw : true,
//             where : {
//                 user_id : 1
//             }
//         })

//         const song = await Song.findAll({
//             raw : true,
//             where : {
//                 penyanyi : 1
//             }
//         })

//         return {user, song}
//     })
//     .then(users =>{
//         res.status(200).send(users);
//     })
// }

