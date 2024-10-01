
## Subscription Platform

An API that allows users to subscribe to different websites and receive email notifications when new posts are available. 

## Features

- RESTful APIs for creating new subscribers to a website, and posts for a particular website.
- Uses queues to schedule sending emails in the background.
- Use command `push:email-updates` to send post updates to subscribers of all websites via email.
- No duplicate stories is sent to a subscriber using `is_sent` flag
- Seeded data of the websites, subscribers and posts.
- Using Postman to document and guide developer on usage. 
- Implemented dependency injection via contracts and services
- Supports MySQL database and SMTP email service.

## Future Features
- Use Redis to cache subscribers and posts immediately a new post or subscriber is created.
- Add app/Events/PostCreated event and app/Listeners/SendPostEmailNotification listener
- Register the event and listener in EventServiceProvider `$listen` property. 
- Anytime a post is created, it triggers the listener which sends an email to all subscribers

## Prerequisites

Before setting up the project, ensure you have the following installed on your local or remote environment:

- PHP (Version 7.4 or later)
- Composer
- MySQL
- SMTP Server (e.g., Mailtrap for local testing)

## Installation

1. **Clone the Repository**:

   ```bash
   git clone https://github.com/steve-jr/subscription-platform
   cd subscription-platform
   ```

2. **Create Environment File**:

   ```bash
   cp .env.example .env
   ```

3. **Install Dependencies**:

   ```bash
   composer install
   ```

4. **Generate Application Key**:

   ```bash
   php artisan key:generate
   ```

5. **Set Up the Database**:

   Create a MySQL database and update the `.env` file with your database credentials:

   Run the migrations and seed the database:

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Set Up Queues**:
7. 
   ```bash
   php artisan queue:table
   php artisan migrate
   ```

7. **Configure Mail Settings**:

   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ENCRYPTION=null
   MAIL_FROM_ADDRESS=no-reply@subscription-platform.com
   MAIL_FROM_NAME="Subscription Platform"
   ```

8. **Start the Application**:

   ```bash
   php artisan serve
   ```

   The server should be running at `http://127.0.0.1:8000`.

9. **Run the Send Email Command**:

   ```bash
   php artisan push:email-updates
   ```

10. **Start the Queue Worker**:

    ```bash
    php artisan queue:listen
    ```

## API Endpoints

- **subscribe a user to a website**: `POST /api/subscribers`
- **create a new post**: `POST /api/posts`

Refer to the Postman collection https://www.postman.com/dark-telescopedia/workspace/inisev-subscription/collection/502750-926069a1-d68c-47ea-8f99-5efa6fae288d?action=share&creator=502750&active-environment=502750-dcf36f7a-d15f-40e4-9e9f-80ac6cc9ee2a.
