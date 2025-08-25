# Project Documentation

## Overview

This is a PHP project starting with a Hello World page and expanding to include external database connectivity. The project demonstrates basic PHP functionality and database integration patterns.

## User Preferences

Preferred communication style: Simple, everyday language.
Language: Portuguese (Brasil)

## System Architecture

- **Frontend Architecture**: Simple PHP pages with embedded HTML and CSS
- **Backend Architecture**: PHP 8.4 with built-in development server on port 5000
- **Data Layer**: PDO-based database abstraction supporting external databases (MySQL, PostgreSQL, SQLite) + ReplDB key-value store integration
- **Configuration**: Centralized database configuration with security practices
- **File Structure**:
  - `index.php` - Main Hello World page with navigation links
  - `repldb.php` - ReplDB key-value store integration with HTTP requests
  - `config.php` - Secure database configuration supporting DATABASE_URL and individual credentials
  - `database_demo.php` - Interactive demo showing database connectivity
  - `database_examples.php` - Code examples for different database types
  - `planetscale.php` - Specialized page for PlanetScale MySQL connection
  - `neon.php` - Specialized page for Neon PostgreSQL connection with DATABASE_URL
  - `aulas/conn/local.php` - Local MySQL connection class (fixed close() method)
  - `aulas/teste/local.php` - Local database testing interface

## External Dependencies

- **Database Systems**: Primary support for Neon PostgreSQL (using DATABASE_URL), also supports PlanetScale MySQL, SQLite, and ReplDB key-value store
- **Development Tools**: PHP 8.4 built-in development server
- **Runtime Dependencies**: 
  - PHP PDO extension with PostgreSQL SSL support for Neon
  - Built-in PHP extensions for MySQL, PostgreSQL, and SQLite support
  - PHP cURL extension for ReplDB HTTP requests
- **Security**: Environment variables (Replit Secrets) for credential management, DATABASE_URL parsing

## Recent Changes (August 25, 2025)

- ✅ Created PHP Hello World page with server info display
- ✅ Added external database connectivity examples  
- ✅ Implemented secure database configuration using Replit Secrets
- ✅ Created specialized PlanetScale connection page with SSL support
- ✅ Migrated to Neon PostgreSQL with DATABASE_URL support
- ✅ Added DATABASE_URL parsing and fallback to individual credentials
- ✅ Created comprehensive Neon-specific interface with PostgreSQL examples
- ✅ Fixed critical syntax error in conn.php (undefined method close())
- ✅ Added ReplDB integration with HTTP-based key-value operations
- ✅ Created interactive ReplDB interface for testing CRUD operations