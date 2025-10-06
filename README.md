# Cloudbay Friendly Errors

A Laravel package that replaces ugly 500 error pages with **friendly, non-technical error screens**.  
It shows a unique **incident ID** (logged + displayed), optional **business context** (like the item and submitter), and clear **next steps** for users (support contacts, retry/back buttons).  

Works out of the box for both **web** and **API** responses.  
Perfect for FIQCUConnect, SPA, SeyCCAT, Vendly, or any Laravel project.

---

## 🚀 Features

- Generates a **unique incident ID** for every request (logged + shown).
- **Friendly 500 page** with human wording (not a stack trace).
- Configurable **support contacts**: email, phone, WhatsApp, docs link, business hours.
- Optional **context resolver**: shows what item/request caused the error and who submitted it.
- Works for **web** and **API** (returns JSON if `Accept: application/json`).
- Easily **customizable views and config**.
- Zero app `Handler.php` overrides (safe middleware-based).
- PSR-4 autoloaded + Laravel auto-discovery.

---

## 📦 Installation

Require the package via Composer:

```bash
composer require cloudbay/friendly-errors
