<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?= $title; ?></title>
    <style>
        /* Estilos inline para melhor compatibilidade */
        body {
            font-family: Helvetica, sans-serif;
        }

        .content {
            font-size: 16px;
            margin-bottom: 25px;
            padding-bottom: 5px;
            border-bottom: 1px solid #EEEEEE;
        }

        .content p {
            margin: 25px 0;
            text-align: justify;
        }

        .footer {
            font-size: 14px;
            color: #888888;
            font-style: italic;
        }

        .footer p {
            margin: 0 0 2px 0;
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #FFFFFF;">
    <div style="max-width: 700px; margin: 0 auto;">
        <div style="padding: 10px;">
            <div class="content">
                <?= $v->section("content"); ?>
                <p>Atenciosamente, <br>Equipe <?= CONF_SITE_NAME; ?>.</p>
            </div>
            <div class="footer">
                <p><?= CONF_SITE_NAME; ?> - <?= CONF_SITE_TITLE; ?></p>
            </div>
        </div>
    </div>
</body>

</html>