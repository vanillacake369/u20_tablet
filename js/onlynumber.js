// 경기 결과 숫자만 입력 및 자동 양식 스크립트
//트랙경기 포맷
function trackFinal(obj) {
  obj.value = comma(uncomma(obj.value));
  rankcal1();
}

//필드경기 포맷
function field1Format(obj) {
  if ((obj.value == "-" || obj.value == "X") && obj.value.length == 1) {
    // 실패한 경우
    rankcal();
  } else {
    obj.value = comma(uncomma(obj.value));
    fieldFinal(obj);
    rankcal();
  }
}

//멀리뛰기,삼단뛰기 전용 포맷
function field2Format(obj) {
  if ((obj.value == "-" || obj.value == "X") && obj.value.length == 1) {
    // 실패한 경우
    rankcal();
  } else {
    obj.value = comma(uncomma(obj.value));
    fieldFinal2(obj);
    rankcal();
  }
}

//필드 바람
function windFormat(obj) {
  obj.value = comma(uncomma1(obj.value));
}

//높이뛰기 높이 전용
function heightFormat(obj) {
  obj.value = comma(uncomma(obj.value));
}

function highFormat(obj) {
  obj.value = tftf(obj.value);
  const rain = obj.parentElement.parentElement.className.split("_")[1];

  if (obj.value.search("O") != -1) {
    //성공시 처리 부분
    let high = document.querySelectorAll('[name="trial[]"]'); // 높이 배열 가져오기
    let index = document.querySelectorAll("#result");
    let lo = obj.name;
    lo = lo.substring(lo.indexOf("t") + 1, lo.indexOf("[")); // 시도 위치 찾기
    if (
      parseFloat(index[rain - 1].value) < parseFloat(high[lo - 1].value) ||
      isNaN(parseFloat(index[rain - 1].value))
    ) {
      index[rain - 1].value = high[lo - 1].value; // 기존 값과 비교 후 성공 시 기록이 크면 바꾸기
    }
    rankcal2();
  }
}

function comma(str) {
  str = String(str);
  if (str.length < 5) {
    return str.replace(/(\B)(?=(?:\d{2})+(?!\d))/g, "$1.");
  } else {
    return str.replace(/(\d+)(\d{2})(\d{2})/g, "$1:$2.$3");
  }
}

function uncomma(str) {
  str = String(str);
  return str.replace(/[^\d]+/g, "");
}

function tftf(str) {
  str = String(str);
  str = str.toUpperCase();
  if (str.indexOf("-") >= 0) {
    if (str.indexOf("-") > str.indexOf("O") && str.indexOf("O") >= 0) {
      str = str.substring(0, str.indexOf("O") + 1);
    } else {
      str = str.substring(0, str.indexOf("-") + 1);
    }
  } else if (str.indexOf("O") >= 0) {
    str = str.substring(0, str.indexOf("O") + 1);
  }
  return str.replace(/[^-OX]+/g, "");
}

//바람전용
function uncomma1(str) {
  str = String(str);
  return str.replace(/[^-\d]+/g, "");
}

//실격횟수 카운트
function counting(str) {
  str = String(str);
  return (str.match(/X/g) || []).length;
}

//필드경기 최고결과
function fieldFinal(obj) {
  let top = "0";
  for (i = 3; i < 9; i++) {
    if (
      parseFloat(top) <
      parseFloat(
        obj.parentElement.parentElement.children[i].firstElementChild.value
      )
    ) {
      top = obj.parentElement.parentElement.children[i].firstElementChild.value;
    }
  }
  obj.parentElement.parentElement.children[9].firstElementChild.value = top;
}

// 멀리뛰기,삼단뛰기 경기에서 최고 기록 선정
function fieldFinal2(obj) {
  let top = "0";
  let wind = "";
  let a = obj.parentElement.parentElement;
  for (i = 3; i < 9; i++) {
    if (parseFloat(top) < parseFloat(a.children[i].firstElementChild.value)) {
      top = a.children[i].firstElementChild.value;

      wind = a.nextElementSibling.children[i - 3].firstElementChild.value;
      console.log(a.nextElementSibling.children[i - 3].firstElementChild);
    }
  }
  a.children[9].firstElementChild.value = top;
  a.nextElementSibling.children[6].firstElementChild.value = wind;
}

