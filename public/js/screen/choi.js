var app = new Vue({
    el: '#app',
    data: {
        view: false,
        viewmodal: false,
        contentmodal: "",
        setting: {
            woft: 0,
            checkedRole: [],
        },
        checkedMember: [],
        myrole: {
            name: "Chưa nhận",
            note: ""
        },
        items: [],
        user: {
            username: null,
            room: null
        },
        valid: {
            username: /^\w{3,15}$/
        },
        warning: {
            username: {
                status: 0,
                text: ""
            }
        },
        qrcode: new QRious({ size: 200 })
    },
    created: function() {
        var self = this;
        setInterval(function() {
            var data = { room: room };
            axios.post('/ping', null, { params: data }).then(function(response) {
                if (self.items != response.data) {
                    self.items = response.data;
                }
            }).catch(function(error) {
                console.log(error);
            });

            axios.post('/getrole', null, { params: data }).then(function(response) {
                if (self.myrole != response.data) {
                    self.myrole = response.data;
                }
            }).catch(function(error) {
                console.log(error);
            });

        }, 1000);
    },
    computed: {
        newQRCode() {
            this.qrcode.value = window.location.href;
            return this.qrcode.toDataURL();
        },
    },
    methods: {
        trombai: function() {
            var self = this;
            var data = { room: room, target: this.checkedMember };

            axios.post('/doi2bai', null, { params: data }).then(function(response) {
                console.log(response.data);
                self.contentmodal = response.data;
                self.viewmodal = true;
                self.view = false;
            }).catch(function(error) {
                self.contentmodal = "Lỗi hệ thống rồi";
                self.viewmodal = true;
                console.log(error);
            });
        },
        nhanban: function() {
            var self = this;
            var data = { room: room, target: this.checkedMember };

            axios.post('/nhanban', null, { params: data }).then(function(response) {
                console.log(response.data);
                self.contentmodal = response.data;
                self.viewmodal = true;
                self.view = false;
            }).catch(function(error) {
                self.contentmodal = "Lỗi hệ thống rồi";
                self.viewmodal = true;
                console.log(error);
            });
        },
        keotheo: function() {
            var self = this;
            var data = { room: room, target: this.checkedMember };

            axios.post('/keotheo', null, { params: data }).then(function(response) {
                console.log(response.data);
                self.contentmodal = response.data;
                self.viewmodal = true;
                self.view = false;
            }).catch(function(error) {
                self.contentmodal = "Lỗi hệ thống rồi";
                self.viewmodal = true;
                console.log(error);
            });
        },
        doi2bai: function() {
            var self = this;
            var data = { room: room, target: this.checkedMember };

            axios.post('/doi2bai', null, { params: data }).then(function(response) {
                console.log(response.data);
                self.contentmodal = response.data;
                self.viewmodal = true;
                self.view = false;
            }).catch(function(error) {
                self.contentmodal = "Lỗi hệ thống rồi";
                self.viewmodal = true;
                console.log(error);
            });
        },
        tientri: function() {
            var self = this;
            var data = { room: room, target: this.checkedMember };

            axios.post('/tientri', null, { params: data }).then(function(response) {
                console.log(response.data);
                self.contentmodal = response.data;
                self.viewmodal = true;
                self.view = false;
            }).catch(function(error) {
                self.contentmodal = "Lỗi hệ thống rồi";
                self.viewmodal = true;
                console.log(error);
            });
        },
        generateGame: function() {
            var self = this;
            var data = { room: room, roles: this.setting.checkedRole, woft: this.setting.woft };

            axios.post('/generate', null, { params: data }).then(function(response) {
                console.log(response.data);
                self.view = false;
            }).catch(function(error) {
                console.log(error);
            });
        },
        clearRole: function() {
            var self = this;
            var data = { room: room };

            axios.post('/clearRoles', null, { params: data }).then(function(response) {
                console.log(response.data);
                self.view = false;
            }).catch(function(error) {
                console.log(error);
            });
        },
        kickMember: function(id) {
            var data = { uid: id };
            axios.post('/kickMember', null, { params: data }).then(function(response) {
                console.log(response.data);
            }).catch(function(error) {
                console.log(error);
            });
        },
        addGold: function(id) {
            var data = { uid: id };
            axios.post('/addGold', null, { params: data }).then(function(response) {
                console.log(response.data);
            }).catch(function(error) {
                console.log(error);
            });
        },
        addPerVillage: function() {
            var data = { room: room };
            axios.post('/addPerVillage', null, { params: data }).then(function(response) {
                console.log(response.data);
            }).catch(function(error) {
                console.log(error);
            });
        },
        addPerWoft: function() {
            var data = { room: room };
            axios.post('/addPerWoft', null, { params: data }).then(function(response) {
                console.log(response.data);
            }).catch(function(error) {
                console.log(error);
            });
        },
        kill: function(id) {
            var data = { uid: id };
            axios.post('/kill', null, { params: data }).then(function(response) {
                console.log(response.data);
            }).catch(function(error) {
                console.log(error);
            });
        },
        revival: function(id) {
            var data = { uid: id };
            axios.post('/revival', null, { params: data }).then(function(response) {
                console.log(response.data);
            }).catch(function(error) {
                console.log(error);
            });
        },
        subGold: function(id) {
            var data = { uid: id };
            axios.post('/subGold', null, { params: data }).then(function(response) {
                console.log(response.data);
            }).catch(function(error) {
                console.log(error);
            });
        },
        doLogin: function() {
            var self = this;
            // check account
            this.user.room = room; //localStorage.getItem("room");
            if (this.user.username == null || this.user.username == '') {
                this.warning.username.status = -1;
                this.warning.username.text = "Tên/Biệt danh không được để trống";
            } else if (!this.valid.username.test(this.user.username)) {
                this.warning.username.status = -1;
                this.warning.username.text = "Tên/Biệt danh là chữ hoặc số từ 3-15 ký tự";
            } else {
                axios.post('/login', null, { params: this.user }).then(function(response) {
                    //đăng nhập thành công
                    location.reload();
                }).catch(function(error) {
                    console.log(error);
                });
            }

        }
    }
});