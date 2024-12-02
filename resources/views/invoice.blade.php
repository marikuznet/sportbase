<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<style>
    body {
        font-family: DejaVu Sans;
    }

    .sb-invoice__caption {
        display: flex;
        justify-content: center;
    }

    .navbar-brand__logo {
        background-color: #2d297d;
        color: #fff;
        font-weight: 700;
        font-size: 22px;
        width: fit-content;
        padding: 1rem;
        text-align: center;
    }

    .navbar-brand__logo span {
        color: #e45868;
    }

    .info_payment > p {
        margin: 0;
        margin-bottom: 5px;
    }

    .info-payment__date-estimate {
        margin-top: 20px;
        margin-bottom: 20px;
        font-weight: bold;
    }
</style>
<body>
<div class="container">
    <div style="width: 100%; max-width: 960px; margin: auto" class="mt-4">
        <div class="sb-invoice__caption">
            <div class="navbar-brand__logo">СПОРТБАЗА<span>.РФ</span></div>
        </div>
        <table width="100%" class="invoice-table">
            <tr style="border-bottom: 1px solid #000000; color: black">
                <td class="pl-3 pt-3 info_payment" style="display: none">
                    <p>Юр лицо / Физ. лицо</p>
                    <p>ИНН: , ОГРН:</p>
                    <p>Юр.адрес:</p>
                    <p>Факт. адрес:</p>
                    <p><b>тел.: </b></p>
                    <p>site.com e-mail:</p>
                </td>
                <td style="text-align: right; display: none" class="pr-3 pt-3 info_payment">
                    <p>Юр лицо / Физ. лицо</p>
                    <p>ИНН: , ОГРН:</p>
                    <p>Юр.адрес:</p>
                    <p>Факт. адрес:</p>
                    <p><b>тел.: </b></p>
                    <p>site.com e-mail:</p>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="display:none;" class="info-payment__date-estimate">
                        Дата сметы
                    </div>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="invoice-body" colspan="2">
                    <table width="100%" cellpadding="0" cellspacing="0" border="1">
                        <thead>
                        <tr>
                            <th style="text-align: left; padding: 5px 10px; display:none;">№ п/п</th>
                            <th style="text-align: left; padding: 5px 10px;">Наименование расходов</th>
                            <th style="text-align: center; padding: 5px 10px;">Сумма (в целых руб.)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                            <tr> <!--v-for !-->
                                <td style="text-align: left; padding: 5px 10px; display:none;">id</td>
                                <td style="text-align: left; padding: 5px 10px;">{{$service['title']}}</td>
                                <!--$service['title']!-->
                                <td style="text-align: center; padding: 5px 10px;">{{$service['price']}}</td>
                                <!--$service['price']!-->
                            </tr>
                            <tr>
                                <td style=" display:none;"></td>
                                <td style="text-align: left; padding: 5px 10px;" colspan="2">
                                    <i>Обоснование: </i>{{$service['justification']}}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style=" display:none;" colspan="2"></td>
                            <td></td>
                            <td style="text-align: left; padding: 5px 10px;">ИТОГО: {{$total}}</td> <!--$total!-->
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
