<?php

include_once 'header.php'; ?>
<script>
    var room = "<?= $room ?>";
</script>

<div class="container is-max-desktop" id="app">

    <div class="content-chapter">
        <center><img :src="newQRCode" alt="QRCode" /></center>
        <br />
        <br />
        <?php
        $session = \Config\Services::session();
        if ($session->id > 0 && $session->room == $room) {
            echo '<div class="member">';
            echo "Xin chào, $session->username";
            echo '</div>';
        ?>
            <b> Quản trò:</b>
            <div v-for="item in items" :key="item.username" v-if="item.isAdmin == 1" class="user has-background-primary-light" v-bind:class="{'is-dead': item.status == 0}">
                <div class="name">
                    <i class="fas fa-user-secret"></i> {{ item.username }}<br />
                    <?php if ($session->isadmin) { ?>
                        <i class="fas fa-award"></i> {{item.name}}<br />
                    <?php
                    } ?>
                    </span>
                </div>
            </div>

            <b> Bài thừa trên bàn:</b>
            <div v-for="item in items" :key="item.username" v-if="item.isAdmin == 0&& item.isBot == 1" class="user has-background-warning-light" v-bind:class="{'is-dead': item.status == 0}">
                <div class="name">
                    <div v-if="myrole.role_id==5 && myrole.donejob==0">
                        <input type="checkbox" v-bind:id="item.id" v-bind:value="item.id" v-model="checkedMember">
                        Chọn người này<br />
                    </div>
                    <i class="fas fa-user-secret"></i> {{ item.username }}<br />
                    <?php if ($session->isadmin) { ?>
                        <i class="fas fa-award"></i> {{item.name}}<br />
                    <?php
                    } ?>
                    </span>
                </div>
            </div>

            <b> Bài thành viên</b>
            <div v-for="item in items" :key="item.username" v-if="item.isAdmin == 0 && item.isBot == 0" class="user" v-bind:class="{'is-dead': item.status == 0}">
                <div class="name">
                    <div v-if="(myrole.role_id==22 || myrole.role_id==17 || myrole.role_id==3 || myrole.role_id==23 || myrole.role_id==5) && myrole.donejob==0">
                        <input type="checkbox" v-bind:id="item.id" v-bind:value="item.id" v-model="checkedMember">
                        Chọn người này<br />
                    </div>
                    <i class="fas fa-user-secret"></i> {{ item.username }}<br />
                    <i class="fas fa-coins"></i> Điểm: {{item.point}}<br />
                    <?php if ($session->isadmin) { ?>
                        <i class="fas fa-award"></i> {{item.name}}<br />
                        Thực tế: <b>{{item.realrole}}</b><br />
                        <div v-if="item.role_id == 3">
                            <i class="fas fa-angry"></i> {{item.target}}
                        </div>
                    <?php
                    } ?>
                    </span>
                </div>
                <?php if ($session->isadmin) { ?>
                    <div class="control">
                        <a class="tag is-danger" v-on:click="kickMember(item.id)">Đuổi</a>
                        <a class="tag is-success" v-on:click="addGold(item.id)">Thêm 10 Điểm</a>
                        <a class="tag is-danger" v-on:click="subGold(item.id)">Trừ 10 Điểm</a>
                        <a class="tag is-warning" v-if="item.status == 1" v-on:click=" kill(item.id)">Giết</a>
                        <a class="tag is-warning" v-if="item.status == 0" v-on:click="revival(item.id)">Hồi sinh</a>
                    <?php } ?>
                    </div>
            </div>



            <div v-if="myrole.role_id == 22 && myrole.donejob == 0">
                <center><button class="button is-link is-rounded" v-on:click="trombai">Trộm bài này</button></center>
            </div>
            <div v-if="myrole.role_id == 17 && myrole.donejob == 0">
                <center><button class="button is-link is-rounded" v-on:click="nhanban">Nhân bản nó</button></center>
            </div>
            <div v-if="myrole.role_id == 3 && myrole.donejob == 0">
                <center><button class=" button is-link is-rounded" v-on:click="keotheo">Kéo theo nó</button></center>
            </div>
            <div v-if="myrole.role_id == 23 && myrole.donejob == 0">
                <center><button class="button is-link is-rounded" v-on:click="doi2bai">Đổi 2 bài này</button></center>
            </div>
            <div v-if="myrole.role_id == 5 && myrole.donejob == 0">
                <center><button class="button is-link is-rounded" v-on:click="tientri">Tiên tri nó</button></center>
            </div>
            <br />
            <div class="modal " v-bind:class="{'is-active': viewmodal}">
                <div class="modal-background"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Thông báo</p>
                    </header>
                    <section class="modal-card-body">
                        {{contentmodal}}
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button is-success" v-on:click="viewmodal = !viewmodal">Tớ hiểu rồi</button>
                    </footer>
                </div>
            </div>
            <div v-if="myrole.showhis == 1">
                Quá trình Game:
                <div v-for="item in history" class="log" :key="item.log">
                    {{item.dttm}}: <b>{{item.log}}<b/>
                </div>
            </div>
            <center><button v-if="myrole.donejob == 0" class="button is-link is-rounded" v-on:click="view = !view">Lật/Úp Bài</button></center>
            <div v-if="view && myrole.donejob == 0">
                <hr />
                <center> <img v-bind:src="'/img/' + myrole.img" width="250px"></center>
                Vai trò của bạn là: <b>{{myrole.name}}</b><br />
                Phe: <b>{{myrole.team}}</b><Br />
                Chức năng: <i>{{myrole.note}}</i>
            </div>

            <br />
            <br />
            <br />
            <br />
            <br />
            <?php
            if ($session->isadmin) {
            ?>
                <hr />
                <button v-on:click="hideall" class="button is-warning">Giấu hết bài</button>
                <button v-on:click="showhis" class="button is-danger">Xem lịch sử</button>
                <button v-on:click="clearRole" class="button is-warning">Thu bài</button>
                <button v-on:click="generateGame" class="button is-link">Chia bài</button><br />
                <button v-on:click="addPerVillage" class="button is-success">+ 10 Điểm/Dân</button>
                <button v-on:click="addPerWoft" class="button is-danger">+ 10 Điểm/Sói</button>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Số Werewolf (Ma sói)</label>
                            <div class="control">
                                <input class="input" type="number" placeholder="Text input" v-model="setting.woft">
                            </div>
                        </div>
                    </div>
                </div>
                <?php foreach ($roles as $role) : ?>
                    <input type="checkbox" id="<?= $role->id ?>" value="<?= $role->id ?>" v-model="setting.checkedRole">
                    <label for="<?= $role->id ?>"><b><?= $role->id ?> - <?= $role->name ?></b></label>
                    <br />
                    <i><?= $role->note ?></i>
                    <br />
                <?php endforeach; ?>

                <br />
                <button v-on:click="hideall" class="button is-warning">Giấu hết bài</button>
                <button v-on:click="showhis" class="button is-danger">Xem lịch sử</button>
                <button v-on:click="clearRole" class="button is-warning">Thu bài</button>
                <button v-on:click="generateGame" class="button is-link">Chia bài</button><br />
                <button v-on:click="addPerVillage" class="button is-success">+ 10 Điểm/Dân</button>
                <button v-on:click="addPerWoft" class="button is-danger">+ 10 Điểm/Sói</button>

            <?php
            }
        } else {
            ?>
            <form v-on:submit.prevent="doLogin" id="form">
                <div class=" field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" v-bind:class="{'is-danger': warning.username.status == -1, 'is-success': warning.username.status == 1}" type="text" placeholder="Tên/Biệt danh" v-model="user.username">
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fas fa-check" v-if="warning.username.status == 1"></i>
                            <i class=" fas fa-exclamation-triangle" v-if="warning.username.status == -1"></i>
                        </span>
                    </p>
                    <p class=" help is-danger" v-if="warning.username.status == -1">{{warning.username.text}}
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <button class="button is-success" type="submit">
                            Chơi ngay
                        </button>
                    </p>
                </div>
            </form>
        <?php } ?>
    </div>
</div>
<?php include_once 'footer.php'; ?>