//등수 자동 배정 내림차순
function rankcal() {
  let re = document.querySelectorAll("#result"); //결과 요소 가져옴
  let ran = document.querySelectorAll("#rank"); //둥수 요소가져옴
  let arr1 = {};
  for (i = 0; i < re.length; i++) {
    let k = i;
    arr1[k] = re[i].value; //객체에 결과 저장
  }
  let keysSorted = Object.keys(arr1).sort(function (a, b) {
    return arr1[b] - arr1[a];
  }); //정렬
  for (i = 0; i < ran.length; i++) {
    ran[keysSorted[i]].value = i + 1; //등수대로 기입
  }
}

//등수 자동 배정 올림차순
function rankcal1() {
  let re = document.querySelectorAll("#result"); //결과 요소 가져옴
  let ran = document.querySelectorAll("#rank"); //둥수 요소가져옴
  let arr1 = {};
  for (i = 0; i < re.length; i++) {
    let k = i;
    arr1[k] = re[i].value; //객체에 결과 저장
  }
  let keysSorted = Object.keys(arr1).sort(function (a, b) {
    if (arr1[a] == "" || arr1[a] == "0") {
      return 1;
    }
    if (arr1[b] == "" || arr1[b] == "0") return -1;
    return parseInt(uncomma(arr1[a])) - parseInt(uncomma(arr1[b]));
  }); //올림차순 정렬
  for (i = 0; i < ran.length; i++) {
    ran[keysSorted[i]].value = i + 1; //등수대로 기입
  }
}

//높이뛰기 전용 등수계산
function rankcal2() {
  const results_obj = document.querySelectorAll("#result"); //결과 요소 가져옴
  const rank_obj = document.querySelectorAll("#rank"); //등수 요소 가져옴
  let athletes_info = [];
  for (let i = 0; i < results_obj.length; i++) {
    if (results_obj[i].value != undefined && results_obj[i].value != "") {
      athletes_info.push(get_athlete_history(i + 1, results_obj[i].value));
    }
  }
  sort_by_result(athletes_info); // 기록순으로 정렬
  for (let i = 0; i < athletes_info.length; i++) {
    // 등수 계산 시작
    let duplicate_record_count = 0;
    for (let j = i + 1; j < athletes_info.length; j++) {
      // 중복 최고기록 만큼 +1
      if (athletes_info[i][0].best_score == athletes_info[j][0].best_score)
        duplicate_record_count += 1;
    }
    if (duplicate_record_count == 0) continue; // 중복이 없으면 다시 반복문 진입

    let duplicate_athlete = athletes_info.splice(
      i,
      i + duplicate_record_count + 1
    );
    sort_by_latest_result(duplicate_athlete); // 동기록 정렬에 대한 함수
    let duplicate_trial_count = 0;
    for (let j = 0; j < duplicate_athlete.length; j++) {
      // 동기록의 동시기 확인
      for (let k = j + 1; k < duplicate_athlete.length; k++) {
        const first_athlete = duplicate_athlete[j].slice(-1);
        const second_athlete = duplicate_athlete[k].slice(-1);
        if (first_athlete.value == second_athlete.value)
          duplicate_trial_count += 1;
      }
      if (duplicate_trial_count == 0) continue; // 동시기가 없으면 다시 반복분 진입

      let duplicate_trial_athlete = duplicate_athlete.splice(
        j,
        j + duplicate_trial_count + 1
      );
      sort_by_total_result(duplicate_trial_athlete); // 동기록 동시기 기록 정렬에 대한 함수
      duplicate_athlete.splice(j, 0, ...duplicate_trial_athlete);
      j += duplicate_trial_count;
    }
    athletes_info.splice(i, 0, ...duplicate_athlete);
    i += duplicate_record_count;
  }

  let rank = 0;
  let stack = 0;
  let same_switch = false;
  athletes_info.forEach(function (athlete_info) {
    const pos = athlete_info[0].athlete_pos - 1;
    const same = athlete_info[0].best_score;

    if (same === "same" && !same_switch) {
      same_switch = true;
      rank += 1;
      rank_obj[pos].value = rank;
    } else if (same !== "same") {
      same_switch = false;
      rank += 1 + stack;
      stack = 0;
      rank_obj[pos].value = rank;
    } else if (same_switch) {
      rank_obj[pos].value = rank;
      stack += 1;
    }
  });
}

