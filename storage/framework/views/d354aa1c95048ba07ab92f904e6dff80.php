<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>404 — Page Not Found | Al-Asra</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">

    <style>
        /* ---- palette: change these 4 lines to match the brand exactly ---- */
        :root{
            --nf-bg:#EEE8DD;      /* page */
            --nf-ink:#12100E;     /* text / dark buttons */
            --nf-num:#DDD5C7;     /* giant 404 */
            --nf-glass:rgba(255,255,255,.62);
        }
        *{box-sizing:border-box;margin:0;padding:0}
        html,body{height:100%}
        body{background:var(--nf-bg);color:var(--nf-ink);font-family:'Inter',system-ui,-apple-system,'Segoe UI',sans-serif;-webkit-font-smoothing:antialiased;overflow:hidden}
        a{color:inherit;text-decoration:none}
        img{display:block}
        :focus-visible{outline:2px solid var(--nf-ink);outline-offset:3px}

        .nf-stage{position:fixed;inset:0;overflow:hidden;--nfy:1.4}
        .nf-ic{width:18px;height:18px;flex:none}

        /* giant stretched 404 + oval */
        .nf-bgl{position:absolute;inset:0;display:grid;place-items:center;overflow:hidden}
        .nf-404{display:block;font-size:min(52vw,70vh);line-height:.8;font-weight:800;letter-spacing:-.05em;color:var(--nf-num);
                transform:scaleY(var(--nfy));transform-origin:center;user-select:none;white-space:nowrap}
        .nf-oval{position:absolute;left:50%;top:42%;width:min(70vw,50vh);aspect-ratio:4/5;transform:translate(-50%,-50%);border-radius:50%;
                 background:rgba(255,255,255,.55);box-shadow:0 50px 100px -40px rgba(18,16,14,.4),inset 0 0 0 1px rgba(255,255,255,.8)}

        /* video inside the oval */
        .nf-vid{position:absolute;inset:0;pointer-events:none}
        .nf-vid>div{position:absolute;left:50%;top:42%;width:min(61vw,43.5vh);aspect-ratio:4/5;transform:translate(-50%,-50%);border-radius:50%;overflow:hidden;background:#e4dccd}
        .nf-vid video{width:100%;height:100%;object-fit:cover;display:block}

        /* top nav */
        .nf-nav{position:absolute;top:0;left:0;right:0;z-index:5;display:flex;align-items:center;justify-content:space-between;padding:20px clamp(16px,3vw,40px)}
        .nf-logo{display:inline-flex;align-items:center}
        .nf-logo img{height:36px;width:auto;max-width:150px;object-fit:contain}
        .nf-links{display:none;gap:8px;position:absolute;left:50%;transform:translateX(-50%)}
        .nf-pill{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border-radius:999px;border:0;cursor:pointer;
                 background:var(--nf-glass);-webkit-backdrop-filter:blur(14px);backdrop-filter:blur(14px);
                 font:500 14px/1 'Inter',system-ui,sans-serif;color:var(--nf-ink);transition:background .25s,color .25s}
        .nf-pill:hover{background:var(--nf-ink);color:#fff}
        @media (min-width:900px){ .nf-links{display:flex} .nf-menubtn{display:none} }

        /* bottom */
        .nf-bottom{position:absolute;left:0;right:0;bottom:0;z-index:4;display:flex;flex-direction:column;align-items:center;gap:20px;text-align:center;padding:0 24px clamp(28px,6vh,56px)}
        .nf-bottom h1{font-size:clamp(26px,4.2vw,56px);line-height:1.05;font-weight:600;letter-spacing:-.035em;max-width:16ch;text-wrap:balance}
        .nf-cta{display:inline-flex;align-items:center;gap:10px;background:var(--nf-ink);color:#fff;font-size:15px;font-weight:500;border-radius:999px;padding:15px 30px;transition:transform .25s,opacity .25s}
        .nf-cta:hover{opacity:.85;transform:translateY(-2px)}

        /* slide-in menu */
        .nf-ov{position:fixed;inset:0;z-index:50;visibility:hidden;pointer-events:none;transition:visibility 0s linear .5s}
        .nf-ov.on{visibility:visible;pointer-events:auto;transition-delay:0s}
        .nf-back{position:absolute;inset:0;background:rgba(18,16,14,.5);opacity:0;transition:opacity .4s ease}
        .nf-ov.on .nf-back{opacity:1}
        .nf-panel{position:absolute;top:0;right:0;bottom:0;width:min(88vw,400px);background:var(--nf-bg);display:flex;flex-direction:column;padding:20px 24px 28px;
                  transform:translateX(100%);transition:transform .5s cubic-bezier(.2,.8,.2,1);border-radius:28px 0 0 28px;box-shadow:-30px 0 80px -30px rgba(18,16,14,.4)}
        .nf-ov.on .nf-panel{transform:none}
        .nf-ph{display:flex;align-items:center;justify-content:space-between}
        .nf-x{width:42px;height:42px;border-radius:50%;border:0;cursor:pointer;background:var(--nf-glass);color:var(--nf-ink);display:grid;place-items:center;transition:background .25s,color .25s}
        .nf-x:hover{background:var(--nf-ink);color:#fff}
        .nf-items{display:flex;flex-direction:column;margin-top:30px}
        .nf-items a{font-size:34px;font-weight:600;letter-spacing:-.035em;padding:12px 0;border-bottom:1px solid rgba(18,16,14,.1);
                    opacity:0;transform:translateX(28px);transition:opacity .5s ease,transform .5s cubic-bezier(.2,.8,.2,1),padding-left .25s;transition-delay:calc(var(--i) * 55ms + 120ms)}
        .nf-ov.on .nf-items a{opacity:1;transform:none}
        .nf-items a:hover{padding-left:8px}
        .nf-pb{margin-top:auto}
        .nf-pb a{display:flex;align-items:center;justify-content:center;gap:10px;background:var(--nf-ink);color:#fff;border-radius:999px;padding:16px;font-weight:500}

        @media (prefers-reduced-motion:reduce){
            .nf-panel,.nf-back,.nf-items a,.nf-cta{transition:none}
            .nf-vid video{display:none}
        }
    </style>
</head>

<body>
<?php
    $nav = [
        ['Home', url('/')],
        ['Shop', url('/shop')],
        ['About', url('/about')],
        ['Track order', url('/track')],
        ['FAQ', url('/faq')],
        ['Contact', url('/contact')],
    ];
    $video = 'https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260713_234424_b1332b69-2e69-4302-8dbc-40f86846afbd.mp4';
?>

<div class="nf-stage" id="nfStage">

    <div class="nf-bgl" aria-hidden="true">
        <span class="nf-404" id="nfNum">404</span>
        <div class="nf-oval"></div>
    </div>

    <div class="nf-vid" aria-hidden="true">
        <div><video src="<?php echo e($video); ?>" autoplay loop muted playsinline preload="auto" onerror="this.style.display='none'"></video></div>
    </div>

    <header class="nf-nav">
        <a href="<?php echo e(url('/')); ?>" class="nf-logo" aria-label="Al-Asra Store home"><img src="<?php echo e(asset('logo.png')); ?>" alt="Al-Asra Store"></a>

        <nav class="nf-links" aria-label="Main">
            <?php $__currentLoopData = $nav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$text, $href]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($href); ?>" class="nf-pill"><?php echo e($text); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>

        <button type="button" class="nf-pill nf-menubtn" id="nfMenuBtn" aria-label="Open menu" aria-expanded="false">
            <svg class="nf-ic" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 12h16M4 6h16M4 18h16"/></svg>Menu
        </button>
    </header>

    <div class="nf-bottom">
        <h1>Oops, something went wrong!</h1>
        <a href="<?php echo e(url('/')); ?>" class="nf-cta">
            <svg class="nf-ic" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m12 19-7-7 7-7M19 12H5"/></svg>Back to Home
        </a>
    </div>

    <div class="nf-ov" id="nfOv" aria-hidden="true">
        <div class="nf-back" id="nfBack"></div>
        <aside class="nf-panel">
            <div class="nf-ph">
                <span class="nf-logo"><img src="<?php echo e(asset('logo.png')); ?>" alt="Al-Asra Store"></span>
                <button type="button" class="nf-x" id="nfClose" aria-label="Close menu">
                    <svg class="nf-ic" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="nf-items">
                <?php $__currentLoopData = $nav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => [$text, $href]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($href); ?>" style="--i: <?php echo e($i); ?>"><?php echo e($text); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
            <div class="nf-pb">
                <a href="<?php echo e(url('/')); ?>">
                    <svg class="nf-ic" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m12 19-7-7 7-7M19 12H5"/></svg>Back to Home
                </a>
            </div>
        </aside>
    </div>
</div>

<script>
(function () {
    var stage = document.getElementById('nfStage'),
        num   = document.getElementById('nfNum'),
        ov    = document.getElementById('nfOv'),
        btn   = document.getElementById('nfMenuBtn');

    // stretch the giant 404 so it is ~1.4x the viewport height (capped so phones don't get paper-thin strokes)
    function fit() {
        if (!num.offsetHeight) return;
        var y = (window.innerHeight / num.offsetHeight) * 1.4;
        stage.style.setProperty('--nfy', String(Math.min(y, 4.2)));
    }
    function setOpen(v) {
        ov.classList.toggle('on', v);
        ov.setAttribute('aria-hidden', String(!v));
        btn.setAttribute('aria-expanded', String(v));
    }

    fit();
    window.addEventListener('resize', fit);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(fit);
    setTimeout(fit, 300);

    btn.addEventListener('click', function () { setOpen(true); });
    document.getElementById('nfClose').addEventListener('click', function () { setOpen(false); });
    document.getElementById('nfBack').addEventListener('click', function () { setOpen(false); });
    ov.querySelectorAll('.nf-items a, .nf-pb a').forEach(function (a) { a.addEventListener('click', function () { setOpen(false); }); });
    window.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
})();
</script>
</body>
</html><?php /**PATH D:\laragon\www\al-asra-online-website\resources\views/errors/404.blade.php ENDPATH**/ ?>