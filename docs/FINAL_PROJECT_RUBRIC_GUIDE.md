# Final Project Rubric Guide

Use this guide when recording and submitting the Farm Supply Inventory System.

## 1. System Functionality Demonstration

Show these working modules:

- Public landing page and login/register flow
- Customer portal: catalog, cart, orders, favorites, requests, reviews, notifications, profile
- Staff portal: POS checkout, recent sales, warehouse stock awareness
- Operations: categories, suppliers, warehouses, products, branches, promotions, stock receipts, inventory adjustments
- Reports: low stock, sales, inventory value, expiring stock, movement summary, business overview
- Super admin: users, roles, account status, permissions, login activity, audit logs, settings, backup/export

## 2. Video Organization And Flow

Recommended sequence:

1. Introduce the system purpose and target users.
2. Show the ERD and explain how the tables connect.
3. Log in as `superadmin@farm.com`.
4. Demonstrate CRUD using Products, Categories, Suppliers, Warehouses, Branches, Promotions, and Users.
5. Demonstrate POS checkout and inventory deduction.
6. Demonstrate stock receiving and inventory adjustment.
7. Demonstrate customer ordering and customer request flow.
8. Show reports, audit logs, and validation/error handling.
9. End with GitHub link, deployed Render link, and demo credentials.

## 3. ERD Explanation And Alignment

Main database flow:

- `users` connects to roles, orders, sales, login activities, audit logs, requests, favorites, reviews, and notifications.
- `categories`, `suppliers`, and `products` define the catalog.
- `warehouses`, `branches`, and `inventory` track where stock is stored and how much is available.
- `transactions`, `stock_receipts`, and `stock_receipt_items` record stock movement and receiving.
- `sales` and `sale_items` record POS transactions.
- `orders` and `order_items` record customer checkout activity.
- `promotions`, `product_reviews`, and `user_notifications` support engagement and customer communication.

ERD files:

- `docs/Farm_Supply_Inventory_System_ERD_Labeled.drawio`
- `docs/Farm_Supply_Inventory_System_ERD.md`

## 4. CRUD Operations To Show

Show create, read, update, and delete where available:

- Products
- Categories
- Suppliers
- Warehouses
- Branches
- Promotions
- Users
- Inventory batches and status updates
- Customer requests and favorites

## 5. Data Flow And System Logic

Explain these flows:

- Product setup creates catalog data used by customers, POS, reports, and inventory.
- Stock receipts increase inventory and create traceable batches.
- POS checkout validates stock, creates a sale, creates sale items, deducts inventory, and records transactions.
- Customer checkout creates orders and order items for staff/admin processing.
- Reports aggregate transactions, sales, product stock, batches, and warehouse data.
- Super admin views audit logs and login activity for accountability.

## 6. User Interface And Usability

Point out:

- Role-based dashboards
- Responsive layout
- Clear forms and filters
- Status badges for stock, orders, users, and inventory batches
- Separate customer, staff, operations, reports, users, and super admin workspaces

## 7. System Integration

Demonstrate that:

- Blade/JavaScript UI calls Laravel API routes.
- Laravel controllers validate requests and update the database.
- Models and relationships connect frontend screens to the ERD.
- Reports and dashboards read live database records.

## 8. Validation And Error Handling

Show examples:

- Invalid login is rejected.
- Required form fields show errors.
- Protected routes return `401`.
- Insufficient roles return `403`.
- POS checkout blocks insufficient stock.
- Inventory transfer blocks invalid warehouse movement.
- User deletion prevents deleting yourself or the final super admin.

## 9. Communication And Explanation

Use short, direct explanations:

- What problem the system solves
- Who uses each module
- What table records each action
- What validation protects the workflow
- What changed after each action

## 10. Submission Completeness

Submit:

- GitHub repository link: `https://github.com/Darkneth08/farm-inventory-system`
- Render live link: add the final Render URL after deployment
- Demo credentials:
  - Super admin: `superadmin@farm.com` / `password`
  - Admin: `admin@farm.com` / `password`
  - Manager: `manager@farm.com` / `password`
  - Staff: `staff@farm.com` / `password`
  - Customer: `customer@farm.com` / `password`
- Video demonstration following the sequence above