function get_athlete_history(athlete_pos, best_score) {
  const athlete_history_query =
    ".col1_" + athlete_pos + ", .col2_" + athlete_pos;
  const athlete_record_objs = document.querySelectorAll(athlete_history_query);
  const height_objs = document.querySelectorAll("#col1, #col2");
  let histories = [];

  for (let i = 3, j = 7; i < 26; i += 1, j += 1) {
    const history = athlete_record_objs[0].childNodes[i].childNodes[0].value;
    const height = height_objs[0].childNodes[j].childNodes[0].value;
    if (history == undefined || history == "") break;
    histories.push({
      athlete_pos: athlete_pos,
      height: height,
      result: history,
      best_score: best_score,
    });
  }

  for (let i = 0, j = 1; i < 24; i += 1, j += 1) {
    const history = athlete_record_objs[1].childNodes[i].childNodes[0].value;
    const height = height_objs[1].childNodes[j].childNodes[0].value;
    if (history == undefined || history == "") break;
    histories.push({
      athlete_pos: athlete_pos,
      height: height,
      result: history,
      best_score: best_score,
    });
  }
  return histories;
}

function sort_by_result(athletes_info) {
  for (let i = 0; i < athletes_info.length; i++) {
    for (let j = i + 1; j < athletes_info.length; j++) {
      if (
        athletes_info[i][0] != undefined &&
        athletes_info[j][0] != undefined &&
        athletes_info[i][0].best_score < athletes_info[j][0].best_score
      ) {
        const temp = athletes_info[i];
        athletes_info[i] = athletes_info[j];
        athletes_info[j] = temp;
      }
    }
  }
}

function sort_by_latest_result(athletes_info) {
  for (let i = 0; i < athletes_info.length; i++) {
    for (let j = i + 1; j < athletes_info.length; j++) {
      const first_athlete = (
        athletes_info[i].slice(-1)[0].result.match(/X/g) || []
      ).length;
      const second_athlete = (
        athletes_info[j].slice(-1)[0].result.match(/X/g) || []
      ).length;

      if (first_athlete > second_athlete) {
        const temp = athletes_info[i];
        athletes_info[i] = athletes_info[j];
        athletes_info[j] = temp;
      }
    }
  }
}

function sort_by_total_result(athletes_info) {
  let athlete_total_trial_count = [];
  athletes_info.forEach(function (athlete_histories) {
    // 전체 시도 횟수 저장
    let total_trial = 0;
    athlete_histories.forEach(function (record) {
      total_trial += (record.result.match(/X/g) || []).length;
    });
    athlete_total_trial_count.push({
      athlete_pos: athlete_histories[0].athlete_pos,
      total_trial: total_trial,
    });
  });
  for (let i = 0; i < athlete_total_trial_count.length; i++) {
    // 전체 시도 횟수가 적은 순서대로 정렬
    for (let j = i + 1; j < athlete_total_trial_count.length; j++) {
      if (
        athlete_total_trial_count[i].total_trial >
        athlete_total_trial_count[j].total_trial
      ) {
        const temp_athletes_info = athletes_info[i];
        athletes_info[i] = athletes_info[j];
        athletes_info[j] = temp_athletes_info;

        const temp_athlete_trial_info = athlete_total_trial_count[i];
        athlete_total_trial_count[i] = athlete_total_trial_count[j];
        athlete_total_trial_count[j] = temp_athlete_trial_info;
      } else if (
        athlete_total_trial_count[i].total_trial ==
        athlete_total_trial_count[j].total_trial
      ) {
        athletes_info[i][0].best_score = "same";
        athletes_info[j][0].best_score = "same";
      }
    }
  }
}
