# App Laravel

This repository contains a Laravel application

## 🚀 Installation

**To install the application on your machine, follow the steps below:**

```bash
git clone https://github.com/oGuilherme1/project-with-laravel.git
```

```bash
cp .env.example .env
```
Set these values ​​in your .env with your data
- DB_DATABASE=your_database `Default: laravel`
- DB_USERNAME=your_username `Default: root`
- DB_PASSWORD=your_password `Default: r00t`

```bash
docker-compose up -d
```

```bash
docker exec -it laravel_container bash
```

```bash
php artisan key:generate
```

Wait a few seconds for the laravel server to start, otherwise the command below displays a connection error

```bash
php artisan migrate
```
CreateUser will throw an error due to the UserCreated event, you just need to comment out the line

-37 $this->dispatchEvent($aUser)

It's in the file Src\Users\Application\UseCases\User\CreateUserUseCase 

```bash
php artisan test
```

```bash
php artisan horizon
```

Access the page [http://localhost:8000](http://localhost:8000) in your browser.

## 📡 Endpoints 

#### Create user

- **Method**: POST
- **URL**: http://localhost:8000/api/user

```json
{
	"name": "teste",
	"email": "teste@gmail.com",
	"password":"0102030405",
	"document":"55064360096",
	"user_type": "COMMOM" {"COMMOM or SHOPKEEPER"}
}
```

#### Login

- **Method**: POST
- **URL**: http://localhost:8000/api/login

```json
{
	"email": "teste@gmail.com",
	"password":"0102030405",
}
```

#### Transfer

- **Method**: POST
- **URL**: http://localhost:8000/api/transfer
- **Token required**: `Authorization: Bearer {TOKEN}`

```json
{
  "value": 5.0,
  "payer": 4,
  "payee": 3
}
```


#### Get Balance 

- **Method**: GET
- **URL**: http://localhost:8000/api/wallet/balance/1
- **Token required**: `Authorization: Bearer {TOKEN}`

```json
{

}
```

#### Get User Type

- **Method**: GET
- **URL**: http://localhost:8000/api/user/type/1
- **Token required**: `Authorization: Bearer {TOKEN}`

```json
{
}
```

## 🛠️ Technologies Used

- PHP (version 8.2)
- Laravel (version 11)
- Redis (latest version from Docker)
- MySQL (latest version from Docker)
