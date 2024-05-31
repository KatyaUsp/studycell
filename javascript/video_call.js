const localVideo = document.getElementById('localVideo');
const remoteVideo = document.getElementById('remoteVideo');
const callDuration = document.getElementById('callDuration');
const peerConnectionConfig = {
    'iceServers': [{ 'urls': 'stun:stun.l.google.com:19302' }]
};

let localStream;
let peerConnection;
const socket = new WebSocket('ws://localhost:8080');

let callStartTime;
let callTimerInterval;


navigator.mediaDevices.getUserMedia({ video: true, audio: true })
    .then(stream => {
        localStream = stream;
        localVideo.srcObject = stream;

        peerConnection = new RTCPeerConnection(peerConnectionConfig);
        peerConnection.onicecandidate = event => {
            if (event.candidate) {
                socket.send(JSON.stringify({ 'ice': event.candidate }));
            }
        };
        peerConnection.ontrack = event => {
            remoteVideo.srcObject = event.streams[0];
            if (!callStartTime) {
                callStartTime = Date.now();
                startCallTimer();
            }
        };

        stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));

        socket.onmessage = message => {
            const data = JSON.parse(message.data);
            if (data.sdp) {
                peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp)).then(() => {
                    if (data.sdp.type === 'offer') {
                        peerConnection.createAnswer().then(answer => {
                            peerConnection.setLocalDescription(answer).then(() => {
                                socket.send(JSON.stringify({ 'sdp': answer }));
                            });
                        });
                    }
                });
            } else if (data.ice) {
                peerConnection.addIceCandidate(new RTCIceCandidate(data.ice));
            }
        };


        peerConnection.createOffer().then(offer => {
            peerConnection.setLocalDescription(offer).then(() => {
                socket.send(JSON.stringify({ 'sdp': offer }));
            });
        });
    })
    .catch(error => {
        console.error('Error accessing media devices.', error);
    });

function startCallTimer() {
    callTimerInterval = setInterval(() => {
        const elapsedTime = Date.now() - callStartTime;
        const minutes = Math.floor(elapsedTime / 60000);
        const seconds = Math.floor((elapsedTime % 60000) / 1000);
        callDuration.textContent = `${pad(minutes)}:${pad(seconds)}`;
    }, 1000);
}

function pad(value) {
    return value.toString().padStart(2, '0');
}

window.onunload = window.onbeforeunload = () => {
    if (peerConnection) {
        peerConnection.close();
    }
    if (socket) {
        socket.close();
    }
};
