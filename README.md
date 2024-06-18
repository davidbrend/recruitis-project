
# Recruitis Project

Recruitis is a Symfony-based project built on the Symfony Skeleton framework. It uses dotenv-vault for managing environment variables securely.

The primary function of the project is a connection to Recruitis API through the Symfony package davebrend/recruitis-api-project to get jobs and visualize them in listing on the website.


## Requirements

- PHP 8.1 or higher
- Composer
- NPM
- Symfony CLI
- Dotenv-vault

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/davidbrend/recruitis-project.git
    cd recruitis-project
    ```

2. **Install dependencies:**

    Composer
    ```bash
    composer install
    ```

    NPM
    ```bash
    npm install
    ```

3. **Set up environment variables:**

    - Install dotenv-vault via Homebrew:

        ```bash
        brew install dotenv-org/brew/dotenv-vault
        ```

    - Pull your environment variables securely:

        ```bash
        npx dotenv-vault@latest pull
        ```

4. **Start the server:**

    ```bash
    symfony server:start
    ```

   Your project should now be running at `https://localhost:8000`