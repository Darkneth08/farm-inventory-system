# Chapter 3: User Interface Manual and Feature Highlights

## X. User Interface Manual

The Farm Supply Inventory System does not use a single generic dashboard for everyone. It uses a shared application shell with role-based landing views and role-based navigation. This chapter now follows the real interface flow of the current system.

### 1. Opening the System

1. Open the Farm Supply Inventory landing page in a browser.
2. Review the public sections such as `Features`, `Why It Works`, `FAQ`, `Get Started`, and `Contact`.
3. Click `Log In` to open the login form or `Create Account` to register.

Public interface components:

- landing navigation bar
- hero section with product preview
- feature cards
- login and registration actions

### 2. Logging In

1. Enter email and password.
2. Click `Login`.
3. Wait for the system to validate the credentials.

System response:

- Valid credentials open the protected app shell.
- Invalid credentials show an error alert.
- The initial view depends on role:
  `customer` -> `Customer Home`
  `staff` -> `Staff Desk`
  `manager`, `admin`, `super_admin` -> `Dashboard`

### 3. Shared Application Shell

After authentication, the user enters the main app shell.

Shared interface components:

- left sidebar with brand title, subtitle, and role-mode pill
- role-aware menu buttons
- top header with current view title and subtitle
- current user information box
- `Refresh` button
- `Logout` button

The sidebar can show these menu labels depending on role:

- `Dashboard`
- `Staff Desk`
- `Home`
- `Shop`
- `My Orders`
- `Favorites`
- `Profile`
- `POS` or `POS Counter`
- `Operations`
- `Reports` or `Shift Reports`
- `Users`
- `Super Admin`

### 4. Admin Dashboard

The real `Dashboard` screen is used for manager, admin, and super admin workflows.

Main dashboard components:

- `Admin overview` guide panel
- shortcut buttons such as `Open Stock Tasks` and `Open Reports`
- workflow strip: `Watch`, `Update`, `Review`
- KPI cards for `Products`, `Active Products`, `Low Stock`, `Out Of Stock`, `Inventory Value`, `Today Sales`, `Month Sales`, `Total Suppliers`, and `Total Branches`
- `Low-Stock Watch` table
- `Recent Activity` list
- `Top Movers` table
- `Stock by Category` table
- `Monthly Sales` table

How users interact with it:

- Review stock risk and recent movement first
- Open `Operations` for stock and setup tasks
- Open `Reports` for movement, sales, and governance review

### 5. Staff Desk

The real default staff landing view is `Staff Desk`.

Main staff components:

- `Staff Operations Hub` hero panel
- `Open POS` button
- `Shift Snapshot`
- `Next steps`
- metric cards for active products, low-stock alerts, today sales, and branches
- `Low-Stock Watch`
- `Recent Movement`
- `POS Snapshot`

This page is designed to reduce clutter and send staff quickly into checkout, stock checking, and receiving tasks.

### 6. Customer Home

The real default customer landing view is `Customer Home`.

Main customer-home components:

- top mini navigation: `Overview`, `Steps`, `Quick Tools`, `Delivery`
- welcome hero and action buttons
- metrics for `Products`, `Cart`, `Active Orders`, and `Favorites`
- delivery profile card
- `Start Here` panel
- `Main customer tools` panel
- `Delivery Details` panel

This home screen is designed to prepare the customer before opening the full customer workspace.

### 7. Customer Workspace

The `Customer Workspace` is the main shopping and order-tracking area. It uses four real sections:

- `Browse`
- `Orders`
- `Favorites`
- `Profile`

#### 7.1 Browse

The `Browse` section is divided into three real workflow cards:

1. `Browse products`
2. `Review product`
3. `Checkout`

Main components:

- catalog search input
- stock-status filter
- sort dropdown
- product cards with `View`, `Favorite`, and `Add to Cart`
- product spotlight card with price, category, supplier, stock, and customer reviews
- cart panel with quantity controls
- payment method selector: `COD`, `Cash`, `Online Payment`
- optional promotion code
- delivery note textarea
- `Place COD order`, `Place cash order`, or `Place online order` button

#### 7.2 Orders

The `Orders` section contains:

- tracking summary chips
- live tracking cards
- order table
- `Need something else?` request form
- request history table

This section allows customers to view order status, reorder previous items, and submit product requests.

#### 7.3 Favorites

The `Favorites` section contains:

- `Saved for later`
- `Low-stock alerts`
- `Updates`
- `Seasonal picks`

This section helps customers keep products, stock alerts, notifications, and seasonal suggestions together in one screen.

#### 7.4 Profile

The `Profile` section contains:

- profile form for name, email, phone, and address
- password update form
- product review form

This section keeps delivery details ready for checkout and supports customer feedback submission.

### 8. POS Counter

The real POS screen is the dedicated staff sales transaction view.

Main POS components:

- `POS Workspace` hero
- live warehouse label and stock-source note
- step strip: `Select warehouse`, `Add products`, `Complete payment`
- warehouse selector
- product search
- live product catalog cards
- checkout form
- discount and payment controls
- sale cart with editable quantity inputs
- summary chips for items, subtotal, discount, grand total, amount tendered, balance due, change, and payment status
- `Complete Sale` button
- `Sale result` card
- `Print Last Receipt`
- `Recent POS Sales`

This is the actual main transaction screen used for counter checkout.

### 9. Operations Workspace

The `Operations` view is organized into real tab sections:

- `Setup`
- `Product Catalog`
- `Stock Adjustment`
- `Inventory Summary`
- `Batch Health`
- `Receiving`
- `Orders`
- `Branches`

