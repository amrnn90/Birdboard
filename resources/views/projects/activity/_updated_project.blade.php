@if($activity->diff && count($activity->diff['after']) == 1)

{{$activity->user->name}} updated the project {{array_keys($activity->diff['after'])[0]}}
@else
{{$activity->user->name}} updated the project
@endif