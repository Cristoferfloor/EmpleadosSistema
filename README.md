<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# EmpleadosSistema – Laravel 10

Este proyecto es una aplicación de gestión de empleados desarrollada como prueba técnica con **Laravel 10**. Permite:

- Listar empleados
- Buscar por nombre
- Agregar y editar datos personales y laborales
- Validar campos (correo, teléfono, etc.)
- Generar un reporte ordenable por columna
- Guardar todo en MySQL con migraciones y seeders

---


## 🚀 Requisitos

- PHP >= 8.1
- Composer
- MySQL
- Node.js y NPM (opcional para assets)
- Laravel 10

---

## ⚙️ Instalación del Proyecto

Sigue estos pasos para ejecutar el proyecto en tu entorno local:

### 1. Clonar el repositorio

```bash
git clone https://github.com/Cristoferfloor/EmpleadosSistema.git
cd EmpleadosSistema

### 2. Instalar dependencias de PHP

```bash
composer install

### 3. Copiar el archivo .env y configurar variables

```bash
cp .env.example .env

Edita el archivo .env con los datos correctos de tu base de datos MySQL:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

### 4. Generar la clave de la aplicación

```bash
php artisan key:generate

### 5.  Ejecutar migraciones y seeders

```bash
php artisan key:generate

### 5. Iniciar el servidor

```bash
php artisan serve
