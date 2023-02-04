## 소개 💁‍♂️

U20 아시아 세계선수권 운영 시, 심판진분들께서 입력하실 때 쓰는 시스템입니다.

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
