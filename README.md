# Secure Software Development - Vulnerable Version
(Gazi Üniversitesi - Bilişim Güvenliği Teknolojisi bölümünün Güvenli Yazılım Geliştirme dersi dönem ödevi için yapılmış zafiyetli web uygulamasıdır.)
(Secure version https://github.com/akindemirsec/GuvenliYazilimGelistirmeDonemOdeviSecure)

## Features

- User authentication with plain text passwords
- Product listing and search functionality
- Cart management
- Profile management with image upload
- Admin features for adding, editing, and deleting products

## Vulnerabilities

This application intentionally contains several common web application vulnerabilities:

1. **SQL Injection**: The search functionality is vulnerable to SQL injection attacks.
2. **Cross-Site Scripting (XSS)**: User inputs are not properly sanitized, making the application vulnerable to XSS attacks.
3. **Cross-Site Request Forgery (CSRF)**: Forms do not include CSRF tokens, allowing CSRF attacks.
4. **Insecure File Upload**: Profile image uploads lack proper validation and sanitization.

