<?php

$posts=[
    [
        "id" => 1,
        "user"=> "tnk@engineer",
        "content"=> "人を笑わせることを志してきました。たくさんの人が自分の事で笑えなくなり、ただただ困惑し、悔しく悲しいです。。。。世間に真実が伝わり、一日も早く、お笑いがしたいです。",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "introduction" =>"24歳|SE|javasilver勉強中。2024年の目標は個人開発アプリで1000ダウンロード | 9個アプリ配信中|メインでJavaとFlutterを使用| 趣味はゴルフ、読書、サウナ|個人開発関連やIT技術についてつぶやく"
    ],
    [
        "id" => 2,
        "user"=> "有吉弘行",
        "content"=> "配信遅れて申し訳ございません.今日は山根です。重ねて申し訳ございません",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "introduction" =>"SE / JavaSilver勉強中 / 応用情報技術者（2025年春予定）/ 読書 / Java / たまに社内ニート / 一緒に勉強頑張ってくれる方募集✎"
   
    ],
    [
        "id" => 3,
        "user"=> "ゆっちゃん@java勉強中",
        "content"=> "今日は素晴らしい一日でした！最近のプロジェクトが無事に完了し、チーム全体でお祝いです。次のチャレンジに向けて、これからも頑張ります。",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "introduction" =>"【本気のコンサル目指すなら中堅】 クソJTC→死んでいないだけの日々→未経験戦コン転職→全ての挫折を経験→戦略系コンサル 。転職支援サービス提供、転職のコツ／ジュニア向けパフォームや生き残りヒントをポスト。フォローすると転職成功率、生存率、仕事力が飛躍的に向上。激ドメ英語学習術は
        @mlc_eng"
    ],
    [
        "id" => 4,
        "user"=> "ryooootasaaaaam",
        "content"=> "基本情報技術者試験、見事合格〜！年末年始？そんなの関係ねぇ！！年末年始返上が実を結びました",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "introduction" =>"シンクタンク所属の戦略系コンサルタント AmazonアソシエイトWorkCircleアンバサダー 質問1→ https://querie.me/user/consultnt_a 質問2→http://mond.how/ja/consultnt_a 長めの文章→http://note.com/consultnt_a"
    ],
    [
        "id" => 5,
        "user"=> "あさか🐰",
        "content"=> "人を笑わせることを志してきました。たくさんの人が自分の事で笑えなくなり、ただただ困惑し、悔しく悲しいです。。。。世間に真実が伝わり、一日も早く、お笑いがしたいです。",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "introduction" =>"メガベンPdM→総コン(SM)...どこにでも生息するポンコツの生態を研究中...「お前が1番ポンコツやー」と鋭くつっこまれながらも脱ポンコツ化のヒントをつぶやき社会貢献...ヨダをフォローすると社会貢献できます？"
  
    ],
]

?>
<div class="row d-flex w-100">
    <div class="col-2">
    </div>
    <div class="col-8  d-flex flex-column justify-content-center border ">
        <!-- トレンドorフォロワー-->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                 <!-- <a class="navbar-brand" href="#">Navbar</a> -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse fs-5" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-around w-100">
                        <li class="nav-item" id="follow-tab">
                            <a class="nav-link active text-dark" aria-current="page" href="#" data-target="#homeContent">follow</a>
                        </li>
                        <li class="nav-item" id="follower-tab">
                            <a class="nav-link text-dark" href="#" data-target="#linkContent">follower</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- フォローリスト -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="follow-list">
                <!-- Dynamic content for Trend should be loaded here -->
                <ul id ="list-group" class="list-group list-unstyled">
                    <?php foreach ($posts as $post): ?>
                        <li class=" post border-top pt-2 pb-2">
                            <div class="d-flex">
                                <span class="material-symbols-outlined ms-2 fs-1">account_circle</span>
                                <h5 class="ms-3 pt-2"><?=htmlspecialchars($post['user']) ?></h5>
                                <button type="submit" class="btn rounded-pill border ms-auto">フォロー中</button>
                            </div>
                            <div class="mx-5">
                                <p> <?= htmlspecialchars($post['introduction']) ?> </p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- フォロワーリスト -->
            <div class="tab-pane fade show active" id="follower-list" style="display: none;">
                <!-- Dynamic content for Followers should be loaded here -->
                follower
            </div>
        </div>
    </div>
    <div class="col-2">
    </div>
</div>

<script src="/js/follow.js"></script>