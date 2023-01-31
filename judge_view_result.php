<?php
// URL 입력 접근 제어
if ($_SERVER['HTTP_REFERER'] == '') {
  exit("<script>alert('잘못된 접근입니다.');window.close();</script>");
  ini_set('display_errors', '0');
}
// DB
include_once "./database/dbconnect.php";
// 구현 요망
// Auth Check
// Get Schedules of Judge By Session
// Check Schedules of Judge Of DB
// Compare Schedules


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Table V02</title>
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

<?php

?>

<body>
  <!-- header -->
  <?php include 'header.php' ?>

  <div class="limiter">
    <div class="container-table100">
      <div class="wrap-table100">
        <!-- 경기 관련 내용 View 테이블 -->
        <div class="table-wrap">
          <table>
            <colgroup>
              <col style="width: auto" />
            </colgroup>
            <thead>
              <tr>
                <th>종목명</th>
                <th>경기명</th>
                <th>경기 성별</th>
                <th>날짜</th>
                <th>시작시간</th>
                <th>라운드</th>
                <th>심판명</th>
                <th>역할</th>
                <th>비고</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>트랙경기</td>
                <td>400m 달리기</td>
                <td>혼성</td>
                <td>MM.DD</td>
                <td>hh:mm:ss</td>
                <td>결승</td>
                <td>ITO</td>
                <td>국제기술임원</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- 결과 기록 Input 테이블 -->
        <!-- 
            <div class="table">
              <div class="row header">
                <div class="cell">순위</div>
                <div class="cell">선수명</div>
                <div class="cell">성별</div>
                <div class="cell">레인번호</div>
                <div class="cell">국가</div>
                <div class="cell">기록</div>
                <div class="cell">통과</div>
                <div class="cell">상태</div>
                <div class="cell">입력</div>
                <div class="cell">비고</div>
            </div>
            </div> 
            <div class="row">
              <div class="cell">2023-06-05</div>
              <div class="cell">100m 단거리</div>
              <div class="cell">남자</div>
              <div class="cell">13:40:21</div>
              <div class="cell">예선</div>
              <div class="cell">공식 결과(or 실시간)</div>
              <div class="cell">버튼</div>
            </div>
        
        -->
        <div class="table-wrap">
          <table>
            <colgroup>
              <col style="width: auto" />
            </colgroup>
            <thead>
              <tr>
                <th>순위</th>
                <th>선수명</th>
                <th>성별</th>
                <th>레인번호</th>
                <th>국가</th>
                <th>기록</th>
                <th>통과</th>
                <th>상태</th>
                <th>입력</th>
                <th>비고</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jinho KIM</td>
                <td>Male</td>
                <td>3</td>
                <td>Korea</td>
                <td>00:01:23</td>
                <td>O</td>
                <td>Live</td>
                <td>Button</td>
                <td></td>
              </tr>
            </tbody>
          </table>
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