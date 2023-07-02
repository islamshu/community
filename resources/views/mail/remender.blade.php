<!DOCTYPE html>
<html>
    @php
        $community = App\Models\Community::find($community_id)
    @endphp
<head>
    <meta charset="utf-8">
    <title>تذكير لجلسة  {{  $community->title }}</title>
</head>
<body>
    <h1>مرحبا بك في مجتمع ArabiCreator</h1>
    <p>نود اعلامك بأنه سوف تعقد جلسة بعد 3 ساعات من الان في تمام الساعة  {{ $reminderDate->format('Y-m-d H:i') }}.</p>
    <a href="{{ $community->meeting_url }}" class="btn btn-primary">رابط الدخول للجلسة</a>
    
</body>
</html>
