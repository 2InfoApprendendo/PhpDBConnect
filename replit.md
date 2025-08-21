# Project Documentation

## Overview

This is a PHP project starting with a Hello World page and expanding to include external database connectivity. The project demonstrates basic PHP functionality and database integration patterns.

## User Preferences

Preferred communication style: Simple, everyday language.
Language: Portuguese (Brasil)

## System Architecture

- **Frontend Architecture**: Simple PHP pages with embedded HTML and CSS
- **Backend Architecture**: PHP 8.4 with built-in development server on port 5000
- **Data Layer**: PDO-based database abstraction supporting external databases (MySQL, PostgreSQL, SQLite)
- **Configuration**: Centralized database configuration with security practices
- **File Structure**:
  - `index.php` - Main Hello World page
  - `config.php` - Secure database configuration using environment variables
  - `database_demo.php` - Interactive demo showing database connectivity
  - `database_examples.php` - Code examples for different database types
  - `planetscale.php` - Specialized page for PlanetScale MySQL connection

## External Dependencies

- **Database Systems**: Primary support for PlanetScale MySQL, also supports PostgreSQL and SQLite
- **Development Tools**: PHP 8.4 built-in development server
- **Runtime Dependencies**: 
  - PHP PDO extension with MySQL SSL support for PlanetScale
  - Built-in PHP extensions for MySQL, PostgreSQL, and SQLite support
- **Security**: Environment variables (Replit Secrets) for credential management

## Recent Changes (August 21, 2025)

- ✅ Created PHP Hello World page with server info display
- ✅ Added external database connectivity examples  
- ✅ Implemented secure database configuration using Replit Secrets
- ✅ Created specialized PlanetScale connection page with SSL support
- ✅ Added comprehensive status checking and error reporting
- ✅ Configured MySQL PDO options for PlanetScale compatibility