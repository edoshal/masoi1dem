<?php
$title = "Trang chủ";
include_once 'header.php';
?>
<div class="" id="navbar-container">
    <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <img src="/img/logo.png" height="32" />
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start"></div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-success" href="/Choi/index/<?= generateRandomString(32) ?>">
                            <strong>Tạo phòng ngay</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<section class="section">
    <div class="container">
        <div class="has-text-centered" id="services-text-container">
            <h1 class="title is-1">Ma sói</h1>
            <h4 class="subtitle">
                Chơi ma sói mọi lúc mọi nơi
            </h4>
            <div class="buttons is-centered">
                <div class="buttons">
                    <a class="button is-success" href="/Choi/index/<?= generateRandomString(32) ?>">
                        <strong>Tạo phòng ngay</strong>
                    </a>
                </div>
            </div>
        </div>
        <br />
        <div class="columns">
            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <div class="has-text-centered">
                            <img src="img/qrcode.png" />
                        </div>
                        <h3 class="title is-3 has-text-centered" id="card-product-description">Tham gia dễ dàng</h3>
                        <p class="has-text-centered">
                            Tạo phòng với 1 click.<br />
                            Tham gia dễ dàng chỉ cần quét QR code.<br />
                            Không cần cài đặt app.
                        </p>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <div class="has-text-centered">
                            <img src="img/admin.png" />
                        </div>
                        <h3 class="title is-3 has-text-centered" id="card-product-description">Vận hành đơn giản</h3>
                        <p class="has-text-centered">
                            Có thể tiến hành Thu bài/Chia bài.<br />
                            Lật/Úp bài tránh lộ bài cho người bên cạnh.<br />
                            Tùy biến cuộc chơi theo cách của nhóm.
                        </p>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <div class="has-text-centered">
                            <img src="img/member.png" />
                        </div>
                        <h3 class="title is-3 has-text-centered" id="card-product-description">Sử dụng tiện lợi</h3>
                        <p class="has-text-centered">
                            Người chơi nhận bài và mô tả chức năng của mình.<br />
                            Có thể theo dõi bảng xếp hạng điểm.<br />
                            Theo dõi ai đã bị thu bài và tình trạng sống/chết.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once 'footer.php'; ?>