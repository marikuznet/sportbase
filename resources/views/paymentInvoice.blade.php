<?php
function numberToWords($number)
{
    $ones = ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'];
    $teens = ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'];
    $tens = ['', '', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'];
    $hundreds = ['','сто','двести','триста','четыреста','пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];
    $thousands = ['', 'тысяч', 'миллион', 'миллиард'];

    $number = number_format($number, 2, '.', '');
    list($rubles, $cents) = explode('.', $number);

    $rubles = str_split(strval(intval($rubles)), 3); // Преобразуем в строку и избавляемся от нулей в начале числа
    $result = [];

    foreach ($rubles as $index => $part) {
        $partResult = [];

        if ($part > 99) {
            $partResult[] = $hundreds[intval($part[0])];
            $part = substr($part, 1);
        }

        if ($part > 19) {
            $partResult[] = $tens[intval($part[0])];
            $part = substr($part, 1);
        }

        if ($part > 9 && $part < 20) {
            $partResult[] = $teens[$part - 10];
        } elseif ($part > 0 && $part < 10) {
            $partResult[] = $ones[intval($part)];
        }

        if ($index > 0 && $part > 0) {
            $partResult[] = $thousands[$index];
        }

        $result[] = implode(' ', $partResult);
    }

    return implode(' ', $result) . ' рублей ' . ltrim($cents, '0');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Счет на оплату услуг</title>
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

    table.custom {
        border-collapse: collapse;
        line-height: 1.1;
    }

    table.custom th {
        padding: 10px;
        border: 1px solid black;
    }

    table.custom td {
        font-size: 0.8em;
        padding: 5px 7px;
        border: 1px solid black;
    }

    .m-0 {
        margin: 0;
    }
</style>
<body>
<div class="container">
    <div style="width: 100%; max-width: 960px; margin: auto">
        <h2><b>Счет на оплату № {{$estimate['id']}} от {{$estimate['cut_date_est']}}</b></h2>
        <p><b>Поставщик: </b> ИП Гуреев Евгений Олегович</p>
        <table width="100%" class="invoice-table custom">
            <tr>
                <td rowspan="2" colspan="4">
                    <p class="m-0">ПАО СБЕРБАНК</p>
                    <p class="m-0">г. Москва</p>
                    <p class="m-0">Банк получателя</p>
                </td>
                <td class="m-0">БИК</td>
                <td style="border-bottom: none">
                    <p>044525225</p>
                </td>
            </tr>
            <tr>
                <td class="m-0">Сч. №</td>
                <td style="border-top: none">
                    <p>30101810400000000225</p>
                </td>
            </tr>
            <tr>
                <td>ИНН</td>
                <td>772451861666</td>
                <td>КПП</td>
                <td>772451861666</td>
                <td rowspan="2">Сч. №</td>
                <td rowspan="2">40802810540000015371</td>
            </tr>
            <tr>
                <td colspan="4">
                    <p>ИП Гуреев Евгений Олегович</p>
                    <p>Получатель</p>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="font-size: 12px"><b>Покупатель:</b></td>
                <td>
                    <p style="font-size: 12px">{{$customer['legal_name']}} «{{$customer['title']}}»,
                        ИНН {{$customer['tin']}}, КПП {{$customer['numKpp']}}
                        @if(isset($customer['address']))
                            , {{$customer['postIndex']}}, {{$customer['region']}}, {{$customer['city']}}
                            , {{$customer['address']}}
                        @endif
                    </p>
                </td>
            </tr>
        </table>
        <table style="width: 100%;" class="custom">
            <tr>
                <td>
                    #
                </td>
                <td style="width:50%">Наименование товаров, работ, услуг</td>
                <td>Кол-во</td>
                <td>Ед. изм.</td>
                <td>Цена</td>
                <td style="width: 15%;">Всего</td>
            </tr>
            @foreach($services as $index => $service)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>
                        {{$service['title']}}.
                    </td>
                    <td>
                        @if(isset($service['days']) && $service['days'] !== null)
                            {{$service['days']}}
                        @elseif(isset($service['pre_price']) && $service['pre_price'] !== null)
                            {{$service['price'] / $service['pre_price']}}
                        @endif
                    </td>
                    <td>
                        @if(isset($service['unit']))
                            {{$service['unit']}}
                        @endif
                    </td>
                    <td>
                        @if(isset($service['pre_price']) && $service['pre_price'] !== null)
                            {{ $service['pre_price'] }}
                        @endif
                    </td>
                    <td>{{number_format($service['price'], 2, ',', ' ')}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"></td>
                <td colspan="2"><b>Итого к оплате:</b></td>
                <td colspan="1">{{number_format($total, 2, ',', ' ')}}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2"><b>Без налога НДС:</b></td>
                <td colspan="1"></td>
            </tr>
        </table>
        <p style="margin-bottom: 0 !important;">Всего наименований {{count($services)}} на сумму {{ number_format($total, 2, ',', ' ') }} рублей 00 копеек</p>
        <p style="margin-top: 0; display: none"><b><?php echo numberToWords($total) ?></b></p>
        <br>
        <br>
        <br>
        <br>
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%"><p>Генеральный Директор</p></td>
                <td>___________________________________ (Гуреев Е.О.)</td>
            </tr>
        </table>
        <br>
        <br>
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%"><p>Бухгалтер</p></td>
                <td>___________________________________</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
