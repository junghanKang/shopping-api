# 개요

이 프로젝트는 PHP와 Lumen 6.* 버전의 프레임워크 그리고 Mysql 8을 이용해 쇼핑 API 구현하는 프로젝트입니다.
Docker compose를 이용해 로컬 개발 환경 세팅과 함께 개발하였습니다.

## 테스트 환경
Docker Desktop 4.16.2 (Mac M1)


## 시작하기
이 프로젝트를 실행하기 위해서는 다음과 같은 절차를 따라주십시오.

1. 레포지토리 클론
```
git clone https://github.com/junghanKang/shopping-api.git

```

2. 프로젝트 디렉토리로 이동
```
cd shopping-api
```

3. docker compose 실행
```
docker compose up --build -d
```

4. 브라우저에서 http://localhost:8080를 입력하여 Lumen API에 접근할 수 있는지 확인

5. MySQL 리플리케이션을 위해 쉘 스트립트 실행 (TODO: 자동화 필요)
```
bash mysql/slave/entrypoint.sh
```

6. MySQL 테이블 생성 (TODO: 마이그레이션 세팅 필요)
```
docker compose exec mysql-master bash
mysql -ulumenuser -plumenuser commercedb
```
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(20) NOT NULL,
	nickname VARCHAR(30) NOT NULL,
	password VARCHAR(60) NOT NULL,
	phone VARCHAR(20) NOT NULL,
	email VARCHAR(20) NOT NULL,
	gender VARCHAR(6),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	UNIQUE KEY email_unique (email)
);

CREATE TABLE orders (
  order_number VARCHAR(12) PRIMARY KEY,
  product_name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  purchase_datetime DATETIME NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);


# if you want orders table data
INSERT INTO orders (order_number, product_name, purchase_datetime, user_id, created_at, updated_at)
VALUES
  ('ORD001', 'Product A', '2023-01-01 12:00:00', 1, NOW(), NOW()),
  ('ORD002', 'Product B', '2023-01-02 14:30:00', 1, NOW(), NOW());
```

## 사용방법
이 API는 아래와 같은 endpoint를 제공합니다:
(Postman과 같은 도구 추천: [다운로드](https://www.postman.com/downloads/))
### `POST /member/register`: 회원가입
```
http://localhost:8080/member/register
```
**params**
| Key      | Value |
| :--- | ---: |
| name      | john       |
| email   | test@test.com        |
| nickname   | nick       |
| password   | 123@aaaaaaA    |
| phone   | 112    |
| gender   | male    |
**response**
```json
{
    "message": "User registered successfully"
}
```
### (미구현) `POST /member/login`: 회원 로그인(인증)
### (미구현) `POST /member/logout`: 회원 로그아웃
### `GET /user/inquiry`: 단일 회원 상세 정보 조회
```
http://localhost:8080/user/inquiry
```
**params**
| Key      | Value |
| :--- | ---: |
| email      | test@test.com  |

**response**
```json
{
    "user": {
        "id": 1,
        "name": "john",
        "nickname": "nick",
        "phone": "112",
        "email": "test@test.com",
        "gender": "male"
    }
}
```
### `GET /user/orders/{user ID}`: 여러 회원 목록 조회
```
http://localhost:8080/user/orders/1
(1 - 회원 아이디)
```
**response**
```json
[
    {
        "order_number": "ORD001",
        "product_name": "Product A",
        "purchase_datetime": "2022-01-01 12:00:00",
        "created_at": "2023-02-23 11:14:00",
        "updated_at": "2023-02-23 11:14:00"
    },
    {
        "order_number": "ORD002",
        "product_name": "Product B",
        "purchase_datetime": "2022-01-02 14:30:00",
        "created_at": "2023-02-23 11:14:00",
        "updated_at": "2023-02-23 11:14:00"
    }
]

```
### `GET /users/search`: 여러 회원 목록 조회
```
http://localhost:8080/users/search
```
**params**
| Key      | Value |
| :--- | ---: |
| search      | test@test.com  |
| perPage    | 10  |
| page    | 1  |

**response**
```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "john",
            "email": "test@test.com",
            "gender": "male",
            "last_order": null
        }
    ],
    "first_page_url": "http://localhost:8080/users/search?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost:8080/users/search?page=1",
    "next_page_url": null,
    "path": "http://localhost:8080/users/search",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

## API 프로젝트 구조
```
├── README.md
├── app
├── artisan
├── bootstrap
├── composer.json
├── composer.lock
├── config
├── database
├── phpunit.xml
├── public
├── resources
├── routes
├── storage
├── tests
└── vendor

```
