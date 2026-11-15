<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Log in | Al-Asra</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">

        <style>
            /* ---- brand colours: edit these to match the storefront ---- */
            :root{
                --plum:#5B1A4A;      /* primary (button, links, focus) */
                --rose:#B8456A;      /* hover / focus glow */
                --cream:#F7F0E6;     /* form side background */
                --stage:#EEE4D6;     /* video side background */
                --num:#E2D6C5;       /* giant faded word behind the video */
                --ink:#12100E;
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
            .forgot:hover{color:var(--rose)}

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
            .submit:hover{background:var(--ink);transform:translateY(-1px)}
            .submit:active{transform:scale(.99)}
            .submit:disabled{opacity:.7;cursor:wait}
            .spin{display:none;width:20px;height:20px;animation:spin .8s linear infinite}
            .submit.busy .spin{display:block}
            @keyframes spin{to{transform:rotate(360deg)}}

            .alt{margin-top:26px;text-align:center;font-size:14px;color:var(--muted)}
            .alt a{color:var(--plum);font-weight:500;text-decoration:underline;text-underline-offset:4px}
            .alt a:hover{color:var(--rose)}

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
            }
        </style>
    </head>

    <body>
        @php
            $video = 'https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260713_234424_b1332b69-2e69-4302-8dbc-40f86846afbd.mp4';
        @endphp

        <div class="lg">

            {{-- ============ LEFT: video ============ --}}
            <section class="stage" id="stage" aria-hidden="true">
                <span class="word" id="word">Al-Asra</span>

                <div class="oval">
                    <div><video src="{{ $video }}" autoplay loop muted playsinline preload="auto" onerror="this.style.display='none'"></video></div>
                </div>

                <a href="{{ url('/') }}" class="stage-logo" tabindex="-1"><img src="{{ asset('logo.png') }}" alt=""></a>
                <p class="stage-cap">Welcome back.</p>
            </section>

            {{-- ============ RIGHT: login ============ --}}
            <main class="panel">
                <a href="{{ url('/') }}" class="back">
                    <svg aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m12 19-7-7 7-7M19 12H5"/></svg>Back to shop
                </a>

                <div class="card">
                    <h1>Log in —  Admin</h1>
                    <p class="sub">Welcome back. Enter your details to continue.</p>

                    @if(session('status'))
                        <div class="alert ok" style="margin-bottom:20px" role="status">{{ session('status') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert bad" style="margin-bottom:20px" role="alert">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" @submit="loading = true" novalidate id="loginForm">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="lbl">Email</label>
                            <div class="field {{ $errors->has('email') ? 'has-error' : '' }}">
                                <svg class="ic" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M4 7l8 6 8-6"/></svg>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                    autocomplete="username" inputmode="email" autocapitalize="none" spellcheck="false" placeholder="you@example.com"
                                    @if($errors->has('email')) aria-invalid="true" @endif>
                            </div>
                            @error('email')<p class="err">{{ $message }}</p>@enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="row">
                                <label for="password" class="lbl">Password</label>
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot">Forgot password?</a>
                                @endif
                            </div>
                            <div class="field pw {{ $errors->has('password') ? 'has-error' : '' }}">
                                <svg class="ic" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="10" width="16" height="10" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"
                                    @if($errors->has('password')) aria-invalid="true" @endif>
                                <button type="button" class="eye" id="eye" aria-pressed="false" aria-label="Show password">
                                    <svg class="on" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1.5 12S5.5 5 12 5s10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg class="off" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M17.9 17.9A10.6 10.6 0 0 1 12 19.5C5.5 19.5 1.5 12 1.5 12a18 18 0 0 1 4.6-5.4M9.9 4.7A10 10 0 0 1 12 4.5c6.5 0 10.5 7.5 10.5 7.5a18 18 0 0 1-2.1 3M1 1l22 22"/></svg>
                                </button>
                            </div>
                            @error('password')<p class="err">{{ $message }}</p>@enderror
                        </div>

                        {{-- Remember me --}}
                        <label class="remember">
                            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                            <span class="box"><svg fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12l5 5L20 6"/></svg></span>
                            <span>Keep me logged in</span>
                        </label>

                        {{-- Submit --}}
                        <button type="submit" class="submit" id="submitBtn">
                            <svg class="spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                            <span id="submitTxt">Log in</span>
                        </button>
                    </form>

                </div>
            </main>
        </div>

        <script>
            (function () {
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
                fit();
                window.addEventListener('resize', fit);
                if (document.fonts && document.fonts.ready) document.fonts.ready.then(fit);
                setTimeout(fit, 300);
            })();
        </script>
    </body>
</html>