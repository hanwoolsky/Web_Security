# 1_vulnerable-app — 취약한 PHP 웹 애플리케이션

> ⚠️ **이 앱은 보안 학습 목적으로 의도적으로 취약하게 개발한 실습 환경입니다.**  
> 실제 서비스 환경에 절대 배포하지 마세요.

## 개발 의도

"개발할 줄 알아야 뚫을 수 있다"는 관점에서 직접 PHP 웹 애플리케이션을 개발했습니다.  
단순히 도구로 스캔하는 것이 아니라, **코드 수준에서 취약점이 어떻게 만들어지는지** 이해하기 위해 취약한 버전을 먼저 구현했습니다.

## 포함된 취약점 (의도적)

| 취약점 | OWASP | 파일 | 설명 |
|---|---|---|---|
| SQL Injection | A03:2021 | `auth/login.php` | 입력값이 쿼리에 직접 삽입됨 |
| SQL Injection | A03:2021 | `mypage/mypage_update.php` | 정보수정 쿼리 전체 미검증 |
| XSS (Stored) | A03:2021 | `board/board_create.php` | 게시글 내용 그대로 DB 저장 |
| CSRF | A01:2021 | `mypage/mypage_update.php` | 토큰 없이 정보수정 요청 처리 |
| File Upload | A04:2021 | `board/board_create.php` | 확장자 검증 없이 파일시스템 저장 |
| 불충분한 인증 | A07:2021 | `board/read.php` | 세션 없이 URL 직접 접근 가능 |
| 불충분한 인가 | A01:2021 | `board/board_update.php` | 작성자 검증 없이 타인 게시물 수정 가능 |
| IDOR | A01:2021 | `board/likes.php` | GET 파라미터로 타인 좋아요 조작 가능 |
| 세션 종료 미흡 | A07:2021 | `index.php` | 로그아웃 시 세션 쿠키 미만료 |

## 실행 방법

루트 디렉토리에서 → [README.md 실행 방법 참고](../README.md#실행-방법)

## 다음 단계

이 앱에 포함된 취약점의 공격 방법 → [2_exploits](../2_exploits/README.md)  
시큐어 코딩으로 패치된 버전 → [3_secure-app](../3_secure-app/README.md)