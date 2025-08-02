# Gimmy.site Refactoring Roadmap

This document outlines the necessary steps to refactor the gimy.site application for a more robust and scalable architecture.

## 1. Database Schema Refactoring

- [x] **Sites Table:**
  -   [x] `subdomain` (string, unique) - The chosen subdomain for the site.
  -   [x] `user_id` (foreign key to users) - The owner of the site.
  -   [x] `is_public` (boolean, default: false) - Whether the site is publicly accessible.
  -   [x] `custom_domain` (string, nullable) - Optional custom domain for the site.
  -   [x] `settings` (json, nullable) - Site-specific settings (e.g., theme, analytics).

- [x] **Pages Table:**
  -   [x] `site_id` (foreign key to sites) - The site this page belongs to.
  -   [x] `slug` (string) - The URL slug for the page (e.g., "/about").
  -   [x] `title` (string) - The title of the page.
  -   [x] `content` (longtext) - The HTML content of the page.
  -   [x] `is_homepage` (boolean, default: false) - Whether this is the site's homepage.
  -   [x] `meta_description` (string, nullable) - SEO meta description.
  -   [x] `meta_keywords` (string, nullable) - SEO meta keywords.

- [x] **Assets Table:**
  -   [x] `site_id` (foreign key to sites) - The site this asset belongs to.
  -   [x] `path` (string) - The path to the asset within the site's storage.
  -   [x] `filename` (string) - The original filename of the asset.
  -   [x] `mime_type` (string) - The MIME type of the asset.
  -   [x] `size` (integer) - The size of the asset in bytes.

## 2. Model Updates

- [x] **Site Model:**
  -   [x] Define relationships: `hasMany(Page::class)`, `hasMany(Asset::class)`, `belongsTo(User::class)`.
  -   [x] Add casts for `settings` (json).
- [x] **Page Model:**
  -   [x] Define relationship: `belongsTo(Site::class)`.
- [x] **Asset Model:**
  -   [x] Define relationship: `belongsTo(Site::class)`.

## 3. Controller Refactoring

- [x] **SiteController:**
  -   [x] `index`: List all sites for the authenticated user.
  -   [x] `create`: Show the form to create a new site.
  -   [x] `store`: Store a new site.
  -   [x] `edit`: Show the form to edit a site.
  -   [x] `update`: Update a site's settings.
  -   [x] `destroy`: Delete a site.
- [x] **PageController:**
  -   [x] `index`: List all pages for a given site.
  -   [x] `create`: Show the form to create a new page.
  -   [x] `store`: Store a new page.
  -   [x] `edit`: Show the form to edit a page.
  -   [x] `update`: Update a page's content and settings.
  -   [x] `destroy`: Delete a page.
- [x] **AssetController:**
  -   [x] `index`: List all assets for a given site.
  -   [x] `create`: Show the form to upload a new asset.
  -   [x] `store`: Store a new asset.
  -   [x] `destroy`: Delete an asset.

## 4. Policy Updates

- [x] **SitePolicy:**
  -   [x] `viewAny`: Allow users to view their own sites.
  -   [x] `view`: Allow users to view a specific site they own.
  -   [x] `create`: Allow users to create a new site.
  -   [x] `update`: Allow users to update their own sites.
  -   [x] `delete`: Allow users to delete their own sites.
- [x] **PagePolicy:**
  -   [x] `viewAny`: Allow users to view pages of a site they own.
  -   [x] `view`: Allow users to view a specific page of a site they own.
  -   [x] `create`: Allow users to create a page for a site they own.
  -   [x] `update`: Allow users to update a page of a site they own.
  -   [x] `delete`: Allow users to delete a page of a site they own.
- [x] **AssetPolicy:**
  -   [x] `viewAny`: Allow users to view assets of a site they own.
  -   [x] `view`: Allow users to view a specific asset of a site they own.
  -   [x] `create`: Allow users to upload an asset for a site they own.
  -   [x] `delete`: Allow users to delete an asset of a site they own.

## 5. Route Updates

- [x] **web.php:**
  -   [x] Refactor routes to use resource controllers for sites, pages, and assets.
  -   [x] Ensure subdomain routing is correctly configured to display the public-facing sites.
- [x] **subdomain.php:**
  -   [x] Implement the logic to display the correct site and page based on the subdomain.
