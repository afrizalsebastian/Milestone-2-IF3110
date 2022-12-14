const config = require('../config/db.config');
const Sequelize = require('sequelize');


const sequelize = new Sequelize(
    config.DB,
    config.USER,
    config.PASSWORD,
    {
        host : config.HOST,
        dialect : config.dialect,
        operatorAliases : false,

        pool : {
            max : config.pool.max,
            min : config.pool.min,
            acquire : config.pool.acquire,
            idle : config.pool.idle
        }
    }
)

const db = {};

db.Sequelize = Sequelize;
db.sequelize = sequelize;

db.user = require('../models/user.model')(sequelize, Sequelize);
db.song = require('../models/song.model')(sequelize, Sequelize);

db.user.hasMany(db.song, {
    foreignKey : 'penyanyi',
    as : 'song'
})
module.exports = db;