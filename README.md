# UPEI Engineering Society Application

This is a Laravel application for the UPEI Engineering Society, built with a modern stack including Laravel, Inertia.js, and Vue.js.

## Technologies Used

*   **PHP**: 8.5.1
*   **Laravel Framework**: v12
*   **Inertia.js (Laravel Adapter)**: v2
*   **@inertiajs/vue3**: v2
*   **Vue.js**: v3
*   **Tailwind CSS**: v4
*   **Laravel Prompts**: v0
*   **Tightenco/ziggy**: v2
*   **Laravel MCP**: v0
*   **Laravel Pint**: v1
*   **Laravel Sail**: v1
*   **PHPUnit**: v11
*   **ESLint**: v9
*   **Prettier**: v3

## Getting Started

### Prerequisites

*   PHP >= 8.5.1
*   Composer
*   Node.js & npm

### Installation

1.  **Clone the repository:**

    ```bash
      git clone git@github.com:UPEIENGN/upei-engn.git
      cd upei-engn
    ```

2.  **Install PHP Dependencies:**

    ```bash
      composer install
    ```

3.  **Install Node Dependencies:**

    ```bash
      npm install
    ```

4.  **Copy Environment File:**

    ```bash
      cp .env.example .env
    ```

5.  **Generate Application Key:**

    ```bash
      php artisan key:generate
    ```

6.  **Configure Environment Variables:**
    Edit the `.env` file to set up your database connection and other environment-specific variables.

7.  **Start the Development Server:**

    ```bash
      composer run dev
    ```

    Access the application at `http://localhost:8000` (or the URL specified by `php artisan serve`).

8.  **Run Migrations:**

    ```bash
      php artisan migrate:fresh --seed
    ```

## Running Tests

To run PHPUnit tests:

```bash
  php artisan test
```

## Code Formatting

This project uses Laravel Pint and Prettier for code formatting. To ensure your code adheres to the project's style guidelines, run the following commands before committing:

```bash
  ./vendor/bin/pint
  npm run format
```