#### 9.1 Setup

- category form
- supplier form
- warehouse form

#### 9.2 Product Catalog

- product form
- catalog list table
- `Quick Stock In / Out` transaction form

#### 9.3 Stock Adjustment

- preset buttons such as `Damage Deduct`, `Expired Deduct`, and `Correction Add`
- draft summary chips
- adjustment form
- adjustment draft table
- posted adjustment history table

#### 9.4 Inventory Summary

- chips for batches, products, units, inventory value, retail value, low stock, expiring, and zero stock
- status breakdown chips
- warehouse inventory table

#### 9.5 Batch Health

- warehouse and status filters
- search and aging threshold controls
- batch status update form
- aging metrics
- batch table
- aging table

#### 9.6 Receiving

- `Supply Deliveries` form
- delivery item draft table
- draft total
- `Record Delivery` action
- `Recent Stock Receipts` table

#### 9.7 Orders

- `Order Management` filters and table
- `Promotions` form and promotion table

#### 9.8 Branches

- `Smart Forecasting`
- `Multi-Branch Management`
- `Branch Inventory Overview`

### 10. Reports Workspace

The `Reports` view is organized into four real report groups:

- `Inventory`
- `Sales`
- `Access Logs`
- `Settings`

#### 10.1 Inventory

- `Movement Summary`
- `Expiring Stock`

#### 10.2 Sales

- `Sales Report`
- `Top Selling Products`
- `Inventory Value`
- `Low Stock Report`

#### 10.3 Access Logs

- `Login Activities`
- `Audit Logs`

#### 10.4 Settings

- `Settings & Backup`
- `Safeguards`

### 11. Users Workspace

The `Users` screen uses two real tabs:

- `Team Directory`
- `Editor`

Main interface components:

- account filter form
- user table with `Edit` and `Delete`
- account creation and editing form
- role selection for `customer`, `staff`, `manager`, `admin`, and `super_admin`

### 12. Super Admin Workspace

The `Super Admin` view is organized into these real control areas:

- `Overview`
- `Setup`
- `Product Catalog`
- `Stock Flow`
- `Inventory Summary`
- `User Accounts`
- `Security`
- `Logs`

Typical components include:

- KPI overview cards
- role distribution table
- shortcut cards
- setup counts
- product and stock summary cards
- user-account actions
- security tools
- log and activity panels

### 13. Logging Out

1. Click `Logout` from the top header.
2. Wait for the session to close.
3. The system returns the user to the public landing view.

### Main Interface Components

| Component | Purpose | Actual Use in the System |
| --- | --- | --- |
| Sidebar menu | Role-based module access | Opens Dashboard, Staff Desk, Customer Home, POS, Operations, Reports, Users, or Super Admin |
| Top header | Context and session control | Shows active view title, subtitle, user box, refresh, and logout |
| Guide panels | Workflow orientation | Used in Dashboard, Operations, Reports, and Super Admin |
| KPI cards and chips | Quick metrics | Used in Dashboard, Staff Desk, Customer Home, Inventory Summary, and Super Admin |
| Data tables | Record review and monitoring | Used for products, inventory, orders, promotions, receipts, reports, logs, and users |
| Form panels | Transaction and maintenance input | Used in POS, setup, stock adjustment, receiving, checkout, profile, and user management |
| Status badges | Visual feedback | Used for stock condition, order status, login status, and role labels |
| Success and notice panels | User feedback | Used for checkout, POS result, and form submission feedback |

## XI. Feature Highlights

The current system combines public access, role-based dashboards, sales, stock management, reporting, and governance in one Laravel-based interface.

| Feature | Actual Screen or Workflow | User Need or Workflow Benefit | Laravel Application |
| --- | --- | --- | --- |
| Role-based landing views | `Customer Home`, `Staff Desk`, `Dashboard` | Sends each role to the correct starting workspace | Sanctum auth, middleware, role checks |
| Shared application shell | Sidebar + top header | Keeps navigation and session controls consistent | Blade structure, dynamic state handling |
| Admin dashboard | `dashboardView` | Shows stock risk, movement, category stock, and sales trends at a glance | Dashboard controller, Eloquent queries, reporting endpoints |
| Staff desk | `staffHomeView` | Gives staff quick access to checkout, stock alerts, and shift data | Role-aware rendering, shared dashboard data |
| Customer workspace | `customerView` with `Browse`, `Orders`, `Favorites`, `Profile` | Supports product browsing, ordering, tracking, favorites, delivery profile, and reviews | Protected customer routes, validation, Eloquent relations |
| POS counter | `posView` | Handles fast warehouse-based checkout with cash, GCash, and discount support | Validation, file uploads, DB transactions, stock deduction logic |
| Operations workspace | `operationsView` | Centralizes setup, catalog, adjustments, inventory, receiving, order management, forecasting, and branches | CRUD controllers, transaction logs, inventory endpoints |
| Reports workspace | `reportsView` | Groups inventory, sales, access logs, and settings into one reporting area | Report controllers, query builders, governance endpoints |
| Users workspace | `usersView` | Helps admins create, edit, filter, and manage accounts | User controller, access control, form validation |
| Super Admin control center | `superAdminView` | Supports high-level oversight for setup, stock, accounts, security, and logs | Super admin routes, audit logs, token control, security reporting |

In summary, the actual user experience of the Farm Supply Inventory System is role-based and workspace-driven. The interface is not limited to one dashboard. It starts with the correct home screen for each role, then branches into dedicated modules for shopping, checkout, POS, operations, reports, user administration, and super admin governance.
