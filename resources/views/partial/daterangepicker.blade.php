<div class="form-group">
    <label>{{$label}}</label>
    <div class="input-group">
        <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
        </div>
        <input type="text" class="form-control float-right {{ $class }}"
               name="{{ $name }}">
    </div>
</div>
@push('js')
    <script>
        $('.{{$class}}').daterangepicker({
            startDate: moment("{{$startDate}}"),
            endDate: moment("{{$endDate}}"),
            locale: {
                format: 'YYYY-MM-DD',
                "separator": " - ",
                "applyLabel": "Сохранить",
                "cancelLabel": "Назад",
                "daysOfWeek": [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                "firstDay": 1,
                "customRangeLabel": "Свой период"
            },
            ranges: {
                "{{__('common.today')}}": [moment(), moment()],
                "{{__('common.yesterday')}}": [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                "{{__('common.last 7 days')}}": [moment().subtract(6, 'days'), moment()],
                "{{__('common.last 30 days')}}": [moment().subtract(29, 'days'), moment()],
                "{{__('common.this month')}}": [moment().startOf('month'), moment().endOf('month')],
                "{{__('common.last month')}}": [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
        })
    </script>
@endpush
