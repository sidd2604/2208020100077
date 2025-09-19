#  URL Shortener - Usage Guide

## Overview

This is a **Laravel-based URL Shortener Microservice**. It allows you to:

- Create short URLs with optional custom shortcodes
- Set expiry time for each short URL
- Track click statistics including referrer and location
- Redirect users from short URL to original URL

The backend API is **ready-to-use**, lightweight, and fully functional.

---

##  Installation & Setup

1. **Clone the repository:**

```bash
git clone https://github.com/sidd2604/2208020100077.git
cd urlshortner


composer install
cp .env.example .env
php artisan key:generate
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=urlshortener
DB_USERNAME=phpmyadmin
DB_PASSWORD=893305

php artisan migrate
php artisan serve


POST /api/shorturls

{
  "url": "https://google.com/search?q=laravel",
  "validity": 30,           
  "shortcode": "myshort"    
}

RESPONSE


{
  "shortLink": "http://localhost:8000/myshort",
  "expiry": "2025-09-19T16:10:00Z"
}
