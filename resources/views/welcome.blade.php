<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GESTOR DE HORARIOS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style> 
html {
    line-height: 1.5;
    font-family: sans-serif;
    font-feature-settings: normal;
} 
.container {
    display: flex;
    flex-direction: column-reverse;
    align-items: flex-end;
    justify-content: flex-end;
}
.tittle {
    background-image: linear-gradient(90deg, #ff00d2, #fed90f, #00a2ff, #09f1b8);
    text-align: center;
    -webkit-text-stroke-color: transparent;
    -webkit-text-stroke-width: calc(1em/16);
    -webkit-background-clip: text;
    color: #000;
    padding: calc(calc(1em/16)/2);
    letter-spacing: calc(1em/8);
}
.log_in {
    position: absolute;
    color: white !important;
    font-weight: 600;
    text-decoration: inherit;
    padding: 1.6rem !important;
    text-align: right;
    margin-left: 1rem;
}
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body{
    min-height: 100vh;
    background: #111;
    overflow: hidden;
}
.logo{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 100px;
}
.line{
    position: absolute;
    height: 100vh;
    z-index: 1000;
    mix-blend-mode: color-dodge;
    width: 50px;
    animation: animate 2s linear infinite
}
@keyframes animate{
    0%, 100%{
        opacity: 0;
    }
    50%{
        opacity: 1;
    }
}
    </style>
</head>
<body class="antialiased">
    @if (Route::has('login'))
        @auth
        <a href="{{ url('/home') }}" class="font-semibold text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
    @else
        <div class="container">
            <a href="{{ route('login') }}" class="log_in" style="">Log in</a>
        </div>
        @endauth
        @endif
        <div class="logo">
            <h1 class="tittle">GESTOR DE HORARIOS</h1>
        </div>
    <script>
        function stripes(){
            let sizew= Math.random()*2;
            let e = document.createElement('div');
            e.classList.add('line');
            document.body.appendChild(e);
            e.style.left=Math.random()*innerWidth + 'px'
            e.style.width=1+sizew+'px';
            e.style.background=['#ff00d2', '#fed90f', '#70caee', '#09f1b8'][Math.floor(Math.random() * 4)];
            setTimeout(function() {
                document.body.removeChild(e);
            }, 2000);
        }
        setInterval(function(){
            stripes();
        }, 20);
    </script>
</body>

</html>
