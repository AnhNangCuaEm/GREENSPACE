<?php

require_once __DIR__ . '/functions/verify.php';

session_start();

$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
    header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
    exit();
}

// Nếu cần, lưu lại email trong session để dùng trong phiên hiện tại
$_SESSION['email'] = $email;

?>
<html>

<head>
    <?php include 'include/head.php' ?>
</head>

<body>
    <?php include 'include/nav.php' ?>
    <main>
        <div class="credit-container">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="300"
                zoomAndPan="magnify" viewBox="95 100 180 180" height="200" preserveAspectRatio="xMidYMid meet"
                version="1.0">
                <defs>
                    <g />
                    <clipPath id="ab2bbe5ed7">
                        <path
                            d="M 90 128.476562 L 177.804688 128.476562 L 177.804688 246.226562 L 90 246.226562 Z M 90 128.476562 "
                            clip-rule="nonzero" />
                    </clipPath>
                    <clipPath id="17ec05a312">
                        <path
                            d="M 123.488281 137.679688 C 121.652344 137.679688 119.839844 137.769531 118.042969 137.945312 C 115.765625 131.929688 116.9375 128.476562 116.9375 128.476562 C 112.007812 134.199219 115.300781 142.097656 116.800781 149.503906 C 118.300781 156.910156 121.535156 164.886719 120.273438 172.34375 C 118.960938 180.042969 110.441406 186.839844 105.636719 192.992188 C 97.648438 203.230469 98.804688 214.738281 98.804688 214.738281 C 91.179688 199.265625 93.726562 174.285156 103.113281 154.867188 C 96.277344 164.058594 89.265625 179.046875 90.421875 199.609375 C 91.496094 218.800781 108.496094 234.304688 117.34375 238.90625 C 109.957031 230.59375 107.777344 217.824219 112.34375 207.628906 C 115.527344 200.515625 121.386719 195.035156 126.664062 189.292969 C 131.929688 183.554688 136.9375 176.910156 137.667969 169.148438 C 142.746094 176.828125 146.957031 184.324219 148.574219 191.898438 C 150.4375 200.636719 149.679688 210.328125 144.503906 217.617188 C 142.066406 221.046875 138.792969 223.769531 135.695312 226.621094 C 132.953125 229.144531 130.28125 231.867188 128.527344 235.132812 C 127.550781 227.300781 132.242188 218.355469 136.847656 209.609375 C 143.378906 197.195312 137.964844 188.476562 137.964844 188.476562 C 142.105469 203.308594 123.488281 216.609375 123.488281 233.800781 C 123.488281 239.609375 125.210938 243.582031 126.988281 246.414062 C 155.410156 244.609375 177.914062 220.988281 177.914062 192.105469 C 177.902344 162.046875 153.535156 137.679688 123.488281 137.679688 Z M 123.488281 137.679688 "
                            clip-rule="nonzero" />
                    </clipPath>
                    <clipPath id="1c787a02c0">
                        <path d="M 69.054688 141 L 124 141 L 124 246.226562 L 69.054688 246.226562 Z M 69.054688 141 "
                            clip-rule="nonzero" />
                    </clipPath>
                    <clipPath id="3ddf1fd71a">
                        <path
                            d="M 88.84375 212.480469 C 82.058594 195.328125 82.660156 175.292969 91.257812 158.96875 C 94.691406 152.460938 99.199219 146.652344 104.167969 141.21875 C 83.644531 149.011719 69.0625 168.851562 69.0625 192.105469 C 69.0625 222.015625 93.183594 246.285156 123.035156 246.519531 C 107.816406 240.347656 95.203125 228.554688 88.84375 212.480469 Z M 88.84375 212.480469 "
                            clip-rule="nonzero" />
                    </clipPath>
                </defs>
                <g clip-path="url(#ab2bbe5ed7)">
                    <g clip-path="url(#17ec05a312)">
                        <path fill="#99e631"
                            d="M 177.804688 128.476562 L 177.804688 246.226562 L 89.265625 246.226562 L 89.265625 128.476562 Z M 177.804688 128.476562 "
                            fill-opacity="1" fill-rule="nonzero" />
                    </g>
                </g>
                <g clip-path="url(#1c787a02c0)">
                    <g clip-path="url(#3ddf1fd71a)">
                        <path fill="#99e631"
                            d="M 123.035156 141.21875 L 123.035156 246.226562 L 69.0625 246.226562 L 69.0625 141.21875 Z M 123.035156 141.21875 "
                            fill-opacity="1" fill-rule="nonzero" />
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(187.289011, 190.592858)">
                        <g>
                            <path
                                d="M 19.09375 -17.234375 C 18.75 -18.421875 18.117188 -19.351562 17.203125 -20.03125 C 16.285156 -20.707031 15.140625 -21.046875 13.765625 -21.046875 C 11.816406 -21.046875 10.238281 -20.328125 9.03125 -18.890625 C 7.820312 -17.453125 7.21875 -15.40625 7.21875 -12.75 C 7.21875 -10.09375 7.8125 -8.035156 9 -6.578125 C 10.1875 -5.128906 11.789062 -4.40625 13.8125 -4.40625 C 15.601562 -4.40625 17.007812 -4.867188 18.03125 -5.796875 C 19.050781 -6.734375 19.578125 -7.992188 19.609375 -9.578125 L 14.140625 -9.578125 L 14.140625 -13.625 L 24.796875 -13.625 L 24.796875 -10.421875 C 24.796875 -8.191406 24.320312 -6.269531 23.375 -4.65625 C 22.4375 -3.039062 21.140625 -1.800781 19.484375 -0.9375 C 17.828125 -0.0820312 15.925781 0.34375 13.78125 0.34375 C 11.394531 0.34375 9.296875 -0.179688 7.484375 -1.234375 C 5.679688 -2.296875 4.273438 -3.800781 3.265625 -5.75 C 2.265625 -7.695312 1.765625 -10.015625 1.765625 -12.703125 C 1.765625 -15.453125 2.289062 -17.804688 3.34375 -19.765625 C 4.394531 -21.722656 5.816406 -23.21875 7.609375 -24.25 C 9.410156 -25.28125 11.429688 -25.796875 13.671875 -25.796875 C 15.597656 -25.796875 17.335938 -25.429688 18.890625 -24.703125 C 20.453125 -23.972656 21.726562 -22.960938 22.71875 -21.671875 C 23.71875 -20.390625 24.332031 -18.910156 24.5625 -17.234375 Z M 19.09375 -17.234375 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(213.905792, 190.592858)">
                        <g>
                            <path
                                d="M 2.21875 0 L 2.21875 -25.453125 L 12.25 -25.453125 C 15.144531 -25.453125 17.390625 -24.695312 18.984375 -23.1875 C 20.578125 -21.6875 21.375 -19.671875 21.375 -17.140625 C 21.375 -15.398438 20.984375 -13.910156 20.203125 -12.671875 C 19.429688 -11.441406 18.320312 -10.515625 16.875 -9.890625 L 22.28125 0 L 16.34375 0 L 11.515625 -9.03125 L 7.59375 -9.03125 L 7.59375 0 Z M 7.59375 -13.34375 L 11.25 -13.34375 C 14.300781 -13.34375 15.828125 -14.609375 15.828125 -17.140625 C 15.828125 -19.753906 14.289062 -21.0625 11.21875 -21.0625 L 7.59375 -21.0625 Z M 7.59375 -13.34375 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(236.869299, 190.592858)">
                        <g>
                            <path
                                d="M 2.21875 0 L 2.21875 -25.453125 L 19.359375 -25.453125 L 19.359375 -21.015625 L 7.59375 -21.015625 L 7.59375 -14.953125 L 18.484375 -14.953125 L 18.484375 -10.515625 L 7.59375 -10.515625 L 7.59375 -4.4375 L 19.421875 -4.4375 L 19.421875 0 Z M 2.21875 0 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(258.30439, 190.592858)">
                        <g>
                            <path
                                d="M 2.21875 0 L 2.21875 -25.453125 L 19.359375 -25.453125 L 19.359375 -21.015625 L 7.59375 -21.015625 L 7.59375 -14.953125 L 18.484375 -14.953125 L 18.484375 -10.515625 L 7.59375 -10.515625 L 7.59375 -4.4375 L 19.421875 -4.4375 L 19.421875 0 Z M 2.21875 0 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(279.739482, 190.592858)">
                        <g>
                            <path
                                d="M 23.5 -25.453125 L 23.5 0 L 18.859375 0 L 7.78125 -16.015625 L 7.59375 -16.015625 L 7.59375 0 L 2.21875 0 L 2.21875 -25.453125 L 6.9375 -25.453125 L 17.921875 -9.453125 L 18.140625 -9.453125 L 18.140625 -25.453125 Z M 23.5 -25.453125 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(187.289011, 228.755639)">
                        <g>
                            <path
                                d="M 13.734375 -15.546875 C 13.648438 -16.398438 13.28125 -17.066406 12.625 -17.546875 C 11.976562 -18.023438 11.101562 -18.265625 10 -18.265625 C 8.875 -18.265625 8.007812 -18.03125 7.40625 -17.5625 C 6.800781 -17.101562 6.5 -16.523438 6.5 -15.828125 C 6.488281 -15.046875 6.820312 -14.453125 7.5 -14.046875 C 8.1875 -13.640625 9.003906 -13.328125 9.953125 -13.109375 L 11.90625 -12.640625 C 13.175781 -12.359375 14.300781 -11.945312 15.28125 -11.40625 C 16.269531 -10.863281 17.046875 -10.164062 17.609375 -9.3125 C 18.171875 -8.46875 18.453125 -7.441406 18.453125 -6.234375 C 18.441406 -4.234375 17.691406 -2.640625 16.203125 -1.453125 C 14.722656 -0.273438 12.648438 0.3125 9.984375 0.3125 C 7.335938 0.3125 5.222656 -0.289062 3.640625 -1.5 C 2.066406 -2.707031 1.25 -4.488281 1.1875 -6.84375 L 5.65625 -6.84375 C 5.738281 -5.75 6.171875 -4.925781 6.953125 -4.375 C 7.734375 -3.832031 8.722656 -3.5625 9.921875 -3.5625 C 11.097656 -3.5625 12.035156 -3.804688 12.734375 -4.296875 C 13.429688 -4.796875 13.785156 -5.445312 13.796875 -6.25 C 13.785156 -6.976562 13.460938 -7.539062 12.828125 -7.9375 C 12.191406 -8.34375 11.28125 -8.6875 10.09375 -8.96875 L 7.71875 -9.5625 C 5.875 -10.007812 4.421875 -10.710938 3.359375 -11.671875 C 2.296875 -12.628906 1.765625 -13.910156 1.765625 -15.515625 C 1.765625 -16.835938 2.117188 -17.992188 2.828125 -18.984375 C 3.546875 -19.972656 4.53125 -20.738281 5.78125 -21.28125 C 7.03125 -21.832031 8.445312 -22.109375 10.03125 -22.109375 C 11.65625 -22.109375 13.070312 -21.832031 14.28125 -21.28125 C 15.488281 -20.726562 16.429688 -19.957031 17.109375 -18.96875 C 17.785156 -17.988281 18.132812 -16.847656 18.15625 -15.546875 Z M 13.734375 -15.546875 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(206.933834, 228.755639)">
                        <g>
                            <path
                                d="M 1.890625 0 L 1.890625 -21.8125 L 10.5 -21.8125 C 12.15625 -21.8125 13.566406 -21.5 14.734375 -20.875 C 15.898438 -20.25 16.789062 -19.378906 17.40625 -18.265625 C 18.019531 -17.148438 18.328125 -15.867188 18.328125 -14.421875 C 18.328125 -12.972656 18.015625 -11.695312 17.390625 -10.59375 C 16.765625 -9.488281 15.859375 -8.625 14.671875 -8 C 13.492188 -7.382812 12.066406 -7.078125 10.390625 -7.078125 L 6.515625 -7.078125 L 6.515625 0 Z M 6.515625 -10.765625 L 9.640625 -10.765625 C 10.960938 -10.765625 11.945312 -11.101562 12.59375 -11.78125 C 13.25 -12.46875 13.578125 -13.347656 13.578125 -14.421875 C 13.578125 -15.515625 13.25 -16.390625 12.59375 -17.046875 C 11.945312 -17.710938 10.957031 -18.046875 9.625 -18.046875 L 6.515625 -18.046875 Z M 6.515625 -10.765625 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(226.365592, 228.755639)">
                        <g>
                            <path
                                d="M 5.65625 0 L 0.71875 0 L 8.25 -21.8125 L 14.1875 -21.8125 L 21.71875 0 L 16.765625 0 L 15.15625 -4.96875 L 7.28125 -4.96875 Z M 8.453125 -8.578125 L 13.984375 -8.578125 L 11.296875 -16.828125 L 11.140625 -16.828125 Z M 8.453125 -8.578125 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(248.801607, 228.755639)">
                        <g>
                            <path
                                d="M 21.140625 -14.1875 L 16.484375 -14.1875 C 16.304688 -15.382812 15.789062 -16.320312 14.9375 -17 C 14.09375 -17.6875 13.039062 -18.03125 11.78125 -18.03125 C 10.09375 -18.03125 8.738281 -17.410156 7.71875 -16.171875 C 6.695312 -14.929688 6.1875 -13.175781 6.1875 -10.90625 C 6.1875 -8.582031 6.695312 -6.8125 7.71875 -5.59375 C 8.75 -4.382812 10.09375 -3.78125 11.75 -3.78125 C 12.976562 -3.78125 14.019531 -4.097656 14.875 -4.734375 C 15.726562 -5.378906 16.265625 -6.285156 16.484375 -7.453125 L 21.140625 -7.4375 C 20.984375 -6.101562 20.507812 -4.84375 19.71875 -3.65625 C 18.925781 -2.476562 17.851562 -1.523438 16.5 -0.796875 C 15.15625 -0.0664062 13.546875 0.296875 11.671875 0.296875 C 9.722656 0.296875 7.984375 -0.140625 6.453125 -1.015625 C 4.929688 -1.898438 3.726562 -3.175781 2.84375 -4.84375 C 1.957031 -6.507812 1.515625 -8.53125 1.515625 -10.90625 C 1.515625 -13.289062 1.960938 -15.316406 2.859375 -16.984375 C 3.753906 -18.648438 4.96875 -19.921875 6.5 -20.796875 C 8.03125 -21.671875 9.753906 -22.109375 11.671875 -22.109375 C 13.359375 -22.109375 14.878906 -21.796875 16.234375 -21.171875 C 17.585938 -20.554688 18.691406 -19.65625 19.546875 -18.46875 C 20.410156 -17.289062 20.941406 -15.863281 21.140625 -14.1875 Z M 21.140625 -14.1875 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(271.365452, 228.755639)">
                        <g>
                            <path
                                d="M 1.890625 0 L 1.890625 -21.8125 L 16.59375 -21.8125 L 16.59375 -18.015625 L 6.515625 -18.015625 L 6.515625 -12.8125 L 15.84375 -12.8125 L 15.84375 -9.015625 L 6.515625 -9.015625 L 6.515625 -3.796875 L 16.640625 -3.796875 L 16.640625 0 Z M 1.890625 0 " />
                        </g>
                    </g>
                </g>
            </svg>
            <h1>GREEN SPACEは、リラックスしたい方々のために、自然の中や街中の特定の場所やイベント情報を提供することを目的としたウェブサイトです。このプロジェクトは、学習の一環として開発され、ユーザーに心地よい体験を提供することを目指しています。</h1>
            <h2>使用したツールと技術</h2>
            <hr>
            <div class="project-info">
                <div>
                    <p>プログラミング言語:</p>
                    <svg width="60px" height="60px" viewBox="-52.5 0 361 361" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        preserveAspectRatio="xMidYMid" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <path
                                    d="M255.554813,70.7657143 L232.31367,331.125451 L127.843868,360.087912 L23.6617143,331.166242 L0.445186813,70.7657143 L255.554813,70.7657143 L255.554813,70.7657143 Z"
                                    fill="#E44D26"> </path>
                                <path
                                    d="M128,337.950242 L212.416703,314.546637 L232.277802,92.0573187 L128,92.0573187 L128,337.950242 L128,337.950242 Z"
                                    fill="#F16529"> </path>
                                <path
                                    d="M82.8202198,155.932132 L128,155.932132 L128,123.994725 L47.917011,123.994725 L48.6814945,132.562989 L56.530989,220.572835 L128,220.572835 L128,188.636132 L85.7389011,188.636132 L82.8202198,155.932132 L82.8202198,155.932132 Z"
                                    fill="#EBEBEB"> </path>
                                <path
                                    d="M90.0177582,236.54189 L57.957978,236.54189 L62.4323516,286.687648 L127.853011,304.848879 L128,304.808088 L128,271.580132 L127.860044,271.617407 L92.2915165,262.013187 L90.0177582,236.54189 L90.0177582,236.54189 Z"
                                    fill="#EBEBEB"> </path>
                                <path
                                    d="M24.1807473,0 L40.4107253,0 L40.4107253,16.0351648 L55.2573187,16.0351648 L55.2573187,0 L71.488,0 L71.488,48.5584176 L55.258022,48.5584176 L55.258022,32.2981978 L40.4114286,32.2981978 L40.4114286,48.5584176 L24.1814505,48.5584176 L24.1814505,0 L24.1807473,0 L24.1807473,0 Z"
                                    fill="#000000"> </path>
                                <path
                                    d="M92.8309451,16.1026813 L78.5427692,16.1026813 L78.5427692,0 L123.356835,0 L123.356835,16.1026813 L109.06233,16.1026813 L109.06233,48.5584176 L92.8316484,48.5584176 L92.8316484,16.1026813 L92.8309451,16.1026813 L92.8309451,16.1026813 Z"
                                    fill="#000000"> </path>
                                <path
                                    d="M130.469275,0 L147.392703,0 L157.802901,17.061978 L168.202549,0 L185.132308,0 L185.132308,48.5584176 L168.969143,48.5584176 L168.969143,24.4901978 L157.802901,41.7554286 L157.523692,41.7554286 L146.349714,24.4901978 L146.349714,48.5584176 L130.469275,48.5584176 L130.469275,0 L130.469275,0 Z"
                                    fill="#000000"> </path>
                                <path
                                    d="M193.20967,0 L209.444571,0 L209.444571,32.5077802 L232.268659,32.5077802 L232.268659,48.5584176 L193.20967,48.5584176 L193.20967,0 L193.20967,0 Z"
                                    fill="#000000"> </path>
                                <path
                                    d="M127.889582,220.572835 L167.216527,220.572835 L163.509451,261.992791 L127.889582,271.606857 L127.889582,304.833407 L193.362286,286.687648 L193.842637,281.291956 L201.347516,197.212132 L202.126769,188.636132 L127.889582,188.636132 L127.889582,220.572835 L127.889582,220.572835 Z"
                                    fill="#FFFFFF"> </path>
                                <path
                                    d="M127.889582,155.854066 L127.889582,155.932132 L205.032791,155.932132 L205.673495,148.753582 L207.128615,132.562989 L207.892396,123.994725 L127.889582,123.994725 L127.889582,155.854066 L127.889582,155.854066 Z"
                                    fill="#FFFFFF"> </path>
                            </g>
                        </g>
                    </svg>
                    <svg width="60px" height="60px" viewBox="-52.5 0 361 361" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        preserveAspectRatio="xMidYMid" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <path
                                    d="M127.843868,360.087912 L23.6617143,331.166242 L0.445186813,70.7657143 L255.554813,70.7657143 L232.31367,331.125451 L127.843868,360.087912 L127.843868,360.087912 Z"
                                    fill="#264DE4"> </path>
                                <path
                                    d="M212.416703,314.546637 L232.277802,92.0573187 L128,92.0573187 L128,337.950242 L212.416703,314.546637 L212.416703,314.546637 Z"
                                    fill="#2965F1"> </path>
                                <path
                                    d="M53.6685714,188.636132 L56.530989,220.572835 L128,220.572835 L128,188.636132 L53.6685714,188.636132 L53.6685714,188.636132 Z"
                                    fill="#EBEBEB"> </path>
                                <path
                                    d="M47.917011,123.994725 L50.8202198,155.932132 L128,155.932132 L128,123.994725 L47.917011,123.994725 L47.917011,123.994725 Z"
                                    fill="#EBEBEB"> </path>
                                <path
                                    d="M128,271.580132 L127.860044,271.617407 L92.2915165,262.013187 L90.0177582,236.54189 L57.957978,236.54189 L62.4323516,286.687648 L127.853011,304.848879 L128,304.808088 L128,271.580132 L128,271.580132 Z"
                                    fill="#EBEBEB"> </path>
                                <path
                                    d="M60.4835165,0 L99.1648352,0 L99.1648352,16.1758242 L76.6593407,16.1758242 L76.6593407,32.3516484 L99.1648352,32.3516484 L99.1648352,48.5274725 L60.4835165,48.5274725 L60.4835165,0 L60.4835165,0 Z"
                                    fill="#000000"> </path>
                                <path
                                    d="M106.901099,0 L145.582418,0 L145.582418,14.0659341 L123.076923,14.0659341 L123.076923,16.8791209 L145.582418,16.8791209 L145.582418,49.2307692 L106.901099,49.2307692 L106.901099,34.4615385 L129.406593,34.4615385 L129.406593,31.6483516 L106.901099,31.6483516 L106.901099,0 L106.901099,0 Z"
                                    fill="#000000"> </path>
                                <path
                                    d="M153.318681,0 L192,0 L192,14.0659341 L169.494505,14.0659341 L169.494505,16.8791209 L192,16.8791209 L192,49.2307692 L153.318681,49.2307692 L153.318681,34.4615385 L175.824176,34.4615385 L175.824176,31.6483516 L153.318681,31.6483516 L153.318681,0 L153.318681,0 Z"
                                    fill="#000000"> </path>
                                <path
                                    d="M202.126769,188.636132 L207.892396,123.994725 L127.889582,123.994725 L127.889582,155.932132 L172.892132,155.932132 L169.98611,188.636132 L127.889582,188.636132 L127.889582,220.572835 L167.216527,220.572835 L163.509451,261.992791 L127.889582,271.606857 L127.889582,304.833407 L193.362286,286.687648 L193.842637,281.291956 L201.347516,197.212132 L202.126769,188.636132 L202.126769,188.636132 Z"
                                    fill="#FFFFFF"> </path>
                            </g>
                        </g>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" aria-label="JavaScript" role="img" viewBox="0 0 512 512"
                        width="60px" height="60px" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <rect width="512" height="512" rx="15%" fill="#f7df1e"></rect>
                            <path
                                d="M324 370c10 17 24 29 47 29c20 0 33-10 33 -24c0-16 -13 -22 -35 -32l-12-5c-35-15 -58 -33 -58 -72c0-36 27 -64 70 -64c31 0 53 11 68 39l-37 24c-8-15 -17 -21 -31 -21c-14 0-23 9 -23 21c0 14 9 20 30 29l12 5c41 18 64 35 64 76c0 43-34 67 -80 67c-45 0-74 -21 -88 -49zm-170 4c8 13 14 25 31 25c16 0 26-6 26 -30V203h48v164c0 50-29 72 -72 72c-39 0-61 -20 -72 -44z">
                            </path>
                        </g>
                    </svg>
                    <svg width="60px" height="60px" viewBox="0 -60.5 256 256" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        preserveAspectRatio="xMidYMid" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <defs>
                                <radialGradient id="radialGradient-1" cx="0.8366" cy="-125.811" r="363.0565"
                                    gradientTransform="matrix(0.463 0 0 0.463 76.4644 81.9182)"
                                    gradientUnits="userSpaceOnUse">
                                    <stop offset="0" style="stop-color:#FFFFFF"></stop>
                                    <stop offset="0.5" style="stop-color:#4C6B97"></stop>
                                    <stop offset="1" style="stop-color:#231F20"></stop>
                                </radialGradient>
                            </defs>
                            <g>
                                <ellipse fill="url(#radialGradient-1)" cx="128" cy="67.3" rx="128" ry="67.3"></ellipse>
                                <ellipse fill="#6181B6" cx="128" cy="67.3" rx="123" ry="62.3"></ellipse>
                                <g>
                                    <path fill="#FFFFFF"
                                        d="M152.9,87.5c0,0,6.1-31.4,6.1-31.4c1.4-7.1,0.2-12.4-3.4-15.7c-3.5-3.2-9.5-4.8-18.3-4.8h-10.6l3-15.6 c0.1-0.6,0-1.2-0.4-1.7c-0.4-0.5-0.9-0.7-1.5-0.7h-14.6c-1,0-1.8,0.7-2,1.6l-6.5,33.3c-0.6-3.8-2-7-4.4-9.6 c-4.3-4.9-11-7.4-20.1-7.4H52.1c-1,0-1.8,0.7-2,1.6L37,104.7c-0.1,0.6,0,1.2,0.4,1.7c0.4,0.5,0.9,0.7,1.5,0.7h14.7 c1,0,1.8-0.7,2-1.6l3.2-16.3h10.9c5.7,0,10.6-0.6,14.3-1.8c3.9-1.3,7.4-3.4,10.5-6.3c2.5-2.3,4.6-4.9,6.2-7.7l-2.6,13.5 c-0.1,0.6,0,1.2,0.4,1.7s0.9,0.7,1.5,0.7h14.6c1,0,1.8-0.7,2-1.6l7.2-37h10c4.3,0,5.5,0.8,5.9,1.2c0.3,0.3,0.9,1.5,0.2,5.2 l-5.8,29.9c-0.1,0.6,0,1.2,0.4,1.7c0.4,0.5,0.9,0.7,1.5,0.7H151C151.9,89.1,152.7,88.4,152.9,87.5z M85.3,61.5 c-0.9,4.7-2.6,8.1-5.1,10c-2.5,1.9-6.6,2.9-12,2.9h-6.5l4.7-24.2h8.4c6.2,0,8.7,1.3,9.7,2.4C85.8,54.2,86.1,57.3,85.3,61.5z">
                                    </path>
                                    <path fill="#FFFFFF"
                                        d="M215.3,42.9c-4.3-4.9-11-7.4-20.1-7.4h-28.3c-1,0-1.8,0.7-2,1.6l-13.1,67.5c-0.1,0.6,0,1.2,0.4,1.7 c0.4,0.5,0.9,0.7,1.5,0.7h14.7c1,0,1.8-0.7,2-1.6l3.2-16.3h10.9c5.7,0,10.6-0.6,14.3-1.8c3.9-1.3,7.4-3.4,10.5-6.3 c2.6-2.4,4.8-5.1,6.4-8c1.6-2.9,2.8-6.1,3.5-9.6C220.9,54.7,219.6,47.9,215.3,42.9z M200,61.5c-0.9,4.7-2.6,8.1-5.1,10 c-2.5,1.9-6.6,2.9-12,2.9h-6.5l4.7-24.2h8.4c6.2,0,8.7,1.3,9.7,2.4C200.6,54.2,200.9,57.3,200,61.5z">
                                    </path>
                                </g>
                                <g>
                                    <path fill="#000004"
                                        d="M74.8,48.2c5.6,0,9.3,1,11.2,3.1c1.9,2.1,2.3,5.6,1.3,10.6c-1,5.2-3,9-5.9,11.2c-2.9,2.2-7.3,3.3-13.2,3.3 h-8.9l5.5-28.2H74.8z M39,105h14.7l3.5-17.9h12.6c5.6,0,10.1-0.6,13.7-1.8c3.6-1.2,6.8-3.1,9.8-5.9c2.5-2.3,4.5-4.8,6-7.5 c1.5-2.7,2.6-5.7,3.2-9c1.6-8,0.4-14.2-3.5-18.7c-3.9-4.5-10.1-6.7-18.6-6.7H52.1L39,105z">
                                    </path>
                                    <path fill="#000004"
                                        d="M113.3,19.6h14.6l-3.5,17.9h13c8.2,0,13.8,1.4,16.9,4.3c3.1,2.9,4,7.5,2.8,13.9L151,87.1h-14.8l5.8-29.9 c0.7-3.4,0.4-5.7-0.7-6.9c-1.1-1.2-3.6-1.9-7.3-1.9h-11.7l-7.5,38.7h-14.6L113.3,19.6z">
                                    </path>
                                    <path fill="#000004"
                                        d="M189.5,48.2c5.6,0,9.3,1,11.2,3.1c1.9,2.1,2.3,5.6,1.3,10.6c-1,5.2-3,9-5.9,11.2c-2.9,2.2-7.3,3.3-13.2,3.3 h-8.9l5.5-28.2H189.5z M153.7,105h14.7l3.5-17.9h12.6c5.6,0,10.1-0.6,13.7-1.8c3.6-1.2,6.8-3.1,9.8-5.9c2.5-2.3,4.5-4.8,6-7.5 c1.5-2.7,2.6-5.7,3.2-9c1.6-8,0.4-14.2-3.5-18.7c-3.9-4.5-10.1-6.7-18.6-6.7h-28.3L153.7,105z">
                                    </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <div>
                    <p>データベース:</p>
                    <svg width="60px" height="60px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"
                        fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>folder_type_mysql</title>
                            <path d="M27.917,6H18.143l-2,4H5V27H30V6ZM28,10H20.19l1.048-2H28Z" style="fill:#2a4b59">
                            </path>
                            <path
                                d="M16.018,14.715a2.267,2.267,0,0,0-.591.072v.029h.028a4.784,4.784,0,0,0,.461.591c.116.231.217.46.332.691l.028-.029a.81.81,0,0,0,.3-.721,3.194,3.194,0,0,1-.173-.3c-.086-.144-.274-.216-.39-.331"
                                style="fill:#ffffff;fill-rule:evenodd"></path>
                            <path
                                d="M30.328,27.286a6.676,6.676,0,0,0-2.8.4c-.216.086-.562.086-.591.36.116.115.13.3.232.462a3.376,3.376,0,0,0,.749.879c.3.231.605.46.923.662.562.347,1.2.548,1.743.894.318.2.634.461.953.678.158.115.258.3.46.374v-.044a2.918,2.918,0,0,0-.22-.462c-.144-.143-.288-.274-.433-.417a6.878,6.878,0,0,0-1.5-1.455c-.462-.318-1.471-.75-1.658-1.282l-.029-.029a5.843,5.843,0,0,0,1-.232c.489-.129.936-.1,1.441-.229.231-.058.649-.2.649-.2V27.42c-.258-.256-.442-.6-.713-.841a19.049,19.049,0,0,0-2.352-1.753c-.443-.285-1.013-.47-1.483-.713-.17-.086-.455-.128-.555-.271a5.714,5.714,0,0,1-.585-1.1c-.413-.783-.813-1.652-1.169-2.48a15.136,15.136,0,0,0-.727-1.625,14.371,14.371,0,0,0-5.517-5.331,6.818,6.818,0,0,0-1.824-.585c-.357-.015-.713-.043-1.069-.057a5.792,5.792,0,0,1-.656-.5c-.813-.513-2.907-1.625-3.506-.157-.385.927.57,1.839.9,2.31a6.683,6.683,0,0,1,.726,1.069c.1.242.128.5.229.756a17.035,17.035,0,0,0,.741,1.911,6.726,6.726,0,0,0,.527.883c.115.158.314.228.357.486a4.086,4.086,0,0,0-.328,1.069,6.276,6.276,0,0,0,.414,4.789c.228.356.77,1.141,1.5.841.641-.256.5-1.069.684-1.781.043-.172.014-.285.1-.4v.14s.364.8.544,1.209a8.152,8.152,0,0,0,1.8,1.951,2.634,2.634,0,0,1,.663.875v.258h.322a.8.8,0,0,0-.319-.593,7.1,7.1,0,0,1-.722-.874,18.765,18.765,0,0,1-1.555-2.651c-.223-.453-.417-.947-.6-1.4-.083-.174-.083-.437-.222-.524a5.458,5.458,0,0,0-.666.989,8.569,8.569,0,0,0-.389,2.2c-.055.015-.028,0-.055.029-.444-.116-.6-.6-.764-1a6.6,6.6,0,0,1-.125-3.89c.1-.3.515-1.267.347-1.558-.084-.278-.361-.437-.514-.656a5.881,5.881,0,0,1-.5-.932c-.333-.815-.5-1.719-.861-2.534a7.844,7.844,0,0,0-.694-1.122,7.236,7.236,0,0,1-.764-1.136.707.707,0,0,1-.056-.6.227.227,0,0,1,.2-.19c.18-.16.694.043.874.131a6.924,6.924,0,0,1,1.374.728c.2.146.652.516.652.516h.135c.461.1.981.028,1.413.158a9.189,9.189,0,0,1,2.075.994,12.786,12.786,0,0,1,4.5,4.93c.173.331.246.634.4.979.3.708.678,1.429.98,2.12a9.482,9.482,0,0,0,1.024,1.932c.216.3,1.081.461,1.47.62a10.54,10.54,0,0,1,1,.4c.49.3.979.649,1.441.981.23.173.951.533.994.822"
                                style="fill:#f3fdff;fill-rule:evenodd"></path>
                        </g>
                    </svg>
                </div>
                <div>
                    <p>デザインツール:</p>
                    <svg width="60px" height="60px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill="#1ABCFE"
                                d="M8.55 8c0-1.289 1.019-2.333 2.275-2.333C12.082 5.667 13.1 6.71 13.1 8c0 1.289-1.018 2.333-2.275 2.333C9.57 10.333 8.55 9.29 8.55 8z">
                            </path>
                            <path fill="#0ACF83"
                                d="M4 12.667c0-1.289 1.019-2.334 2.275-2.334H8.55v2.334C8.55 13.955 7.531 15 6.275 15S4 13.955 4 12.667z">
                            </path>
                            <path fill="#FF7262"
                                d="M8.55 1v4.667h2.275c1.257 0 2.275-1.045 2.275-2.334C13.1 2.045 12.082 1 10.825 1H8.55z">
                            </path>
                            <path fill="#F24E1E"
                                d="M4 3.333c0 1.289 1.019 2.334 2.275 2.334H8.55V1H6.275C5.019 1 4 2.045 4 3.333z">
                            </path>
                            <path fill="#A259FF"
                                d="M4 8c0 1.289 1.019 2.333 2.275 2.333H8.55V5.667H6.275C5.019 5.667 4 6.71 4 8z">
                            </path>
                        </g>
                    </svg>
                </div>
                <div>
                    <p>ホスティングサービス:</p>
                    <svg width="64px" height="64px" viewBox="0 -28.5 256 256" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>path21</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M118.431947,187.698037 C151.322003,181.887937 178.48731,177.08008 178.799309,177.013916 L179.366585,176.893612 L148.31513,139.958881 C131.236843,119.644776 117.26369,102.945381 117.26369,102.849118 C117.26369,102.666861 149.32694,14.3716012 149.507189,14.057257 C149.567455,13.952452 171.38747,51.62411 202.400338,105.376064 C231.435152,155.699606 255.372949,197.191547 255.595444,197.580359 L255.999996,198.287301 L157.315912,198.274572 L58.6318456,198.261895 L118.431947,187.698073 L118.431947,187.698037 Z M-4.03864498e-06,176.434723 C-4.03864498e-06,176.382721 14.631291,150.983941 32.5139844,119.992969 L65.0279676,63.6457518 L102.919257,31.8473052 C123.759465,14.3581634 140.866667,0.0274832751 140.935253,0.00062917799 C141.003839,-0.0247829554 140.729691,0.665213042 140.326034,1.53468179 C139.922377,2.40415053 121.407304,42.1170321 99.1814268,89.7855264 L58.7707514,176.455514 L29.3853737,176.492355 C13.2234196,176.512639 -4.03864498e-06,176.486664 -4.03864498e-06,176.434703 L-4.03864498e-06,176.434723 Z"
                                    fill="#0089D6" fill-rule="nonzero"> </path>
                            </g>
                        </g>
                    </svg>
                </div>
                <div>
                    <p>ソフトウエアとツール:</p>
                    <svg width="60px" height="60px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"
                        fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>file_type_vscode</title>
                            <path
                                d="M29.01,5.03,23.244,2.254a1.742,1.742,0,0,0-1.989.338L2.38,19.8A1.166,1.166,0,0,0,2.3,21.447c.025.027.05.053.077.077l1.541,1.4a1.165,1.165,0,0,0,1.489.066L28.142,5.75A1.158,1.158,0,0,1,30,6.672V6.605A1.748,1.748,0,0,0,29.01,5.03Z"
                                style="fill:#0065a9"></path>
                            <path
                                d="M29.01,26.97l-5.766,2.777a1.745,1.745,0,0,1-1.989-.338L2.38,12.2A1.166,1.166,0,0,1,2.3,10.553c.025-.027.05-.053.077-.077l1.541-1.4A1.165,1.165,0,0,1,5.41,9.01L28.142,26.25A1.158,1.158,0,0,0,30,25.328V25.4A1.749,1.749,0,0,1,29.01,26.97Z"
                                style="fill:#007acc"></path>
                            <path
                                d="M23.244,29.747a1.745,1.745,0,0,1-1.989-.338A1.025,1.025,0,0,0,23,28.684V3.316a1.024,1.024,0,0,0-1.749-.724,1.744,1.744,0,0,1,1.989-.339l5.765,2.772A1.748,1.748,0,0,1,30,6.6V25.4a1.748,1.748,0,0,1-.991,1.576Z"
                                style="fill:#1f9cf0"></path>
                        </g>
                    </svg>
                    <svg width="60px" height="60px" fill="none" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5"
                        class="h-6 w-6"
                        viewBox="-0.17090198558635983 0.482230148717937 41.14235318283891 40.0339509076386"><text
                            x="-9999" y="-9999">ChatGPT</text>
                        <path
                            d="M37.532 16.87a9.963 9.963 0 0 0-.856-8.184 10.078 10.078 0 0 0-10.855-4.835A9.964 9.964 0 0 0 18.306.5a10.079 10.079 0 0 0-9.614 6.977 9.967 9.967 0 0 0-6.664 4.834 10.08 10.08 0 0 0 1.24 11.817 9.965 9.965 0 0 0 .856 8.185 10.079 10.079 0 0 0 10.855 4.835 9.965 9.965 0 0 0 7.516 3.35 10.078 10.078 0 0 0 9.617-6.981 9.967 9.967 0 0 0 6.663-4.834 10.079 10.079 0 0 0-1.243-11.813zM22.498 37.886a7.474 7.474 0 0 1-4.799-1.735c.061-.033.168-.091.237-.134l7.964-4.6a1.294 1.294 0 0 0 .655-1.134V19.054l3.366 1.944a.12.12 0 0 1 .066.092v9.299a7.505 7.505 0 0 1-7.49 7.496zM6.392 31.006a7.471 7.471 0 0 1-.894-5.023c.06.036.162.099.237.141l7.964 4.6a1.297 1.297 0 0 0 1.308 0l9.724-5.614v3.888a.12.12 0 0 1-.048.103l-8.051 4.649a7.504 7.504 0 0 1-10.24-2.744zM4.297 13.62A7.469 7.469 0 0 1 8.2 10.333c0 .068-.004.19-.004.274v9.201a1.294 1.294 0 0 0 .654 1.132l9.723 5.614-3.366 1.944a.12.12 0 0 1-.114.01L7.04 23.856a7.504 7.504 0 0 1-2.743-10.237zm27.658 6.437l-9.724-5.615 3.367-1.943a.121.121 0 0 1 .113-.01l8.052 4.648a7.498 7.498 0 0 1-1.158 13.528v-9.476a1.293 1.293 0 0 0-.65-1.132zm3.35-5.043c-.059-.037-.162-.099-.236-.141l-7.965-4.6a1.298 1.298 0 0 0-1.308 0l-9.723 5.614v-3.888a.12.12 0 0 1 .048-.103l8.05-4.645a7.497 7.497 0 0 1 11.135 7.763zm-21.063 6.929l-3.367-1.944a.12.12 0 0 1-.065-.092v-9.299a7.497 7.497 0 0 1 12.293-5.756 6.94 6.94 0 0 0-.236.134l-7.965 4.6a1.294 1.294 0 0 0-.654 1.132l-.006 11.225zm1.829-3.943l4.33-2.501 4.332 2.5v5l-4.331 2.5-4.331-2.5V18z"
                            fill="currentColor" />
                    </svg>
                </div>
                <div>
                    <p>ベクターとアイコン:</p>
                    <a href="https://www.svgrepo.com/">SVG Repo</a>
                </div>
            </div>
            <h3>制作</h3>
            <div class="maker-info">
                <div>
                    <p>作者:</p>
                    <p>レリタンハイ</p>
                </div>
                <div>
                    <p>ポートフォリオ:</p>
                    <!-- them link portfolio -->
                    <a href="#">ポートフォリオ</a>
                </div>
                <hr>
                <div>
                    <p>© 2024 GREEN SPACE. 本プロジェクトは個人所有であり、学習目的で実施され、商業目的ではありません。</p>
                </div>
            </div>
    </main>
    <div id="overlay"></div>
    <footer>
        <?php include 'include/footer.php' ?>
    </footer>
    <script src="js/menu.js"></script>
</body>

</html>