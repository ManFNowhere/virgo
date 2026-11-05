# Virgo – Movie Streaming Platform

Virgo is a movie streaming web application I built to learn how a real-world
subscription product works from end to end: user accounts, content
management, external APIs and online payments.

**Live demo:** [tanwirkhalidm.com/projects/virgo](https://tanwirkhalidm.com/projects/virgo/)

> The live demo runs in **demo mode**: payments are disabled, so no real
> Stripe checkout is started.

---

## Features

- **Browse & discover**: home page with *New Releases*, *Top Free Movies* and
  *Most Watched* sections, a category page grouped by genre, and title search.
- **Movie details**: cast and crew are loaded live from the
  [TMDB API](https://developer.themoviedb.org/), so the database only stores
  the essentials.
- **User accounts**: registration, login, email verification, password reset
  and profile management (built on Laravel Breeze).
- **Free and premium content**: every movie is marked as free or premium.
  Premium movies can only be watched with an active subscription.
- **Subscriptions with Stripe**: monthly and yearly plans through
  Laravel Cashier and Stripe Checkout, including cancellation and
  webhook handling.
- **Watch statistics**: each user is counted once per movie to build the
  *Most Watched* list.
- **Admin area**: admins search TMDB for a movie, pick the right result and
  upload the trailer and video file.

## Tech Stack

| Layer      | Tools |
|------------|-------|
| Backend    | PHP 8.2+, Laravel 11, Laravel Breeze, Laravel Cashier |
| Frontend   | Blade, Tailwind CSS, Alpine.js, Vite |
| Database   | MySQL / MariaDB |
| Services   | Stripe (payments), TMDB API (movie data) |
| Deployment | Docker (Nginx + PHP-FPM + MariaDB) behind a reverse proxy |

## What I Learned

This project was a big step in my learning journey. The most valuable lessons were:

- **Payments are more than a checkout button.** Working with Stripe taught me
  about subscription states, webhooks, and why the server must verify a
  payment instead of trusting a redirect URL.
- **Consuming external APIs.** I fetch data from TMDB on demand and keep API
  keys in environment variables, never in the code.
- **Authorization matters as much as authentication.** Being logged in is not
  enough: premium content and admin pages need their own access checks.
- **Security basics in practice.** CSRF protection, rate limiting, and keeping
  secrets out of version control.
- **Deploying under a sub-path.** Running the app at `/projects/virgo` showed
  me why links should always be generated with `url()`, `route()` and
  `asset()` instead of being hard-coded.

## Getting Started (Local Development)

### Requirements

- PHP 8.2+ and Composer
- Node.js 20+ and npm
- MySQL or MariaDB
- A free [TMDB API key](https://www.themoviedb.org/settings/api)
- Optional: a [Stripe](https://stripe.com) test account and the Stripe CLI

### Installation

```bash
git clone https://github.com/ManFNowhere/Laravel.git
cd Laravel/virgo

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Fill in the database credentials and the keys below in `.env`, then run:

```bash
php artisan migrate --seed      # creates genres, sample movies and a local test user
php artisan storage:link
npm run dev                     # in one terminal
php artisan serve               # in another terminal
```

The app is now available at <http://localhost:8000>.

### Environment Variables

| Variable | Description |
|----------|-------------|
| `TMDB_TOKEN` | TMDB API read access token (Bearer) |
| `TMDB_API_KEY` | TMDB API key (v3), used for the movie search in the admin area |
| `ADMIN_EMAILS` | Comma-separated emails that can add movies at `/add` |
| `STRIPE_KEY`, `STRIPE_SECRET` | Stripe API keys. Leave empty to run in demo mode |
| `STRIPE_PRODUCT`, `STRIPE_MONTHLY`, `STRIPE_YEARLY` | Stripe product and price IDs for the plans |
| `STRIPE_WEBHOOK_SECRET` | Webhook signing secret. Webhook routes are disabled without it |

### Testing Payments Locally

With a Stripe test account, forward webhooks to your local app:

```bash
stripe listen --forward-to localhost:8000/webhook
```

Use Stripe's test card `4242 4242 4242 4242` with any future date and CVC.

## Project Status & Next Steps

Virgo is a learning project and still evolving. Ideas I want to work on next:

- Fix the profile edit page and clean up duplicated route names
- Add automated feature tests for subscriptions and access control
- A proper admin role instead of an email allow-list
- Video streaming with adaptive quality instead of direct file playback

Feedback and suggestions are always welcome!

## Author

**Tanwir Khalid**: [tanwirkhalidm.com](https://tanwirkhalidm.com) · [GitHub](https://github.com/ManFNowhere)
