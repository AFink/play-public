registerPlugin({
    name: 'Sinusbot-ichHabKeinPlan',
    version: '1.0',
    description: 'Advanced API',
    author: 'Andreas Fink <andreas@andreasfink.xyz>',
    backends: ['ts3', 'discord'],
    enableWeb: false,
    requiredModules: [],
    vars: []
    }, (_, config) => {
    const errorMessages = {
        NoPermission: "Do you have enough permissions for this action?",
        DLDisabled: "Downloading is not enabled.",
        EQDisabled: "Enqueuing is not enabled.",
        PlayDisabled: "Playing is not enabled.",
        NoAPIKey: "No Youtube API Key set."
    };
    const engine = require('engine');
    const store = require('store');
    const event = require('event');
    const media = require('media');
    const http = require('http');
    const format = require('format');

    engine.log("AdvancedApi ready");


    event.on('api:ytplay', ev => {
        const res = new Response();
        // Check for PRIV_PLAYBACK
        if (!ev.user() || !ev.user().privileges || (ev.user().privileges() & 0x1000) == 0) {
            res.setError(errorMessages.NoPermission);
            return res.getData();
        }
        if (config.play != 1) {
            media.yt(ev.data());
            engine.log(`YTWeb Triggered with "played" at ${ev.data()}`);
            res.setData("The Video will be sucessfully played now.");
            return res.getData();
        } else {
            engine.log(`YTWeb tried to play ${ev.data()} but it was deactivated.`);
            res.setError(errorMessages.PlayDisabled);
            return res.getData();
        }
    });

    event.on('api:ytenq', ev => {
        const res = new Response();
        // Check for PRIV_ENQUEUE
        if (!ev.user() || !ev.user().privileges || (ev.user().privileges() & 0x2000) == 0) {
            res.setError(errorMessages.NoPermission);
            return res.getData();
        }
        if (config.enq != 1) {
            media.enqueueYt(ev.data());
            engine.log(`YTWeb Triggered with "enque" at ${ev.data()}`);
            res.setData("The Video will be sucessfully enqueued now.");
            return res.getData();
        } else {
            engine.log(`YTWeb tried to play ${ev.data()} but it was deactivated.`);
            res.setError(errorMessages.EQDisabled);
            return res.getData();
        }
    });

    event.on('api:ytdl', ev => {
        const res = new Response();
        // Check for PRIV_UPLOAD_FILE
        if (!ev.user || !ev.user().privileges || (ev.user().privileges() & 0x4) == 0) {
            res.setError(errorMessages.NoPermission);
            return res.getData();
        }
        if (config.dl != 1) {
            media.ytdl(ev.data(), false);
            engine.log(`YTWeb Triggered with "downloaded" at ${ev.data()}`);
            res.setData("The Video will be sucessfully downloaded now.");
            return res.getData();
        } else {
            engine.log(`YTWeb tried to download ${ev.data()} but it was deactivated.`);
            res.setError(errorMessages.DLDisabled);
            return res.getData();
        }
    });


});
