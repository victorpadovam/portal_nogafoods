@php($data=[])
<?php
foreach ($store->schedules as $schedule) {
    $data[$schedule->day][] = [
        'id' => $schedule->id,
        'start_time' => $schedule->opening_time,
        'end_time' => $schedule->closing_time,
    ];
}

$daysOfWeek = [
    1 => 'monday',
    2 => 'tuesday',
    3 => 'wednesday',
    4 => 'thursday',
    5 => 'friday',
    6 => 'saturday',
    0 => 'sunday',
];
?>

@foreach ($daysOfWeek as $dayId => $dayName)
<div class="schedule-item">
    <span class="btn">{{ translate('messages.' . $dayName) }} :</span>
    <div class="schedult-date-content">
        @if(isset($data[$dayId]) && count($data[$dayId]))
        @foreach ($data[$dayId] as $day)
        <div class="d-inline-flex align-items-center">
            <span class="start--time">
                <span class="clock--icon">
                    <i class="tio-time"></i>
                </span>
                <span class="info">
                    <span>{{ translate('messages.opening_time') }}</span>
                    {{ date(config('timeformat'), strtotime($day['start_time'])) }}
                </span>
            </span>
            <span class="end--time">
                <span class="clock--icon">
                    <i class="tio-time"></i>
                </span>
                <span class="info">
                    <span>{{ translate('messages.closing_time') }}</span>
                    {{ date(config('timeformat'), strtotime($day['end_time'])) }}
                </span>
            </span>
            <span class="dismiss--date delete-schedule" data-url="{{ route('vendor.business-settings.remove-schedule', ['store_schedule' => $day['id']]) }}">
                <i class="tio-clear-circle-outlined"></i>
            </span>
        </div>
        @endforeach
        @else
        <span class="btn btn-sm btn-outline-danger m-1 disabled">{{ translate('messages.Off_day') }}</span>
        @endif
        <span class="btn add--primary" data-toggle="modal" data-target="#exampleModal" data-dayid="{{ $dayId }}" data-day="{{ translate('messages.' . $dayName) }}">
            <i class="tio-add"></i>
        </span>
    </div>
</div>
@endforeach