# 1_vulnerable-app — 취약한 PHP 웹 애플리케이션

> ⚠️ **이 앱은 보안 학습 목적으로 의도적으로 취약하게 개발한 실습 환경입니다.**  
> 실제 서비스 환경에 절대 배포하지 마세요.

## 개발 의도

"개발할 줄 알아야 뚫을 수 있다"는 관점에서 직접 PHP 웹 애플리케이션을 개발했습니다.  
단순히 도구로 스캔하는 것이 아니라, **코드 수준에서 취약점이 어떻게 만들어지는지** 이해하기 위해 취약한 버전을 먼저 구현했습니다.

## 포함된 취약점 (의도적)

| 파일 | 취약점 | 설명 |
|---|---|---|
| `login.php` | SQL Injection | 사용자 입력이 쿼리에 직접 삽입됨 |
| `signup.php` | SQL Injection | 회원가입 시 입력값 미검증 |
| `board_create.php` | Stored XSS | 게시글 내용 그대로 DB 저장 |
| `read.php` | Stored XSS | 저장된 스크립트 그대로 출력 |
| `board.php` | CSRF | 토큰 없이 상태 변경 요청 처리 |
| `file_download.php` | Path Traversal | 파일 경로 검증 없음 |
| `write.php` | File Upload | 업로드 확장자 무제한 허용 |
| `read.php` | 불충분한 인가 | 다른 사용자 게시물 접근 가능 |
| `mypage.php` | 불충분한 인증 | 세션 검증 미흡 |
| `cookie.php` | 세션 관리 미흡 | 세션 만료 처리 없음 |

## 앱 구성

```
index.php           메인 페이지
login.html          로그인 폼
login.php           로그인 처리 (SQL Injection 취약)
signup.html         회원가입 폼
signup.php          회원가입 처리
board.php           게시판 목록
board_create.php    게시글 작성 (XSS 취약)
board_update.php    게시글 수정
board_delete.php    게시글 삭제
read.php            게시글 읽기 (XSS 출력)
write.php           파일 업로드 (확장자 무제한)
file_view.php       파일 목록
file_download.php   파일 다운로드 (Path Traversal 취약)
file_delete.php     파일 삭제
qna.php             QnA 게시판
qna_create.php      QnA 작성
qna_read.php        QnA 읽기
qna_answer.php      답변 작성
qna_comment.php     댓글
qna_check.php       비밀번호 확인
qna_board.php       QnA 목록
qna_delete.php      QnA 삭제
mypage.php          마이페이지 (인증 취약)
mypage_update.php   정보 수정
address.php         주소 검색
cookie.php          쿠키/세션 처리
likes.php           좋아요
conn.php            DB 연결 설정
db.sql              DB 스키마
keylogger.html      XSS 키로거 PoC
keylogger.php       키로거 수신 서버
```

## 실행 방법

```bash
# MySQL DB 생성
mysql -u root -p < db.sql

# conn.php에서 DB 접속 정보 수정
# Apache/Nginx + PHP 환경에서 실행
```

## 다음 단계

이 앱에 포함된 취약점의 공격 방법 → [2_exploits](../2_exploits/README.md)  
시큐어 코딩으로 패치된 버전 → [3_secure-app](../3_secure-app/README.md)
