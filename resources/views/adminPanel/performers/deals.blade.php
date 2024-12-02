@extends('adminPanel.layouts.app')
@section('content')
    <div class="">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item fs-lg-5"><a href="{{route('admin.home')}}">Пользователи (Заказчики)</a></li>
                <li class="breadcrumb-item fs-lg-5 active"> Спортивно-оздоровительный комплекс "Столбцы"
                    (ID:1234)
                </li>
                <li class="breadcrumb-item fs-lg-5 active" aria-current="page">Сделки (активные)</li>
            </ol>
        </nav>
    </div>
    <div class="main">
        <div class="settings-performers">
            <div class="container row top d-none d-lg-flex settings-performers__button">
                <a href="{{route('admin.performers.settings')}}" class="col-2 p-0">
                    <button
                        class="w-100 p-2" name="profile"> Профиль и настройки
                    </button>
                </a>
                <a href="{{route('admin.performers.applications')}}" class="col-2 p-0">
                    <button
                        class="w-100 p-2" name="applications">Заявки и отклики
                    </button>
                </a>
                <a href="{{route('admin.performers.deals')}}" class="col-2 p-0">
                    <button
                        class="w-100 p-2 settings-performers__button_active" name="deals">Сделки
                    </button>
                </a>
                <a href="{{route('admin.performers.price')}}" class="col-2 p-0">
                    <button
                        class="w-100 p-2" name="price">Сметы и счета
                    </button>
                </a>
                <a href="{{route('admin.performers.reviews')}}" class="col-2 p-0">
                    <button
                        class="w-100 p-2" name="reviews">Отзывы
                    </button>
                </a>
                <a href="{{route('admin.performers.correspondence')}}" class="col-2 p-0">
                    <button
                        class="w-100 p-2" name="reviews">Переписка
                    </button>
                </a>
            </div>
            <div class="p-0 position-relative settings-performers__content">
                <div class="container row pt-3">
                    <div class="col-2">
                        <h4 class="title fw-bold pb-2 addInform">Заявки и отклики</h4>
                    </div>
                    <div class="col-2">АКТИВНЫЕ (2)</div>
                    <div class="col-2"><a href="#">АРХИВНЫЕ (123)</a></div>
                    <div class="col-lg-1"></div>
                    <div class="col-3">
                        <form action="" method="get">
                            <input name="s" placeholder="Поиск в каталоге" type="search">
                            <button class="search_button" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <div class="col-2">
                        <a href="" class="btn btn-primary"><i class="fa fa-filter"></i> ФИЛЬТР <i
                                class="fa fa-caret-down fa-lg"></i></a>
                    </div>
                </div>
                <div class="container pt-3">
                    <div class="overflow-auto">
                        <table class="table table-responsive">
                            <thead>
                            <th>ID сделки <i class="fa fa-caret-down fa-2x sort"></i></th>
                            <th>Дата создания. <i class="fa fa-caret-down fa-2x sort"></i></th>
                            <th>Тип заявки <i class="fa fa-caret-down fa-2x sort"></i></th>
                            <th>Объект <i class="fa fa-caret-down fa-2x sort"></i></th>
                            <th>Даты пребывания <i class="fa fa-caret-down fa-2x sort"></i></th>
                            <th>Файлы<i class="fa fa-caret-down fa-2x sort"></i></th>
                            <th>Стоимость (общ.)<i class="fa fa-caret-down fa-2x sort"></i></th>
                            <th>Статус <i class="fa fa-caret-down fa-2x sort"></i></th>
                            <th>Действие <i class="fa fa-caret-down fa-2x sort"></i></th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1234</td>
                                <td>1 января 2021/14:48</td>
                                <td>Прямая заявка</td>
                                <td>
                                    <a href="#" style="color: black !important;">Спортивно-оздоровительный комплекс
                                        "Столбцы" (id: 1234)</a>
                                </td>
                                <td>1 - 10 января 2021 +-3 дня 7</td>
                                <td><a href="https://рфрит.рф/media/documents/%D0%A1%D0%BE%D1%81%D1%82%D0%B0%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5_%D1%84%D0%B8%D0%BD%D0%BC%D0%BE%D0%B4%D0%B5%D0%BB%D0%B8_%D0%9F%D0%9F_%D0%A0%D0%A4_1185.pdf">
                                        <i style="color:inherit !important;" class="fa fa-file-word-o fa-2x"></i>
                                        <i style="color: inherit !important;" class="fa fa-file-pdf-o fa-2x"></i>
                                    </a></td>
                                <td>12,345.67 руб</td>
                                <td><span style="color: #1e3041">ожидает решения от Исполнителя</span></td>
                                <td width="10%">
                                    <a href="#" style="color: black !important;"><i class="fa fa-info-circle fa-2x"></i></a>
                                    <a href="#"><i style="color: #00aced" class="fa fa-edit fa-2x"></i></a>
                                    <a href="#"><i style="color: red" class="fa fa-trash-o fa-2x"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
