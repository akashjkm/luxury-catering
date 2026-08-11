# Gourmet Affair — Admin Panel

## Login Credentials
- **Username:** `admin`
- **Password:** `admin123`
- **URL:** `https://yoursite.com/admin/login.php`

## Features

### 1. Dashboard
- Overview stats (Gallery images, Menu items, Testimonials, Content sections)
- Quick action links to major sections
- Current contact info preview

### 2. Images Manager
- Upload new images OR paste image URLs
- Manage images for:
  - Hero slides (3 slides)
  - About section images
  - Quality/Ingredients image
  - About page story images

### 3. Content Editor
- Edit text content for:
  - **Homepage:** Hero slides text, About section, Quality section, CTA banner
  - **About Page:** Story section text
- Tab-based navigation between pages

### 4. Contact Information
- Update: Site name, Phone numbers, Email, Address, Working hours
- Update all social media links (Facebook, Instagram, Twitter, LinkedIn, Pinterest)

### 5. Menu Manager
- 3 Categories: Contemporary European, Pan-Asian Fusion, Farm-to-Table
- Add new dishes
- Edit existing dishes
- Delete dishes
- Set name, description, and price

### 6. Testimonials
- Add client testimonials
- Edit name, company, quote, photo URL
- Delete testimonials
- Preview in table format

### 7. Gallery Manager
- Upload images or add by URL
- Set title and location for each image
- Delete images from gallery
- Grid preview of all gallery images

## Data Storage
All data is stored in JSON files (no database required):
- `admin/data/settings.json` — Contact info & social links
- `admin/data/content.json` — Page text content
- `admin/data/menu.json` — Menu items
- `admin/data/testimonials.json` — Client testimonials
- `admin/data/gallery.json` — Gallery images

Uploaded images are saved to: `admin/uploads/`

## How to Use
1. Go to `/admin/login.php`
2. Login with credentials above
3. Use sidebar to navigate between sections
4. Make changes and click "Save" or "Update"
5. Changes reflect immediately on the frontend

## Security Note
**IMPORTANT:** Change the default password in `admin/config.php` before going live:
```php
define('ADMIN_PASS', 'your-new-secure-password');
```
