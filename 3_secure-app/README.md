# 3_secure-app — 시큐어 코딩 적용 버전

`1_vulnerable-app`에서 발견된 취약점들을 OWASP 기준에 따라 패치한 버전입니다.  
각 파일에 `[VULNERABLE]` / `[SECURE]` 주석으로 변경 전후를 명시했습니다.

## 패치 요약 & OWASP 매핑

---

### SQL Injection

**파일**: `login.php`, `signup.php`, `board_create.php` 外  
**OWASP**: A03:2021 Injection

```php
// [VULNERABLE] 입력값이 쿼리에 직접 삽입
$sql = "SELECT * FROM login WHERE id='" . $_POST['id'] . "'";
$result = $conn->query($sql);

// [SECURE] Prepared Statement 사용
$sql = "SELECT * FROM login WHERE login_id = ? AND login_pw = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $_POST['id'], $_POST['pw']);
$stmt->execute();
$result = $stmt->get_result();
```

핵심: 입력값을 쿼리 구조와 분리. `?` 플레이스홀더에 바인딩하면 어떤 입력이 들어와도 데이터로만 취급됩니다.

---

### XSS

**파일**: `read.php`, `qna_read.php`  
**OWASP**: A03:2021 Injection

```php
// [VULNERABLE] DB에서 꺼낸 값을 그대로 출력
echo $row['content'];

// [SECURE] 출력 시 HTML Entity 변환
echo htmlentities($row['content'], ENT_QUOTES, 'UTF-8');
```

`htmlentities()`로 `<`, `>`, `"`, `'` 등을 Entity로 치환해 스크립트로 해석되지 않게 합니다.  
입력 시 변환보다 **출력 시 변환**이 더 안전합니다 (이중 인코딩 문제 방지).

---

### CSRF

**파일**: `board_delete.php`, `mypage_update.php`, `likes.php`  
**OWASP**: A01:2021 Broken Access Control

```php
// [VULNERABLE] 토큰 검증 없이 요청 처리
if ($_SESSION['id']) {
    $conn->query("DELETE FROM board WHERE id=" . $_POST['id']);
}

// [SECURE] CSRF 토큰 검증 추가
session_start();
// 토큰 생성 (폼 출력 시)
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// 토큰 검증 (요청 처리 시)
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    exit('Invalid CSRF token');
}
```

---

### File Upload

**파일**: `write.php`  
**OWASP**: A04:2021 Insecure Design

```php
// [VULNERABLE] 확장자 검증 없이 업로드
move_uploaded_file($_FILES['file']['tmp_name'], './uploads/' . $_FILES['file']['name']);

// [SECURE] 화이트리스트 확장자 검증 + 저장 경로 분리
$allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt'];
$ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed_ext)) {
    exit('허용되지 않은 파일 형식입니다.');
}

// 파일명을 UUID로 변경해 원본명 노출 방지
$new_filename = bin2hex(random_bytes(16)) . '.' . $ext;

// 웹 경로 외부에 저장 (URL로 직접 접근 불가)
$upload_dir = '/var/uploads/';   // 웹루트 밖
move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . $new_filename);

// DB에 파일 ID와 경로만 저장
$sql = "INSERT INTO files (file_id, original_name, stored_name) VALUES (?, ?, ?)";
```

---

### File Download (Path Traversal) {#file-download}

**파일**: `file_download.php`  
**OWASP**: A04:2021 Insecure Design

```php
// [VULNERABLE] 경로 검증 없이 파일 반환
$filepath = './uploads/' . $_GET['filename'];
readfile($filepath);

// [SECURE] DB에서 파일 ID로 경로를 조회 (직접 경로 입력 불가)
$file_id = intval($_GET['file_id']);
$sql = "SELECT stored_name, original_name FROM files WHERE file_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $file_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

$filepath = '/var/uploads/' . $row['stored_name'];
if (!file_exists($filepath)) exit('파일 없음');

header('Content-Disposition: attachment; filename="' . $row['original_name'] . '"');
readfile($filepath);
```

---

### 인증 / 인가 (Auth Bypass) {#auth-bypass}

**파일**: `read.php`, `board_delete.php`, `qna_read.php`  
**OWASP**: A07:2021 Identification and Authentication Failures

```php
// [VULNERABLE] 세션 검증 없음
$id = $_GET['id'];
$sql = "SELECT * FROM board WHERE id=$id";

// [SECURE] 세션 검증 + 작성자 확인 추가
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    exit;
}

// 인가: 본인 게시물만 삭제 가능
$sql = "DELETE FROM board WHERE id = ? AND writer = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $_POST['id'], $_SESSION['id']);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    exit('권한이 없습니다.');
}
```

---

### 세션 관리 {#session}

**파일**: `cookie.php` (로그아웃 처리)  
**OWASP**: A07:2021

```php
// [VULNERABLE] 세션 변수만 삭제
unset($_SESSION['id']);

// [SECURE] 세션 완전 종료
session_start();
$_SESSION = [];
session_destroy();

// 세션 쿠키 만료 처리
setcookie(session_name(), '', time() - 3600, '/');
header('Location: login.html');
```

---

### 디렉토리 / 시스템 정보 노출 {#directory}

**Apache 설정 변경**

```apache
# [VULNERABLE] apache2.conf 기본값
Options Indexes FollowSymLinks

# [SECURE] 디렉토리 목록 비활성화
Options -Indexes

# 에러 메시지에서 서버 정보 숨기기
ServerSignature Off
ServerTokens Prod
```

---

## 패치 전후 비교 요약

| 취약점 | 패치 방법 | 핵심 원칙 |
|---|---|---|
| SQL Injection | Prepared Statement | 입력값을 코드와 분리 |
| XSS | htmlentities() | 출력 시 인코딩 |
| CSRF | CSRF 토큰 | 요청 출처 검증 |
| File Upload | 화이트리스트 + 경로 분리 | 업로드 파일 실행 차단 |
| 인증 미흡 | 서버 측 세션 검증 | 모든 요청마다 인증 확인 |
| 인가 미흡 | 작성자 조건 추가 | 자기 자원만 조작 가능 |
| 세션 종료 | session_destroy() | 세션 완전 무효화 |
| 디렉토리 노출 | Apache Options -Indexes | 불필요한 정보 차단 |

## 참고

- 블로그 시큐어 코딩 시리즈: https://hanuscrypto.tistory.com/category/WEB%20HACKING/%EC%9B%B9%20%ED%95%B4%ED%82%B9%5B%EC%8B%A4%EC%8A%B5%5D
- 모의해킹 보고서 권고안 → [4_pentest-reports](../4_pentest-reports/README.md)
