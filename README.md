<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# INVENET - Sistema de Inventario de Activos Informáticos ESCOM44

Este proyecto es una aplicación web para la gestión de dispositivos informáticos (nivel superior de ESCOM44). El backend está desarrollado en Laravel 12 mientras que el frontend usa Angular (no incluido en este repositorio). Este README proporciona las instrucciones para clonar e instalar el backend de INVENET en un nuevo entorno local.
https://docs.google.com/document/d/1kRb4DnY7cJMUtFtt3Aw5mOFR2Tkb6Jyl/edit?usp=sharing&ouid=114401228873545265277&rtpof=true&sd=true 
---

###  Requisitos del sistema

- PHP >= 8.2
- Composer
- MySQL (se recomienda usar **XAMPP** para facilitar la configuración)
- Git

## Instrucciones de Instalación

### Clona el repositorio desde GitHub
git clone https://github.com/celestebouvier/invenetBackend.git
cd invenet

composer install

## Crea el archivo env
cp .env.example .env

## Edita el archivo .env 

APP_NAME=invenetbackend
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invenetbackend
DB_USERNAME=root
DB_PASSWORD=   # Deja en blanco si usas XAMPP sin contraseña

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=09e00b13aa187d
MAIL_PASSWORD=****ea79
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@invenet.test
MAIL_FROM_NAME="Invenet"


## Activa el servidor Apache y MySQL en XAMPP

## Genera la clave de la aplicación tras crear el archivo .env
php artisan key:generate

## Base de datos
Abre phpMyAdmin
Importa esta base de datos: \database\backups\invenetbackend.sql

# Autenticación: Laravel Sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

## Para la generación de PDFs, se requiere instalar 
composer require barryvdh/laravel-dompdf

# Para la creación de etiquetas QR, instalar
composer require simplesoftwareio/simple-qrcode

# Inicia el servidor local. Esto iniciará el backend en http://localhost:8000. 
php artisan serve

## Ejecutar pruebas de la API con Postman
### Importar la colección de pruebas

1. Abre la aplicación Postman
2. Haz clic en el botón "Import"*
3. Selecciona la opción **"Upload Files"**
4. Busca y selecciona el archivo /tests/postman/invenet-api-tests.postman_collection.json

### Ejecutar las pruebas importadas

1. Abre la colección desde la pestaña **Collections**
2. Asegúrate de tener activo **XAMPP (Apache + MySQL)** y que la API Laravel esté corriendo en `http://localhost:8000`
3. Ejecuta las pruebas manualmente o mediante la opción **Run Collection**

