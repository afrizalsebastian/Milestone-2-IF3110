require('dotenv').config();

module.exports = {
    secret : process.env.SECRET,
    refresh: process.env.REFRESH
}