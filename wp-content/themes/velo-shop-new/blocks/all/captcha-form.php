<?php
    $code = rand(1000, 9999);
    $formater = new NumberFormatter("ru", NumberFormatter::SPELLOUT);
?>

<div class="captcha relative">
    <p class="text_center"><?= $formater->format($code) ?></p>
    <input type="hidden" name="hash" value="<?= md5($code) ?>">

    <input name="code" class="input-form w-full mb-1" type="text"
           placeholder="Введите число из строки">
</div>