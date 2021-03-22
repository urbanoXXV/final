<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <button type="button" v-on:click="run()" class="btn btn-danger"><i v-if="!play" class="fas fa-play"></i><i v-if="play" class="fas fa-pause"></i> Escuchar en Vivo</button>
                <audio ref="audio" src=""></audio>
                <div id="emailHelp" class="form-text">* Existe un desfase en el calculo del tiempo debido al tiempo de calculo</div>
                <div id="emailHelp" class="form-text">* El audio que se reproduce es referencial, si esta en pausa el websocket sigue consultando la transmision en vivo</div>
            </div>
        </div>
        <div class="row mt-4">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Slogan</th>
                    <th scope="col">Tiempo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="publi in publis" v-if="publi.time > 4">
                        <th scope="row">{{publi.tags}}</th>
                        <th scope="row">{{publi.time_mostrar}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props:  [
            'csrf',
            'authEndpoint'
        ],
        data: function() {
            return {
                play: false,
                url : 'https://playerservices.streamtheworld.com/api/livestream-redirect/RADIO_RPP.mp3?DIST=RPPplayer&TGT=RPPplayer&maxServers=2&ua=RadioTime&ttag=RadioTime',
                app: {
                    "key" : "ASADAADA123",
                    "host" : "final.codigorural.com",
                    "port" : 6001,
                    "path" : null,
                    "id": 12345
                },
                logs: [],
                pusher: null,
                connected: false,
                publis: {}
            }
        },
        mounted() {
            console.log('Component mounted.')
            console.log(this.csrf)
            this.connect()
        },
        methods: {
            run() {
                if(this.play) {
                    this.$refs.audio.src = ""
                    this.$refs.audio.pause()
                    this.play = !this.play
                } else {
                    this.$refs.audio.src = this.url
                    this.$refs.audio.play()
                    this.play = !this.play
                }
            },
            connect() {
                let vm = this
                this.pusher = new Pusher(this.app.key, {
                    wsHost: this.app.host === null ? window.location.hostname : this.app.host,
                    wsPort: this.app.port === null ? 6001 : this.app.port,
                    wssPort: this.app.port === null ? 6001 : this.app.port,
                    wsPath: this.app.path === null ? '' : this.app.path,
                    disableStats: true,
                    authEndpoint: vm.authEndpoint,
                    auth: {
                        headers: {
                            'X-CSRF-Token': vm.csrfToken,
                            'X-App-ID': this.app.id
                        }
                    },
                    enabledTransports: ['ws', 'flash']
                });

                this.pusher.connection.bind('state_change', states => {
                    console.log(states.current);
                });

                this.pusher.connection.bind('connected', () => {
                    this.connected = true;
                    console.log("connected")

                    //this.loadChart();
                });

                this.pusher.connection.bind('disconnected', () => {
                    this.connected = false;
                    this.logs = [];
                });

                this.pusher.connection.bind('error', event => {
                    if (event.error.data.code === 4100) {
                        console.log("Maximum connection limit exceeded!");
                        this.connected = false;
                        this.logs = [];
                        throw new Error("Over capacity");
                    }
                });

                //this.subscribeToAllChannels();
                this.subscribeToChannel("prediccion");

                //this.subscribeToStatistics();
            },
            subscribeToAllChannels() {
                [
                    'disconnection',
                    'connection',
                    'vacated',
                    'occupied',
                    'subscribed',
                    'client-message',
                    'api-message',
                ].forEach(channelName => this.subscribeToChannel(channelName))
            },

            subscribeToChannel(channel) {
                let vm = this
                this.pusher.subscribe(channel)
                    .bind('prediccion', (data) => {
                        vm.update(data)
                    });
            },
            update(data) {
                let vm = this
                this.$nextTick(function () {
                    if (data.mensaje in vm.publis) {
                    if ('time' in vm.publis[data.mensaje]) {
                        var time = vm.publis[data.mensaje].time
                        vm.publis[data.mensaje].time = time + 1
                        var hora = Math.floor((time + 1)/3600)
                        var minuto = Math.floor((time + 1 - time*hora)/60)
                        var segundo = time + 1 - time*hora - 60*minuto
                        if (hora < 10) {
                            var hora_text = "0" + hora
                        } else {
                            var hora_text = "" + hora +""
                        }
                        if (minuto < 10) {
                            var minuto_text = "0" + minuto
                        } else {
                            var minuto_text = "" + minuto +""
                        }
                        if (segundo < 10) {
                            var segundo_text = "0" + segundo
                        } else {
                            var segundo_text = "" + segundo +""
                        }
                        vm.publis[data.mensaje].mostrar = time + 1
                        vm.publis[data.mensaje].time_mostrar = hora_text + ":"+minuto_text+":"+segundo_text
                    }
                } else {
                    //Vue.set(vm.publis[data.mensaje] = new Object
                    Vue.set(vm.publis,data.mensaje, {})
                    Vue.set(vm.publis[data.mensaje],'tags', data.mensaje)
                    Vue.set(vm.publis[data.mensaje], 'time', 1)
                    Vue.set(vm.publis[data.mensaje], 'time_mostrar', '00:00:01')
                }
                console.log(data.mensaje)
                })
                
            },
            subscribeToStatistics() {
                this.pusher.subscribe('{{ \BeyondCode\LaravelWebSockets\Dashboard\DashboardLogger::LOG_CHANNEL_PREFIX }}statistics')
                    .bind('statistics-updated', (data) => {
                            var update = {
                                x:  [[data.time], [data.time], [data.time]],
                                y: [[data.peak_connection_count], [data.websocket_message_count], [data.api_message_count]]
                            };

                            Plotly.extendTraces('statisticsChart', update, [0, 1, 2]);
                    });
            },
        }
    }
</script>
