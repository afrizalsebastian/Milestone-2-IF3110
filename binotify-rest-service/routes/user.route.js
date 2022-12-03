const {authJwt} = require('../middleware');
const controller = require('../controller/user.controller');

module.exports = (app) =>{
    app.use((req, res, next) => {
        res.header(
            "Access-Control-Allow-Headers",
            "x-access-token, Origin, Content-Type, Accept"
        );
        next();
    });

    //Song
    app.post(
        '/api/song',
        [authJwt.verifyToken],
        controller.createLagu
    )

    app.get(
        '/api/song',
        [authJwt.verifyToken],
        controller.allSong
    )

    app.get(
        '/api/song/:param',
        [authJwt.verifyToken],
        controller.someSong
    )

    app.patch(
        '/api/song/:param',
        [authJwt.verifyToken],
        controller.updateSong
    )

    app.delete(
        '/api/song/:param',
        [authJwt.verifyToken],
        controller.deleteSong
    )

    //List penyanyi
    app.get(
        '/api/singer',
        controller.allSinger
    )

    app.get(
        '/api/singerSong',
        controller.singerSong
    )

    app.get(
        '/api/subsRequest',
        [authJwt.verifyToken, authJwt.isAdmin],
        controller.getAllRequestSubs
    )

    app.get(
        '/api/subsRequest/pending',
        [authJwt.verifyToken, authJwt.isAdmin],
        controller.getAllPending
    )

    app.post(
        '/api/subsRequest/accept',
        [authJwt.verifyToken, authJwt.isAdmin],
        controller.acceptSubs
    )

    app.post(
        '/api/subsRequest/reject',
        [authJwt.verifyToken, authJwt.isAdmin],
        controller.rejectSubs
    )
}