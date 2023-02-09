<!DOCTYPE html>
<html lang="en">

<head>
    <title>U20 TABLET SYSTEM</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css" />
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" type="text/css" href="css/util.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <meta name="robots" content="noindex, follow" />
    <script nonce="295bfded-e0fa-4114-ba24-95f5f1dad738">
        (function(w, d) {
            !(function(f, g, h, i) {
                f[h] = f[h] || {};
                f[h].executed = [];
                f.zaraz = {
                    deferred: [],
                    listeners: [],
                };
                f.zaraz.q = [];
                f.zaraz._f = function(j) {
                    return function() {
                        var k = Array.prototype.slice.call(arguments);
                        f.zaraz.q.push({
                            m: j,
                            a: k,
                        });
                    };
                };
                for (const l of ["track", "set", "debug"]) f.zaraz[l] = f.zaraz._f(l);
                f.zaraz.init = () => {
                    var m = g.getElementsByTagName(i)[0],
                        n = g.createElement(i),
                        o = g.getElementsByTagName("title")[0];
                    o && (f[h].t = g.getElementsByTagName("title")[0].text);
                    f[h].x = Math.random();
                    f[h].w = f.screen.width;
                    f[h].h = f.screen.height;
                    f[h].j = f.innerHeight;
                    f[h].e = f.innerWidth;
                    f[h].l = f.location.href;
                    f[h].r = g.referrer;
                    f[h].k = f.screen.colorDepth;
                    f[h].n = g.characterSet;
                    f[h].o = new Date().getTimezoneOffset();
                    if (f.dataLayer)
                        for (const s of Object.entries(
                                Object.entries(dataLayer).reduce((t, u) => ({
                                    ...t[1],
                                    ...u[1],
                                }))
                            ))
                            zaraz.set(s[0], s[1], {
                                scope: "page",
                            });
                    f[h].q = [];
                    for (; f.zaraz.q.length;) {
                        const v = f.zaraz.q.shift();
                        f[h].q.push(v);
                    }
                    n.defer = !0;
                    for (const w of [localStorage, sessionStorage])
                        Object.keys(w || {})
                        .filter((y) => y.startsWith("_zaraz_"))
                        .forEach((x) => {
                            try {
                                f[h]["z_" + x.slice(7)] = JSON.parse(w.getItem(x));
                            } catch {
                                f[h]["z_" + x.slice(7)] = w.getItem(x);
                            }
                        });
                    n.referrerPolicy = "origin";
                    n.src =
                        "/cdn-cgi/zaraz/s.js?z=" +
                        btoa(encodeURIComponent(JSON.stringify(f[h])));
                    m.parentNode.insertBefore(n, m);
                };
                ["complete", "interactive"].includes(g.readyState) ?
                    zaraz.init() :
                    f.addEventListener("DOMContentLoaded", zaraz.init);
            })(w, d, "zarazData", "script");
        })(window, document);
    </script>
</head>

<body>
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100" style="padding-bottom: 10rem;">
                <div class="login">
                    <a href=""><img src="img/logo.png" alt="Logo" class="logo_img_login" /></a>
                    <form method="post" action="./auth/signIn.php">
                        <div class="login_pannel">
                            <div class="login_pannel_inner">
                                <div class="id_pw_wrap">
                                    <div class="input_row">
                                        <input type="text" id="id" class="input_text" name="id" placeholder="아이디" required />
                                    </div>
                                    <div class="input_row">
                                        <input type="password" id="pw" class="input_text" name="pw" placeholder="비밀번호" required />
                                    </div>
                                </div>
                                <div class="keep"></div>
                                <button type="submit" class="btn_login" name="login">
                                    <span class="btn_text">로그인</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>