# Single Form Mail

A simple PHP contact form with email functionality using PHPMailer. This project implements a volunteer signup form that collects contact information and volunteer preferences, then sends the submission via email.

## Features

- Contact form with required fields validation
- Volunteer preference checkboxes
- Email sending using SMTP via PHPMailer
- Environment variable configuration
- Input sanitization
- HTML email formatting

## Requirements

- PHP 7.4 or higher
- Composer
- SMTP server credentials

## Dependencies

- phpmailer/phpmailer (^6.10)
- vlucas/phpdotenv (^5.6)https://github.com/euitsol/single-form-mail.git

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/euitsol/single-form-mail.git or extract the project
   cd single-form-mail
   ```
2. Install dependencies:

   ```bash
   composer install
   ```
3. Configure environment variables:

   - Copy `.env.example` to `.env`
   - Update the following variables in `.env`:
     ```
     SMTP_HOST="your.smtp.host"
     SMTP_PORT=465
     SMTP_USERNAME="your.username"
     SMTP_PASSWORD="your.password"
     FROM_EMAIL="sender@email.com"
     FROM_NAME="Sender Name"
     TO_EMAIL="recipient@email.com"
     SMTP_DEBUG=true or false
     ```

## Usage

1. Start a PHP development server:

   ```bash
   php -S localhost:8000
   ```
2. Access the form at `http://localhost:8000/public`
3. Fill in the required fields:

   - Name
   - Email
   - Phone (optional)
   - Message
   - Select at least one volunteer preference

## Security

- Input data is sanitized using `htmlspecialchars()`
- Email addresses are validated
- SMTP credentials are stored in environment variables
- Form submission is protected against direct access

## License

This project is open-source and available under the MIT License.
