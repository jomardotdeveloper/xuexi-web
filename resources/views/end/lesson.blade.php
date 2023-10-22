@extends('app')
@section('title', 'Dashboard')
@section('content')
@php
    $story_boards_6 = [
        "小白兔去玩儿。兔妈妈告诉他，碰见人要有礼貌。小白兔要过桥，山羊他树叶要过桥。山羊大叔让小白兔先过。小白兔高兴地说： “没关系，没关系！”
小猴子吃果子不小心，把果皮掉到小白兔头上，小猴子连忙说：”对不起！对不起！”
小白兔笑着说：“谢谢你，谢谢你！”
小白兔走路不小心，撞到了小雅，很不好意思，连忙说：“不客气，不客气！”
小朋友，小白兔都说对了吗？
错在哪里？应该怎么说？",
        "暑假，下滑到中国血刺华语，住在学校的宿舍里。笑话学习很努力，白天学，晚上约学，有时候连做梦也说华语。
一天晚上，小偷刘瑾他的房间偷东西，刚进门就听见有人说：“你来啦，欢迎，欢迎!” 小偷吓了一跳，急忙在黑暗处蹲下来。
小偷刚蹲下来，又听见有人说：“别客气，请坐请坐!”
小偷想：”糟啦！我被他发现了，快逃!”
小偷刚跑出门，又听见有人说：“你慢走！再见！“
小偷吓坏了，期满逃走。",
        "老师：小朋友，时间太宝贵了！总表 “滴答” 以下就是一秒，六十下就十一分钟。一分钟可以做多少呢？

小云：一分钟可以写十几个字。

小文：一分钟可以朗读二百个字左右的课文。

小明：运动员一分钟可以跑三四百米。

莉莉：喷气客机一分钟可以飞行十多公里。

老师：说的很好！世界上什么东西都可以用钱买，只有时间，用多少钱也买不到。亲爱的少朋友，你用着宝贵的一分钟做了什么呢?".
     "小文：妈妈，你学什么呢？


妈妈：我正在算账，别捣乱！

小文：我来帮你算。

妈妈：你行吗？

小文：真么不行？加，减，乘，除，我们都学过了。

妈妈：好吧！我说，你来算，他命120块钱，肉150块钱， 青菜85块钱，水果70块钱，冰淇淋100块钱，一共多少钱？

小文：一共525块钱。

妈妈：哦，我其错了, 冰淇淋是90块钱。

小文：525前去10，等于515.一共515块钱。

妈妈！啊，小文会算账了，妈妈真高兴。"
];
$story_boards_5 = [
    "我上一年级的时候。

心里哟点二害怕。

坐在教室里，
心里一直想家。

我上二年级的时候。

常跟同学吵架,

回加不想做功课，

只想着学校放假。

现在，沃上五年级了，

上课不在想家，

不像小时候那么淘气，

也不再跟同学吵架。
",
"你话语说得不错呀！

哪里，不太好。

学了多长时间了？

学了两年了。

平时常说话语吗？

不常说。

你姐的话语难不难？

我姐的有点儿难。

你去过台湾吗？

去年暑假跟妈妈去过一次。

住了多长时间？

半个月。
你嫩听懂他们的话吗？

只嫩听懂一点二。他们他大部分说闽南话。",
"才阿姨，您好！请进！

啊！你又长高了！越来越漂亮了！

学学阿姨！阿姨！您请坐！

家里只有你一个人？被的人呢？

爸爸出国了，妈妈去公司办事，哥哥跟同学一起去看球才。只有我一根人在家。

你妈妈去了多久了？

刚走一会儿，阿姨有什么事吗？

我找你妈妈有重要的事。你妈妈回家来，请他立刻给我打电话。

记住了，妈妈一回来，我就告诉她
。
莉莉越来越懂事了。好孩子，再见！

阿姨，您慢走。",
"电话铃响，莉莉接电话。
喂，你找谁？

我姓陈，是莉莉的老师。晴吴太太接电话
。
陈老师，我是莉莉，妈妈不在家，爸爸也不在，家里只有我一个人。老师有什么事吗?

明天下午两点，学校开家长会，请你妈妈来参加。

妈妈工作很忙，这几天爸爸出国了，妈妈跟忙了，麦田早上出去，晚上很晚才回家，明天不知道能不能去，等他回来，我告诉他。

这次家长会很重要。如果不能来，请她一定给我打个电话。
好的。妈妈一回来，我就告诉他。


莉莉，现在绳子越来越多，课文也越来越难，你要多听，多说，多读，多写，学得比以前更好。

谢谢老师的关心，我一定努力学习。"
];
// $chosen = "";

if (Session::get('user')['grade_level'] == "Grade 5") {
    $chosen = $story_boards_5[intval($_GET['lesson_number']) - 1];
} else {
    $chosen = $story_boards_6[intval($_GET['lesson_number']) - 1];
}
@endphp



<div class="row">
    <div class="col-12">
        <h2>{{ $lesson_title }}</h2>
    </div>
    <div class="col-12">
        <a href="{{ route('end.quiz') }}?lesson_number={{ $lesson_number }}" class="btn btn-primary mb-2">
            @if (count($user_taken_assessments) > 0)
            Show score
            @else
            Answer
            @endif
        </a>
    </div>
    @foreach ($grade_lessons as $lesson)
    <div class="col-12">
        <div class="widget-stat card bg-success">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-diploma" onclick="speak(event)" data-message="{{ $lesson['chinese'] }}"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Chinese Character: {{ $lesson['chinese_character'] }}</p>
                        <p class="mb-1">English: {{ $lesson['english'] }}</p>
                        <p class="mb-1">Chinese: {{ $lesson['chinese'] }}</p>
                        <h3 class="text-white"></h3>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-12">
        <div class="widget-stat card bg-success">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-diploma" onclick="speak(event)" data-message="{{ $chosen }}"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Story: {{ $chosen }}</p>
                        <h3 class="text-white"></h3>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @php

        dd($added);
    @endphp --}}
</div>

@endsection
@push("scripts")
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>

<script>

    const pusher = new Pusher('524af8b01c9cc9c10de9', {
        cluster: 'ap1',
    });
    const channel = pusher.subscribe('end-branch-618');
    channel.bind('client-my-event', function(data) {
        console.log('Received message:', data.message);
        // Handle the received message
    });

    function speak(event) {
        var x = channel.trigger('client-my-event', {
            message: 'Hello from React Native!',
            // You can include any other data you want to send with the event
        });

        console.log(x);
    }
</script>
@endpush
