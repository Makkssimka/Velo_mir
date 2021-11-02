<style>
    .email-header__logo{
        text-transform: uppercase;
        font-size: 2rem;
        text-align: center;
    }
    .email-header__logo a{
        color: #212529;
        text-decoration: none;
        font-weight: normal;
    }
    .email-header__logo span{
        font-weight: bold;
    }
    .email-head__head {
        font-size: 1.6rem;
        color: #212529;
        text-align: center;
    }
    .email-head p{
        font-size: 1.2rem;
        color: #6c757d;
        margin: 0;
        padding: 3px 0;
    }
    .email-head a, .email-head span{
        color: #609abd
    }
    .email-body{
        margin-top: 30px;
    }
    .email-body table{
        width: 100%;
    }
    .email-body th{
        text-transform: uppercase;
    }
    .email-body tr{
        border: 1px solid #000;
    }
    .email-body__table-row p{
        color: #609abd;
        font-size: 0.8rem;
        margin: 5px 0 0;
    }
    .email-footer{
        text-align: center;
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 30px;
    }
</style>
<body body style="width:100%;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
<div class="wrapper-email" style="max-width: 600px; margin: 0 auto; padding: 15px;">
    <div class="email-header">
        <div class="email-header__logo">
            <a href="https://velomir34.ru">
                <span>Веломир</span>34
            </a>
        </div>
    </div>
    <div class="email-head">
        <div class="email-head__head">Новая заявка на обратный звонок</div>
        <section>
            <p>У вас новая заявка на сайте!</p>
            <p>Имя: <span><?= $name ?></span></p>
            <p>Телефон: <a href="tel:<?= $telephone ?>"><?= $telephone ?></a></p>
        </section>
    </div>
    <div class="email-footer">
        <p>Веломир 34 - продажа и обслуживание велосипедов в Волгограде</p>
    </div>
</div>
</body>