<template>
    <div class="overflow-auto">
        <table class="table">
            <thead>
            <th class="text-center text-nowrap">ID номер<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Дата операции<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Пользователь<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Тип операции<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Счет<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Сумма<i class="fa fa-caret-down sort mx-2"></i></th>
            <th class="text-center text-nowrap">Баланс<i class="fa fa-caret-down sort mx-2"></i></th>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">1234</td>
                <td>3 января 2021/14:48</td>
                <td>ИП Петров Петр Петрович (ID:2345)</td>
                <td>зачисление (реклама)</td>
                <td class="text-center">123456</td>
                <td class="text-center">+ 4,456.00 руб</td>
                <td class="text-center">7,897.00 руб</td>
            </tr>
            <tr>
                <td class="text-center">1234</td>
                <td>1 января 2021/14:48</td>
                <td>ООО "Спортмастер" (ID:2234)</td>
                <td>выплата по сделке</td>
                <td class="text-center">7577774</td>
                <td class="text-center">- 5,678.00 руб</td>
                <td class="text-center">5,841.00 руб</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default {
    name: "OperationsListSection",
}
</script>

<style scoped>

</style>
