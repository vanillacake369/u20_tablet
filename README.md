## 소개 💁‍♂️

U20 아시아 세계선수권 운영 시, 심판진분들께서 입력하실 때 쓰는 시스템입니다.

## 시스템 시퀀스 다이어그램
<p align="center">
  <img src="https://user-images.githubusercontent.com/75259783/216961152-dff1a093-ec73-4765-a70d-2047a57a1057.png">
</p>

## 기능요구사항
- [ ] ㅁㄴㅇ

## 커밋 메시지 규칙 💬

> 커밋 메세지는 세개의 다른 구조로 이루어져있으며 공백으로 이루어진 행으로 구분된다.
>
> 구조는 제목 / 본문 / 꼬리말로 구성되며 레이아웃은 다음과 같다.
>
> type: Subject
>
> body
>
> footer
>
> 타이틀은 메세지의 type과 제목을 포함한다.
>
> - feat: 새로운 기능 추가 (A new features)
> - fix: 버그 수정 (A bug fix)
> - docs: 문서 수정 (Changes to documentation)
>   style: 코드 포맷팅, 세미콜론 누락, 코드 변경이 없는 경우 (Formatting, missing semi colons, etc; no code change)
> - refactor: 코드 리팩토링 (Refactoring production code)
> - test: 테스트 코드, 리팩토링 테스트 코드 추가 (Adding tests, refactoring test; no production code change)
> - chore: 빌드 업무 수정, 패키지 매니저 수정 (Updating build tasks, package manager configs, etc; no production code change)

## 변수 네이밍 규칙 📋

- 파라미터 및 변수 : GNU Naming Convention(==snake case) ( this_is_gnu_naming_convention )
- 함수명 : [Dromedary](https://en.wikipedia.org/wiki/Dromedary) ( thisIsDromedaryCamelCase )

## 코딩 요구사항 🙏

- MVC 모델을 지양하되, MV 정도는 허용됨
- 클래스 사용하지 말 것
- OOP의 5가지 원칙을 최대한 지켜줄 것 (나중에 수정이 어려움)

## 결과 입력 구조 & 네이밍 📋
> sendResult (x)
- 1 : 일반트랙 // track
  - view*
  - input*
- 2 : 릴레이(트랙) // relay
  - view*
  - input*
- 3 : 일반필드 // field
  - view*
  - input*
- 4 : 멀리뛰기, 삼단뛰기 // long*jump
  - view*
  - input*
- 5 : 높이뛰기, 장대 높이 뛰기 // high_jump
  - view*
  - input\_
- three_try_after_reverse : 필드 경기 중에 높이뛰기, 장대높이뛰기를 제외한 경기에서 3차시기 와 5차시기 이후 순서 변경 로직

### 로직 처리

- 데이터베이스에 있는 데이터 가져오는 로직 :: model/
- 입력로직 :: model/model_result/

```php
// live 이면
if ($row["schedule_result"] === "l") {
echo "<td>" . htmlspecialchars($row["record_live_record"]) . "</td>";
echo "<td>Live Result</td>";
// 카테고리 분류
if ($row["sports_category"] === "트랙경기") {
// 트랙 경기 > 100m, 400m 이면
if ($row["schedule_sports"] === "4x100mR" || $row["schedule_sports"] === "4x400mR") {
// 트랙경기 > 100m, 400m 핸들링 a 태그 출력
```
