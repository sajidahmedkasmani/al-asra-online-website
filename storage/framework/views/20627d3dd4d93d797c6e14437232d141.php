<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<<<<<<< Updated upstream
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Log in | Al-Asra</title>
=======
    <title>404 — Page Not Found | Al-Asra</title>
>>>>>>> Stashed changes

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">

    <style>
<<<<<<< Updated upstream
        /* ---- brand colours: edit these to match the storefront ---- */
        :root{
            --plum:#F24C00;      /* primary (button, links, focus) */
            --rose:#B8456A;      /* hover / focus glow */
            --cream:#F7F0E6;     /* form side background */
            --stage:#EEE4D6;     /* video side background */
            --num:#E2D6C5;       /* giant faded word behind the video */
            --ink: #12100E;
            --hover: #C93F00;
            --muted:rgba(18,16,14,.55);
            --line:rgba(18,16,14,.16);
            --glass:rgba(255,255,255,.62);
        }
        *{box-sizing:border-box;margin:0;padding:0}
        html{-webkit-text-size-adjust:100%}
        body{min-height:100vh;background:var(--cream);color:var(--ink);font-family:'Inter',system-ui,-apple-system,'Segoe UI',sans-serif;-webkit-font-smoothing:antialiased}
        a{color:inherit;text-decoration:none}
        img{display:block}
        button,input{font:inherit;color:inherit}
        :focus-visible{outline:2px solid var(--plum);outline-offset:3px}

        .lg{display:grid;grid-template-columns:1fr;min-height:100vh}

        /* ============ LEFT: video stage ============ */
        .stage{position:relative;overflow:hidden;height:300px;background:var(--stage);isolation:isolate}
        .word{display:none;position:absolute;left:50%;top:50%;z-index:-1;font-size:24vw;line-height:.8;font-weight:800;letter-spacing:-.05em;color:var(--num);white-space:nowrap;
              transform:translate(-50%,-50%) scaleY(var(--y,1.6));user-select:none}
        .oval{position:absolute;left:50%;top:50%;height:74%;aspect-ratio:4/5;transform:translate(-50%,-50%);border-radius:50%;padding:6%;
              background:rgba(255,255,255,.55);box-shadow:0 50px 100px -40px rgba(18,16,14,.4),inset 0 0 0 1px rgba(255,255,255,.8)}
        .oval>div{width:100%;height:100%;border-radius:50%;overflow:hidden;background:#e4dccd}
        .oval video{width:100%;height:100%;object-fit:cover;display:block}
        .stage-logo{position:absolute;top:20px;left:clamp(16px,3vw,40px)}
        .stage-logo img{height:36px;width:auto;max-width:150px;object-fit:contain}
        .stage-cap{display:none}

        /* ============ RIGHT: form ============ */
        .panel{position:relative;z-index:2;margin-top:-28px;border-radius:28px 28px 0 0;background:var(--cream);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:44px 22px 40px}
        .back{position:absolute;top:20px;right:20px;display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:999px;background:var(--glass);border:1px solid rgba(18,16,14,.08);font-size:13px;font-weight:500;transition:background .25s,color .25s}
        .back:hover{background:var(--ink);color:#fff}
        .back svg{width:16px;height:16px}
        .card{width:100%;max-width:420px;margin-top:18px}
        .card h1{font-size:clamp(30px,5vw,40px);line-height:1.05;font-weight:600;letter-spacing:-.035em}
        .card .sub{margin:10px 0 28px;color:var(--muted);font-size:15px;line-height:1.5}
        form{display:flex;flex-direction:column;gap:20px}
        label.lbl{display:block;font-size:14px;font-weight:500;margin-bottom:6px}
        .row{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px}
        .row .lbl{margin-bottom:0}
        .forgot{font-size:14px;color:var(--plum);text-decoration:underline;text-underline-offset:4px;transition:color .2s}
        .forgot:hover{color:var(--hover)}

        .field{position:relative}
        .field .ic{position:absolute;left:16px;top:50%;transform:translateY(-50%);width:20px;height:20px;color:rgba(18,16,14,.35);pointer-events:none}
        .field input{width:100%;height:54px;border-radius:16px;border:1px solid var(--line);background:#fff;padding:0 16px 0 48px;font-size:16px;transition:border-color .2s,box-shadow .2s}
        .field input::placeholder{color:rgba(18,16,14,.3)}
        .field input:focus{outline:none;border-color:var(--plum);box-shadow:0 0 0 4px rgba(184,69,106,.15)}
        .field.has-error input{border-color:#f87171}
        .field.pw input{padding-right:56px}
        .eye{position:absolute;right:6px;top:50%;transform:translateY(-50%);width:40px;height:40px;border:0;border-radius:12px;background:transparent;color:var(--muted);display:grid;place-items:center;cursor:pointer;transition:background .2s,color .2s}
        .eye:hover{background:var(--cream);color:var(--plum)}
        .eye svg{width:20px;height:20px}
        .eye .off{display:none}
        .eye[aria-pressed="true"] .on{display:none}
        .eye[aria-pressed="true"] .off{display:block}
        .err{margin-top:6px;font-size:13px;color:#dc2626}
        .alert{border-radius:14px;padding:12px 14px;font-size:14px;line-height:1.4}
        .alert.bad{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c}
        .alert.ok{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}

        .remember{display:inline-flex;align-items:center;gap:12px;min-height:44px;cursor:pointer;user-select:none;font-size:14px;position:relative}
        .remember input{position:absolute;opacity:0;width:1px;height:1px}
        .remember .box{width:22px;height:22px;border-radius:6px;border:2px solid rgba(18,16,14,.25);background:#fff;display:grid;place-items:center;transition:background .2s,border-color .2s,box-shadow .2s}
        .remember .box svg{width:14px;height:14px;color:#fff;opacity:0;transition:opacity .15s}
        .remember input:checked+.box{background:var(--plum);border-color:var(--plum)}
        .remember input:checked+.box svg{opacity:1}
        .remember input:focus-visible+.box{box-shadow:0 0 0 4px rgba(91,26,74,.3)}

        .submit{width:100%;height:56px;border:0;border-radius:999px;background:var(--plum);color:var(--cream);font-size:16px;font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:12px;
                box-shadow:0 12px 24px -12px rgba(91,26,74,.6);transition:background .25s,transform .2s}
        .submit:hover{background:var(--hover);transform:translateY(-1px)}
        .submit:active{transform:scale(.99)}
        .submit:disabled{opacity:.7;cursor:wait}
        .spin{display:none;width:20px;height:20px;animation:spin .8s linear infinite}
        .submit.busy .spin{display:block}
        @keyframes spin{to{transform:rotate(360deg)}}

        .alt{margin-top:26px;text-align:center;font-size:14px;color:var(--muted)}
        .alt a{color:var(--plum);font-weight:500;text-decoration:underline;text-underline-offset:4px}
        .alt a:hover{color:var(--hover)}

        /* ============ DESKTOP: split screen ============ */
        @media (min-width:960px){
            .lg{grid-template-columns:1.05fr 1fr}
            .stage{position:sticky;top:0;height:100vh}
            .word{display:block;font-size:13vw}
            .oval{height:72%}
            .stage-cap{display:block;position:absolute;left:clamp(16px,3vw,40px);bottom:clamp(24px,5vh,48px);font-size:clamp(26px,2.6vw,40px);font-weight:600;letter-spacing:-.035em;line-height:1.05}
            .panel{margin-top:0;border-radius:0;padding:56px 40px}
            .back{top:28px;right:36px}
            .card{margin-top:0}
        }
        @media (prefers-reduced-motion:reduce){
            .oval video{display:none}
            .spin{animation:none}
            .submit,.back,.eye{transition:none}
=======
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
>>>>>>> Stashed changes
        }
    </style>
</head>

<body>
<?php
<<<<<<< Updated upstream
    $video = 'https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260713_234424_b1332b69-2e69-4302-8dbc-40f86846afbd.mp4';
?>

<div class="lg">

    
    <section class="stage" id="stage" aria-hidden="true">
        <span class="word" id="word">Al-Asra</span>

        <div class="oval">
            <div><video src="<?php echo e($video); ?>" autoplay loop muted playsinline preload="auto" onerror="this.style.display='none'"></video></div>
        </div>

        <a href="<?php echo e(url('/')); ?>" class="stage-logo" tabindex="-1"><img src="<?php echo e(asset('logo.png')); ?>" alt=""></a>
        <p class="stage-cap">Welcome back.</p>
    </section>

    
    <main class="panel">
        <a href="<?php echo e(url('/')); ?>" class="back">
            <svg aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m12 19-7-7 7-7M19 12H5"/></svg>Back to shop
        </a>

        <div class="card">
            <h1>Log in</h1>
            <p class="sub">Welcome back. Enter your details to continue.</p>

            <?php if(session('status')): ?>
                <div class="alert ok" style="margin-bottom:20px" role="status"><?php echo e(session('status')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert bad" style="margin-bottom:20px" role="alert"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('customer.login')); ?>" id="loginForm">
                <?php echo csrf_field(); ?>

                
                <div>
                    <label for="email" class="lbl">Email</label>
                    <div class="field <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                        <svg class="ic" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M4 7l8 6 8-6"/></svg>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                               autocomplete="username" inputmode="email" autocapitalize="none" spellcheck="false" placeholder="you@example.com"
                               <?php if($errors->has('email')): ?> aria-invalid="true" <?php endif; ?>>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="err"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <div class="row">
                        <label for="password" class="lbl">Password</label>
                        <?php if(Route::has('customer.password.request')): ?>
                            <a href="<?php echo e(route('customer.password.request')); ?>" class="forgot">Forgot password?</a>
                        <?php endif; ?>
                    </div>
                    <div class="field pw <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                        <svg class="ic" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="10" width="16" height="10" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"
                               <?php if($errors->has('password')): ?> aria-invalid="true" <?php endif; ?>>
                        <button type="button" class="eye" id="eye" aria-pressed="false" aria-label="Show password">
                            <svg class="on" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1.5 12S5.5 5 12 5s10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="off" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M17.9 17.9A10.6 10.6 0 0 1 12 19.5C5.5 19.5 1.5 12 1.5 12a18 18 0 0 1 4.6-5.4M9.9 4.7A10 10 0 0 1 12 4.5c6.5 0 10.5 7.5 10.5 7.5a18 18 0 0 1-2.1 3M1 1l22 22"/></svg>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="err"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <label class="remember">
                    <input type="checkbox" name="remember" <?php if(old('remember')): echo 'checked'; endif; ?>>
                    <span class="box"><svg fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12l5 5L20 6"/></svg></span>
                    <span>Keep me logged in</span>
                </label>

                
                <button type="submit" class="submit" id="submitBtn">
                    <svg class="spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                    <span id="submitTxt">Log in</span>
                </button>
            </form>

            <?php if(Route::has('customer.register')): ?>
                <p class="alt">New here? <a href="<?php echo e(route('customer.register')); ?>">Create an account</a></p>
            <?php endif; ?>
        </div>
    </main>
=======
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

<?php
    // Shared input style (padding is set per input so the leading icon has room)
    $input = 'w-full h-[54px] rounded-2xl border bg-white pl-12 pr-4 text-base placeholder:text-black/30 focus:outline-none focus:border-plum focus:ring-4 focus:ring-rose/15 transition';
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

        <form method="POST" action="<?php echo e(route('customer.login')); ?>" x-data="{ show:false, busy:false }" @submit="busy = true" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    
                    <div>
                        <label for="email" class="block text-sm font-medium mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-black/35 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M4 7l8 6 8-6"/></svg>
                            </span>
                            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                                autocomplete="username" inputmode="email" autocapitalize="none" spellcheck="false" placeholder="you@example.com"
                                class="<?php echo e($input); ?> <?php echo e($errors->has('email') ? 'border-red-400' : 'border-black/15'); ?>">
                        </div>
                    </div>

                    
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium">Password</label>
                            <a href="<?php echo e(route('customer.password.request')); ?>" class="text-sm text-plum underline underline-offset-4 hover:text-rose transition">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-black/35 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="10" width="16" height="10" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                            </span>
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required
                                autocomplete="current-password" placeholder="Enter your password"
                                class="<?php echo e($input); ?> !pr-14 <?php echo e($errors->has('password') ? 'border-red-400' : 'border-black/15'); ?>">
                            <button type="button" @click="show = !show" :aria-pressed="show" :aria-label="show ? 'Hide password' : 'Show password'"
                                    class="absolute right-1.5 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl flex items-center justify-center text-muted hover:text-plum hover:bg-cream transition focus:outline-none focus-visible:ring-4 focus-visible:ring-plum/30">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1.5 12S5.5 5 12 5s10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-cloak x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M17.9 17.9A10.6 10.6 0 0 1 12 19.5C5.5 19.5 1.5 12 1.5 12a18 18 0 0 1 4.6-5.4M9.9 4.7A10 10 0 0 1 12 4.5c6.5 0 10.5 7.5 10.5 7.5a18 18 0 0 1-2.1 3M1 1l22 22"/></svg>
                            </button>
                        </div>
                    </div>

                    
                    <label class="relative inline-flex items-center gap-3 cursor-pointer select-none min-h-[44px]">
                        <input type="checkbox" name="remember" class="peer sr-only" <?php if(old('remember')): echo 'checked'; endif; ?>>
                        <span class="w-[22px] h-[22px] rounded-md border-2 border-black/25 bg-white flex items-center justify-center transition peer-checked:bg-plum peer-checked:border-plum peer-focus-visible:ring-4 peer-focus-visible:ring-plum/30">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12l5 5L20 6"/></svg>
                        </span>
                        <span class="text-sm">Keep me logged in</span>
                    </label>

                    
                    <button type="submit" :disabled="busy"
                            class="w-full h-[56px] flex items-center justify-center gap-3 bg-plum text-cream rounded-full font-medium text-base shadow-[0_12px_24px_-12px_rgba(91,26,74,.6)] hover:bg-ink hover:-translate-y-px active:translate-y-0 active:scale-[.99] disabled:opacity-70 disabled:cursor-wait transition focus:outline-none focus-visible:ring-4 focus-visible:ring-plum/30">
                        <svg x-cloak x-show="busy" class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                        <span x-text="busy ? 'Logging in…' : 'Log in'">Log in</span>
                    </button>
                </form>
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
>>>>>>> Stashed changes
</div>

<script>
(function () {
<<<<<<< Updated upstream
    // show / hide password
    var pw = document.getElementById('password'), eye = document.getElementById('eye');
    eye.addEventListener('click', function () {
        var show = pw.type === 'password';
        pw.type = show ? 'text' : 'password';
        eye.setAttribute('aria-pressed', String(show));
        eye.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    });

    // busy state on submit (the form still submits normally)
    var form = document.getElementById('loginForm'), btn = document.getElementById('submitBtn'), txt = document.getElementById('submitTxt');
    form.addEventListener('submit', function () {
        btn.classList.add('busy'); btn.disabled = true; txt.textContent = 'Logging in…';
    });
    // if the user comes back via the browser's back button, reset the button
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) { btn.classList.remove('busy'); btn.disabled = false; txt.textContent = 'Log in'; }
    });

    // stretch the faded word behind the video to fill the stage height (like the 404 page)
    var stage = document.getElementById('stage'), word = document.getElementById('word');
    function fit() {
        if (!word.offsetHeight) return;
        var y = (stage.clientHeight / word.offsetHeight) * 1.25;
        stage.style.setProperty('--y', String(Math.min(y, 3.4)));
    }
    word.parentNode.style.setProperty('--y', '1.6');
    word.style.transform = 'translate(-50%,-50%) scaleY(var(--y))';
=======
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

>>>>>>> Stashed changes
    fit();
    window.addEventListener('resize', fit);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(fit);
    setTimeout(fit, 300);
<<<<<<< Updated upstream
=======

    btn.addEventListener('click', function () { setOpen(true); });
    document.getElementById('nfClose').addEventListener('click', function () { setOpen(false); });
    document.getElementById('nfBack').addEventListener('click', function () { setOpen(false); });
    ov.querySelectorAll('.nf-items a, .nf-pb a').forEach(function (a) { a.addEventListener('click', function () { setOpen(false); }); });
    window.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
>>>>>>> Stashed changes
})();
</script>
</body>
</html><?php /**PATH D:\laragon\www\al-asra-online-website\resources\views/customer/auth/login.blade.php ENDPATH**/ ?>