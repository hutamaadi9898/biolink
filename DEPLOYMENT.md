# Deployment Configuration

## Environment Variables Required

### Staging Environment
```bash
# Application
APP_NAME="Biolink ID (Staging)"
APP_ENV=staging
APP_DEBUG=false
APP_URL=https://staging.biolink.id

# Database
DB_CONNECTION=pgsql
DB_HOST=staging-db-host
DB_PORT=5432
DB_DATABASE=biolink_staging
DB_USERNAME=biolink_user
DB_PASSWORD=secure_password

# Redis
REDIS_HOST=staging-redis-host
REDIS_PASSWORD=redis_password
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=staging_mail_user
MAIL_PASSWORD=staging_mail_pass

# Storage
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=staging_access_key
AWS_SECRET_ACCESS_KEY=staging_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=biolink-staging
```

### Production Environment
```bash
# Application
APP_NAME="Biolink ID"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://biolink.id

# Database (Managed PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=prod-db-cluster.region.rds.amazonaws.com
DB_PORT=5432
DB_DATABASE=biolink_production
DB_USERNAME=biolink_prod_user
DB_PASSWORD=super_secure_password

# Redis (Managed)
REDIS_HOST=prod-redis-cluster.region.cache.amazonaws.com
REDIS_PASSWORD=redis_production_password
REDIS_PORT=6379

# Mail (Production service)
MAIL_MAILER=ses
AWS_SES_REGION=us-east-1

# Storage (Production S3)
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=production_access_key
AWS_SECRET_ACCESS_KEY=production_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=biolink-production
AWS_URL=https://cdn.biolink.id

# Analytics & Monitoring
SENTRY_LARAVEL_DSN=https://your-sentry-dsn@sentry.io/project

# Performance
OCTANE_SERVER=swoole
REDIS_CLIENT=phpredis
```

## Deployment Scripts

### Zero-Downtime Deployment Script
```bash
#!/bin/bash
set -e

echo "🚀 Starting deployment..."

# Variables
DEPLOY_PATH="/var/www/biolink"
REPO_URL="git@github.com:hutamaadi9898/biolink.git"
BRANCH="main"

# Create new release directory
RELEASE_DIR="$DEPLOY_PATH/releases/$(date +%Y%m%d%H%M%S)"
mkdir -p $RELEASE_DIR

# Clone repository
git clone --branch $BRANCH --depth 1 $REPO_URL $RELEASE_DIR

# Enter release directory
cd $RELEASE_DIR

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction
npm ci
npm run build

# Copy environment file
cp $DEPLOY_PATH/.env $RELEASE_DIR/.env

# Link storage
ln -nfs $DEPLOY_PATH/storage $RELEASE_DIR/storage

# Generate optimized autoloader
php artisan optimize

# Run database migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Switch to new release
ln -nfs $RELEASE_DIR $DEPLOY_PATH/current

# Reload PHP-FPM or restart server
sudo systemctl reload php8.4-fpm
sudo systemctl reload nginx

# Clean up old releases (keep last 5)
cd $DEPLOY_PATH/releases && ls -t | tail -n +6 | xargs rm -rf

echo "✅ Deployment completed successfully!"
```

### Health Check Script
```bash
#!/bin/bash

# Health check endpoints
ENDPOINTS=(
    "https://biolink.id/health"
    "https://biolink.id/api/health"
)

for endpoint in "${ENDPOINTS[@]}"; do
    echo "Checking $endpoint..."
    
    response=$(curl -s -o /dev/null -w "%{http_code}" $endpoint)
    
    if [ $response -eq 200 ]; then
        echo "✅ $endpoint is healthy"
    else
        echo "❌ $endpoint returned $response"
        exit 1
    fi
done

echo "🎉 All health checks passed!"
```

## Server Requirements

### Minimum Server Specifications
- **CPU**: 2 vCPUs
- **RAM**: 4GB
- **Storage**: 20GB SSD
- **Bandwidth**: 1TB/month

### Recommended Production Specifications
- **CPU**: 4 vCPUs
- **RAM**: 8GB
- **Storage**: 100GB SSD
- **Bandwidth**: Unlimited
- **Load Balancer**: Yes
- **CDN**: CloudFlare or AWS CloudFront

### Software Requirements
- **OS**: Ubuntu 22.04 LTS
- **Web Server**: Nginx 1.20+
- **PHP**: 8.4 with extensions (pdo_pgsql, redis, gd, zip, xml, mbstring)
- **Database**: PostgreSQL 15+
- **Cache**: Redis 7+
- **Node.js**: 22+ (for build process)
- **SSL**: Let's Encrypt or commercial certificate

## Monitoring & Alerting

### Key Metrics to Monitor
- Application response time
- Database query performance
- Memory and CPU usage
- Disk space utilization
- Error rates and exceptions
- User registration and activity rates

### Recommended Tools
- **Application Monitoring**: Laravel Telescope + Sentry
- **Infrastructure Monitoring**: New Relic or DataDog
- **Uptime Monitoring**: UptimeRobot or Pingdom
- **Log Management**: ELK Stack or Papertrail

## Backup Strategy

### Database Backups
- **Frequency**: Daily automated backups
- **Retention**: 30 days point-in-time recovery
- **Storage**: Encrypted backups in separate region
- **Testing**: Monthly backup restoration tests

### File Storage Backups
- **User uploads**: Versioned S3 with cross-region replication
- **Application files**: Git repository + deployment artifacts
- **Configuration**: Encrypted secrets management

## Security Considerations

### SSL/TLS
- Force HTTPS for all traffic
- HSTS headers enabled
- Strong cipher suites only

### Application Security
- Regular security updates
- Input validation and sanitization
- CSRF protection enabled
- Rate limiting on API endpoints
- Regular penetration testing

### Infrastructure Security
- VPC with private subnets for database
- WAF (Web Application Firewall)
- DDoS protection
- Regular security patches
- SSH key-based authentication only
