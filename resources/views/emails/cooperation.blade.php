<html>
<body>
<div
    style="display: table; width: 100%; text-align: center; height: 50px; background: #68A4C4; color: #fff;
    font-family: 'Open Sans', Arial, sans-serif; font-size: 16px; font-weight: bold;">
    <div style="display: table-cell; vertical-align: middle;">Возможности сотрудничества</div>
</div>

<div>
    <div style="margin-top: 20px">
       <b>Имя: </b> {{$cooperation->name}}
    </div>
    <div style="margin-top: 20px">
        <b>Email: </b> {{$cooperation->email}}
    </div>
    <div style="margin-top: 20px">
        <b>Телефон: </b> {{$cooperation->phone}}
    </div>
    <div style="margin-top: 20px">
        <b>Должность: </b> {{$cooperation->position}}
    </div>
    <div style="margin-top: 20px;">
        <b>Нравится ли вам идея проекта?</b>
        <p>{{$cooperation->question1}}</p>
    </div>
    <div style="margin-top: 20px;">
        <b>Будет ли Проект Вам полезен?</b>
        <p>{{$cooperation->question2}}</p>
    </div>
    <div style="margin-top: 20px;">
        <b>Какие основные преимущества Вы видите в таком решении?</b>
        <p>{{$cooperation->question3}}</p>
    </div>
    <div style="margin-top: 20px;">
        <b>Какие по Вашему мнению главные недостатки решения?</b>
        <p>{{$cooperation->question3}}</p>
    </div>
</div>
</body>
</html>
