## 사용 가이드라인 📋

- config/env.php를 통해 DB ip와 id,pw 입력
- ID : test3, PW : 1026 으로 로그인
- ALL MATCHES => 모든 스케줄 보기. VIEW_RESULT => 각 경기의 기록 보기/입력
- 필드 경기 중에 높이뛰기, 장대높이뛰기를 제외한 경기에서 3차시기 와 5차시기 이후 순서 변경 로직
- _높이뛰기, 장대 높이 뛰기 입력로직이 아직 미흡함. 개선요망_

## 소개 💁‍♂️

U20 아시아 세계선수권 운영 시, 심판진분들께서 입력하실 때 쓰는 시스템입니다.

## 시스템 시퀀스 다이어그램 💡

<p align="center">
  <img src="https://user-images.githubusercontent.com/75259783/216961152-dff1a093-ec73-4765-a70d-2047a57a1057.png">
</p>

## 결과 보기 클래스 다이어그램 📋

<p align="center">
  <img src="https://user-images.githubusercontent.com/75259783/217498463-b1fd4beb-9faa-4151-843e-efc80fab34c3.png">
</p>

## 결과 입력 클래스 다이어그램 📋

<p align="center">
  <img src="https://user-images.githubusercontent.com/75259783/217498484-c4abbcae-8fa4-441d-9bb2-7661339ca43f.png">
</p>

## 기능요구사항 🎯

### 로그인 페이지

- [x] 로그인 UI 구현

### 스케줄

- [x] 각 스케줄 페이지에 h1 추가
- [x] 심판의 일정에 따른 경기 보기
- [x] 비고 보기 & 추가

### 결과 보기

- [x] 각 결과 페이지에 h1 추가
- [x] 경기 카테고리에 따른 View 구현
  - [x] 일반트랙 // track
  - [x] 릴레이(트랙) // relay
  - [x] 일반필드 // field
  - [x] 멀리뛰기, 삼단뛰기 // long\*jump
  - [x] 높이뛰기, 장대 높이 뛰기 // high_jump
- [x] 경기 상태에 따른 입력 제한

### 결과 입력

- [x] 각 결과 입력 페이지에 h1 추가
- [x] 경기 카테고리에 따른 View 구현
  - [x] 일반트랙 // track
  - [x] 릴레이(트랙) // relay
  - [x] 일반필드 // field
  - [x] 멀리뛰기, 삼단뛰기 // long\*jump
  - [x] 높이뛰기, 장대 높이 뛰기 // high_jump
- [ ] 경기 카테고리에 따른 입력 로직 구현
  - [x] 일반트랙 // track
  - [x] 릴레이(트랙) // relay
  - [x] 일반필드 // field
  - [x] 멀리뛰기, 삼단뛰기 // long\*jump
  - [ ] 높이뛰기, 장대 높이 뛰기 // high_jump
- [ ] 입력/수정에 따른 로그 남기기

### 보안

- [x] 본인의 스케줄 페이지가 아니면 접근 제한
- [x] URL 직접 접근 제한
- [x] 이전 세션과 다른 경우 접근 제한

## 코딩 요구사항 🙏

- MVC 모델을 지양하되, MV 정도는 허용됨
- 클래스 사용하지 말 것
- OOP의 5가지 원칙을 최대한 지켜줄 것 (나중에 수정이 어려움)

## 변수 네이밍 규칙 📋

- 파라미터 및 변수 : GNU Naming Convention(==snake case) ( this_is_gnu_naming_convention )
- 함수명 : [Dromedary](https://en.wikipedia.org/wiki/Dromedary) ( thisIsDromedaryCamelCase )

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

## 결과 입력 구조 & 네이밍 📋

- track : 일반트랙
- relay : 릴레이(트랙)
- field : 일반필드
- long\*jump : 멀리뛰기, 삼단뛰기
- high_jump : 높이뛰기, 장대 높이 뛰기
- three_try_after_reverse : 필드 경기 중에 높이뛰기, 장대높이뛰기를 제외한 경기에서 3차시기 와 5차시기 이후 순서 변경 로직
