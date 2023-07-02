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

    <h1>{{ $name }} مرحبا</h1>
    <p>نود ان نذكركم بأنه سيتم يتم عقد جلسة المجتمع مع الأعضاء بعد 3 ساعات في تمام</p>
    <p>  بتوقيت السعودية {{ $reminderDate->format('Y-m-d H:i') }} <br> </p>
    <p>كونوا على الموعد لنحقق قصص نجاح واهدافنا سوياً </p>
    <a href="{{ $community->meeting_url }}" style="background: #1B7FED; color:white" class="btn btn-primary">رابط الدخول للجلسة</a>
    
</body>
</html>
