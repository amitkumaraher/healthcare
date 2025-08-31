# Healthcare Project (Laravel + Docker)

This project is a Laravel application running inside Docker with MySQL as the database.

---

## Getting Started

1. Clone the Repository
git clone https://github.com/amitkumaraher/healthcare.git
cd healthcare

2. Copy the example environment file:
  cp .env.example .env
3. Update the .env file for Docker MySQL service:
    DB_CONNECTION=mysql
   DB_HOST=healthcare-db
   DB_PORT=3306
   DB_DATABASE=healthcare
   DB_USERNAME=root
   DB_PASSWORD=root

4. Build and Start Docker Containers
     docker compose up -d --build
     GO to the container 
     docker compose exec -it healthcare-app bash

5, composer install
    php artisan migrate
    php artisan db:seed
    generate application key
    Access the app
    using below apis


curl --location --request POST 'http://localhost:8080/api/register' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data-raw '{
   "name":"Amit",
   "email":"amit12@gmail.com",
   "password":"12345678",
   "password_confirmation":"12345678"
}
'



curl --location --request POST 'http://localhost:8080/api/login' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "email": "alice@example.com",
    "password": "12345"
}'

curl --location --request GET 'http://localhost:8080/api/professionals' \
--header 'Authorization: Bearer 13|MwdzDg2gXnisHwYMg126PKM91rk3v9di2IrzcfGv6bfe1572'


curl --location --request POST 'http://localhost:8080/api/appointments' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 13|MwdzDg2gXnisHwYMg126PKM91rk3v9di2IrzcfGv6bfe1572' \
--header 'Content-Type: application/json' \
--data-raw '{
    "user_id": "9",
    "healthcare_professional_id": "19",
    "appointment_start_time": "2025/01/11 22:30",
    "appointment_end_time": "2025/01/11 23:30",
    "status": "booked"
}'


curl --location --request GET 'http://localhost:8080/api/appointments' \
--header 'Authorization: Bearer 13|MwdzDg2gXnisHwYMg126PKM91rk3v9di2IrzcfGv6bfe1572'

curl --location --request POST 'http://localhost:8080/api/appointments/1/cancel' \
--header 'Authorization: Bearer 13|MwdzDg2gXnisHwYMg126PKM91rk3v9di2IrzcfGv6bfe1572' \





