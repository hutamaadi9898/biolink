# Contributing to Biolink ID

Thank you for your interest in contributing to Biolink ID! This document provides guidelines and information for contributors.

## 🚀 Getting Started

### Prerequisites
- PHP 8.4+
- Node.js 22+
- Composer
- Git

### Local Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/hutamaadi9898/biolink.git
   cd biolink
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run dev
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

## 📋 How to Contribute

### Reporting Issues
1. Check existing issues to avoid duplicates
2. Use the appropriate issue template
3. Provide detailed information and steps to reproduce
4. Include screenshots/videos when applicable

### Feature Requests
1. Check the [ROADMAP.md](ROADMAP.md) for planned features
2. Use the feature request template
3. Explain the use case and benefits
4. Consider implementation complexity

### Code Contributions

#### Branch Naming Convention
- `feature/description` - New features
- `bugfix/description` - Bug fixes
- `hotfix/description` - Critical fixes
- `refactor/description` - Code refactoring
- `docs/description` - Documentation updates

#### Pull Request Process
1. Fork the repository
2. Create a feature branch from `develop`
3. Make your changes following our coding standards
4. Write/update tests for your changes
5. Ensure all tests pass
6. Update documentation if needed
7. Submit a pull request to `develop` branch

## 🎨 Coding Standards

### PHP (Laravel)
- Follow PSR-12 coding standard
- Use Laravel Pint for code formatting: `./vendor/bin/pint`
- Write feature tests for new functionality
- Use Eloquent relationships over raw queries
- Follow Laravel naming conventions

### Frontend (Vue.js + TypeScript)
- Use TypeScript for all new components
- Follow Vue 3 Composition API patterns
- Use TailwindCSS for styling
- Write semantic HTML with accessibility in mind
- Optimize for mobile-first responsive design

### Database
- Use descriptive migration names
- Include rollback logic in migrations
- Use factories for test data
- Follow Laravel naming conventions for tables and columns

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/LinkManagementTest.php

# Run with coverage
php artisan test --coverage

# Run browser tests
php artisan dusk
```

### Writing Tests
- Write feature tests for user-facing functionality
- Write unit tests for complex business logic
- Use Pest testing framework
- Mock external dependencies
- Aim for >80% code coverage

### Test Structure
```php
it('can create a new link', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->post('/links', [
            'title' => 'Test Link',
            'url' => 'https://example.com',
        ]);
    
    $response->assertRedirect('/dashboard/links');
    $this->assertDatabaseHas('links', [
        'title' => 'Test Link',
        'user_id' => $user->id,
    ]);
});
```

## 📚 Development Guidelines

### Performance Considerations
- Optimize database queries (avoid N+1 problems)
- Use eager loading for relationships
- Implement proper caching strategies
- Optimize images and assets
- Follow mobile-first design principles

### Security Best Practices
- Validate all user inputs
- Use Laravel's built-in security features
- Sanitize data before database storage
- Implement proper authentication and authorization
- Follow OWASP security guidelines

### Accessibility
- Use semantic HTML elements
- Provide proper ARIA labels
- Ensure keyboard navigation works
- Maintain color contrast ratios
- Test with screen readers

## 🏗️ Architecture Decisions

### Backend (Laravel)
- Use Inertia.js for seamless SPA experience
- Implement repository pattern for complex queries
- Use Laravel's queue system for heavy operations
- Follow SOLID principles
- Implement proper error handling and logging

### Frontend (Vue.js)
- Use TypeScript for type safety
- Implement proper component composition
- Use Pinia for state management (if needed)
- Follow Vue.js style guide
- Implement proper error boundaries

### Database Design
- Normalize data structure appropriately
- Use proper indexing for performance
- Implement soft deletes where appropriate
- Use UUID for public-facing IDs
- Design for scalability

## 🔄 Deployment

### Staging Environment
- All PRs are automatically deployed to staging
- Manual testing required before production
- Database migrations tested thoroughly

### Production Deployment
- Zero-downtime deployment strategy
- Database migrations run automatically
- Asset compilation and optimization
- Cache clearing and warming

## 📖 Documentation

### Code Documentation
- Use PHPDoc for PHP functions/classes
- Use JSDoc for TypeScript functions
- Document complex business logic
- Include usage examples

### API Documentation
- Document all API endpoints
- Include request/response examples
- Specify authentication requirements
- Document rate limiting

## 🎯 Feature Development Process

1. **Planning**
   - Review roadmap and priorities
   - Create GitHub issue with detailed specification
   - Discuss implementation approach
   - Estimate development time

2. **Development**
   - Create feature branch
   - Implement functionality with tests
   - Update documentation
   - Code review process

3. **Testing**
   - Automated test suite
   - Manual testing on staging
   - User acceptance testing
   - Performance testing

4. **Deployment**
   - Deploy to staging environment
   - Final testing and approval
   - Production deployment
   - Monitor for issues

## 🚨 Emergency Procedures

### Critical Bug Fixes
1. Create hotfix branch from `main`
2. Implement minimal fix with tests
3. Fast-track code review
4. Deploy to production immediately
5. Create post-mortem documentation

### Security Issues
1. **DO NOT** create public issues for security vulnerabilities
2. Email security concerns to: security@biolink.id
3. Wait for acknowledgment before disclosure
4. Follow responsible disclosure timeline

## 💬 Community

### Communication Channels
- GitHub Issues: Bug reports and feature requests
- GitHub Discussions: General questions and ideas
- Pull Request Reviews: Code-related discussions

### Code of Conduct
- Be respectful and inclusive
- Provide constructive feedback
- Help newcomers get started
- Follow GitHub community guidelines

## 📝 License

By contributing to Biolink ID, you agree that your contributions will be licensed under the same license as the project.

---

Thank you for contributing to Biolink ID! 🎉
